<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        // Utiliser config() au lieu de env() pour une meilleure fiabilité
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Show the payment page
     */
    public function showPaymentPage(Request $request)
    {
        
        $appointmentId = Appointment::all()->last()->id;
        $user = auth()->user();
        
        
        // Vérifier si le rendez-vous existe
        if ($appointmentId) {
            $appointment = Appointment::find($appointmentId);
            if (!$appointment) {
                return redirect()->route('home')->with('error', 'Rendez-vous introuvable');
            }
        }
        // dd($appointmentId);
        
        return view('patient.payment',compact('user', 'appointmentId'));
    }

    /**
     * Process the payment
     */
    public function processPayment(Request $request)
    {
        try {
            // Valider les données entrantes
            $validated = $request->validate([
                'payment_method_id' => 'required|string',
                'amount' => 'nullable|numeric|min:1',
                'currency' => 'nullable|string|size:3',
                'description' => 'nullable|string',
                'appointment_id' => 'nullable|exists:appointments,id'
            ]);
            
            // Get the payment method ID from the request
            $paymentMethodId = $validated['payment_method_id'];
            $amount = $validated['amount'] ?? 45; // Default amount 45 euros
            $currency = $validated['currency'] ?? 'EUR';
            $description = $validated['description'] ?? 'Consultation médicale';
            $appointmentId = $validated['appointment_id'] ?? null;
            
            // Convert amount to cents (Stripe requires amount in cents)
            $amountInCents = (int)($amount * 100);
            
            // Créer les metadata pour le PaymentIntent
            $metadata = [
                'appointment_id' => $appointmentId,
                'application' => 'MediClinic',
                'environment' => app()->environment()
            ];
            
            // Calculer l'URL de retour en cas de redirection
            $returnUrl = url('/payment/confirm') . (empty($appointmentId) ? '' : "?appointment_id=$appointmentId");
            
            try {
                // Create a PaymentIntent with the payment method
                $paymentIntent = PaymentIntent::create([
                    'amount' => $amountInCents,
                    'currency' => $currency,
                    'description' => $description,
                    'payment_method' => $paymentMethodId,
                    'confirm' => true,
                    'return_url' => $returnUrl,
                    'metadata' => $metadata,
                    // Utiliser uniquement automatic_payment_methods, pas payment_method_types
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                ]);
                
                // Handle the result
                if ($paymentIntent->status === 'succeeded') {
                    // Payment successful without additional authentication
                    $this->savePaymentRecord($paymentIntent, $appointmentId);
                    
                    return response()->json([
                        'success' => true,
                        'transaction_id' => $paymentIntent->id,
                        'status' => $paymentIntent->status
                    ]);
                    
                } else if ($paymentIntent->status === 'requires_action' && 
                          isset($paymentIntent->next_action) &&
                          $paymentIntent->next_action->type === 'use_stripe_sdk') {
                    // 3D Secure authentication required
                    return response()->json([
                        'success' => false,
                        'requires_action' => true,
                        'payment_intent_client_secret' => $paymentIntent->client_secret
                    ]);
                    
                } else {
                    // Payment in other state (processing, etc)
                    return response()->json([
                        'success' => false,
                        'payment_intent_id' => $paymentIntent->id,
                        'message' => 'Le paiement est en cours de traitement'
                    ]);
                }
            } catch (ApiErrorException $e) {
                // Gérer spécifiquement les erreurs Stripe API
                Log::error('Stripe API Error during payment intent creation: ' . $e->getMessage());
                return response()->json([
                    'success' => false, 
                    'message' => 'Erreur lors du traitement de votre carte: ' . $e->getMessage()
                ], 400); // Code 400 au lieu de 500 pour les erreurs de carte
            }
            
        } catch (ApiErrorException $e) {
            Log::error('Stripe API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Erreur de paiement: ' . $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            Log::error('General payment error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement du paiement. Veuillez réessayer.'
            ], 500);
        }
    }
    
    /**
     * Confirm the payment after 3D Secure authentication
     */
    public function confirmPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_intent_id' => 'required|string',
                'appointment_id' => 'nullable|exists:appointments,id'
            ]);
            
            $paymentIntentId = $validated['payment_intent_id'];
            $appointmentId = $validated['appointment_id'] ?? null;
            
            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            // If payment intent already succeeded, just return success
            if ($paymentIntent->status === 'succeeded') {
                $payment = $this->savePaymentRecord($paymentIntent, $appointmentId);
                
                return response()->json([
                    'success' => true,
                    'transaction_id' => $paymentIntent->id,
                    'status' => $paymentIntent->status,
                    'payment_id' => $payment ? $payment->id : null
                ]);
            }
            
            // Confirm the payment intent if it's not already confirmed
            if ($paymentIntent->status !== 'canceled') {
                $paymentIntent->confirm();
            }
            
            if ($paymentIntent->status === 'succeeded') {
                $payment = $this->savePaymentRecord($paymentIntent, $appointmentId);
                
                return response()->json([
                    'success' => true,
                    'transaction_id' => $paymentIntent->id,
                    'payment_id' => $payment ? $payment->id : null
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'La confirmation du paiement a échoué',
                    'status' => $paymentIntent->status
                ]);
            }
            
        } catch (ApiErrorException $e) {
            Log::error('Stripe Confirmation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('General confirmation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la confirmation du paiement'
            ], 500);
        }
    }
    
    /**
     * Check the status of a payment
     */
    public function checkPaymentStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_intent_id' => 'required|string'
            ]);
            
            $paymentIntentId = $validated['payment_intent_id'];
            
            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            // If the payment succeeded, ensure we have a record
            if ($paymentIntent->status === 'succeeded') {
                $appointmentId = $paymentIntent->metadata->appointment_id ?? null;
                $this->savePaymentRecord($paymentIntent, $appointmentId);
            }
            
            // Return the status
            return response()->json([
                'success' => true,
                'status' => $paymentIntent->status
            ]);
            
        } catch (ApiErrorException $e) {
            Log::error('Stripe Status Check Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('General status check error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la vérification du paiement'
            ], 500);
        }
    }
    
    /**
     * Save payment record to database
     */
    private function savePaymentRecord($paymentIntent, $appointmentId = null)
    {
        try {
            // Check if we already have a record for this payment
            $existingPayment = Payment::where('transaction_id', $paymentIntent->id)->first();
            if ($existingPayment) {
                // Update the status if needed
                if ($existingPayment->status !== $paymentIntent->status) {
                    $existingPayment->status = $paymentIntent->status;
                    $existingPayment->save();
                }
                return $existingPayment;
            }
            
            // Create a new payment record
            $payment = new Payment();
            $payment->user_id = Patient::with('user')->get()->last()->id;
            $payment->appointment_id = Appointment::get()->last()->id;
            $payment->transaction_id = $paymentIntent->id;
            $payment->amount = $paymentIntent->amount / 100; // Convert back from cents
            $payment->currency = $paymentIntent->currency;
            $payment->status = $paymentIntent->status;
            $payment->payment_method = 'stripe';
            $payment->description = $paymentIntent->description ?? 'Consultation médicale';
            
            // Récupérer l'ID du rendez-vous depuis les métadonnées si disponible
            if (!$appointmentId && isset($paymentIntent->metadata->appointment_id)) {
                $appointmentId = $paymentIntent->metadata->appointment_id;
            }
            
            // Récupérer l'utilisateur connecté si disponible
            if (auth()->check()) {
                $payment->user_id = auth()->id();
            }
            
            // If we have an appointment ID, link the payment to the appointment
            if ($appointmentId) {
                $appointment = Appointment::find($appointmentId);
                if ($appointment) {
                    $payment->appointment_id = $appointmentId;
                    
                    // Si aucun utilisateur n'est connecté, utiliser l'utilisateur du rendez-vous
                    if (!$payment->user_id && $appointment->user_id) {
                        $payment->user_id = $appointment->user_id;
                    }
                    
                    // Update the appointment payment status
                    if ($payment->status === 'succeeded') {
                        $appointment->paiement = true;
                        $appointment->save();
                        
                        // Traiter les actions post-paiement si nécessaire
                        $this->processAppointmentAfterPayment($appointment);
                    }
                }
            }
            
            $payment->save();
            
            return $payment;
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas interrompre le flux
            Log::error('Erreur lors de l\'enregistrement du paiement: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Process appointment related actions after payment
     */
    private function processAppointmentAfterPayment(Appointment $appointment)
    {
        try {
            // Si un contrôleur de rendez-vous existe, traiter les actions post-paiement
            if (class_exists(RendezVousController::class)) {
                app(RendezVousController::class)->processAfterPayment($appointment->id);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement post-paiement: ' . $e->getMessage());
        }
    }

    /**
     * Affiche la page de succès après un paiement réussi
     * 
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showSuccessPage(Request $request)
    {
        // Récupérer l'ID de transaction du paiement depuis la requête
        $transactionId = $request->query('transaction_id');
        $appointmentId = $request->query('appointment_id');
        
        // Vérifier si nous avons un ID de transaction
        if (!$transactionId) {
            return redirect()->route('home')
                ->with('error', 'Aucune information de paiement trouvée');
        }
        
        // Récupérer le paiement associé
        $payment = Payment::where('transaction_id', $transactionId)->first();
        
        if (!$payment) {
            // Essayer de récupérer depuis Stripe directement
            try {
                $paymentIntent = PaymentIntent::retrieve($transactionId);
                if ($paymentIntent->status === 'succeeded') {
                    $appointmentId = $paymentIntent->metadata->appointment_id ?? $appointmentId;
                    $payment = $this->savePaymentRecord($paymentIntent, $appointmentId);
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de la récupération du paiement depuis Stripe: ' . $e->getMessage());
            }
            
            if (!$payment) {
                return redirect()->route('patient.payment')
                    ->with('error', 'Nous n\'avons pas pu trouver les détails de votre paiement.');
            }
        }
        
        // Récupérer le rendez-vous associé
        $appointment = null;
        if ($appointmentId) {
            $appointment = Appointment::with(['doctor.user', 'patient.user'])->find($appointmentId);
        } else if ($payment->appointment_id) {
            $appointment = Appointment::with(['doctor.user', 'patient.user'])->find($payment->appointment_id);
        }
        
        if (!$appointment) {
            return redirect()->route('home')->with('success', 'Paiement réussi. Merci pour votre achat.');
        }
        
        // Redirection vers la page de détails avec un message de succès
        return redirect()->route('patient.appointment.details', ['appointment_id' => $appointment->id])
            ->with('success', 'Paiement effectué avec succès');
    }
}