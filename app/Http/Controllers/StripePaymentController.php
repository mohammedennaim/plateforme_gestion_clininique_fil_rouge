<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
        return view('patient.payment', [
            'appointmentId' => $request->query('appointment_id')
        ]);
    }

    /**
     * Process the payment
     */
    public function processPayment(Request $request)
    {
        try {
            // Get the payment method ID from the request
            $paymentMethodId = $request->input('payment_method_id');
            $amount = $request->input('amount', 45); // Default amount 45 euros
            $currency = $request->input('currency', 'EUR');
            $description = $request->input('description', 'Consultation médicale');
            $appointmentId = $request->input('appointment_id');
            
            // Convert amount to cents (Stripe requires amount in cents)
            $amountInCents = $amount * 100;
            
            // Calculer l'URL de retour en cas de redirection
            $returnUrl = url('/payment') . (empty($appointmentId) ? '' : "?appointment_id=$appointmentId");
            
            // Create a PaymentIntent with the payment method
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => $currency,
                'description' => $description,
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'return_url' => $returnUrl
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
            Log::error('Stripe API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Confirm the payment after 3D Secure authentication
     */
    public function confirmPayment(Request $request)
    {
        try {
            $paymentIntentId = $request->input('payment_intent_id');
            $appointmentId = $request->input('appointment_id');
            
            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            // If payment intent already succeeded, just return success
            if ($paymentIntent->status === 'succeeded') {
                $this->savePaymentRecord($paymentIntent, $appointmentId);
                
                return response()->json([
                    'success' => true,
                    'transaction_id' => $paymentIntent->id,
                    'status' => $paymentIntent->status
                ]);
            }
            
            // Confirm the payment intent if it's not already confirmed
            if ($paymentIntent->status !== 'canceled') {
                $paymentIntent->confirm();
            }
            
            if ($paymentIntent->status === 'succeeded') {
                $this->savePaymentRecord($paymentIntent, $appointmentId);
                
                return response()->json([
                    'success' => true,
                    'transaction_id' => $paymentIntent->id
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
        }
    }
    
    /**
     * Check the status of a payment
     */
    public function checkPaymentStatus(Request $request)
    {
        try {
            $paymentIntentId = $request->input('payment_intent_id');
            
            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
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
        }
    }
    
    /**
     * Save payment record to database
     */
    private function savePaymentRecord($paymentIntent, $appointmentId = null)
    {
        try {
            // Create a new payment record
            $payment = new Payment();
            $payment->transaction_id = $paymentIntent->id;
            $payment->amount = $paymentIntent->amount / 100; // Convert back from cents
            $payment->currency = $paymentIntent->currency;
            $payment->status = $paymentIntent->status;
            $payment->payment_method = 'stripe';
            $payment->description = $paymentIntent->description ?? 'Consultation médicale';
            
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
                    $appointment->paiement = true;
                    $appointment->save();
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
     * Affiche la page de succès après un paiement réussi
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showSuccessPage(Request $request)
    {
        // Récupérer l'ID de transaction du paiement depuis la requête
        $transactionId = $request->query('transaction_id');
        $appointmentId = $request->query('appointment_id');
        
        // Récupérer le paiement associé
        $payment = Payment::where('transaction_id', $transactionId)->first();
        
        if (!$payment) {
            return redirect()->route('payment.show')
                ->with('error', 'Nous n\'avons pas pu trouver les détails de votre paiement.');
        }
        
        // Récupérer le rendez-vous associé
        $appointment = null;
        if ($appointmentId) {
            $appointment = Appointment::with(['doctor.user', 'patient.user'])->find($appointmentId);
        } else if ($payment->appointment_id) {
            $appointment = Appointment::with(['doctor.user', 'patient.user'])->find($payment->appointment_id);
        }
        
        if (!$appointment) {
            return redirect()->route('payment.show')->with('error', 'Nous n\'avons pas pu trouver les détails de votre rendez-vous.');
        }
        
        // Mettre à jour le statut du rendez-vous si le paiement est réussi
        if ($payment->status === 'succeeded') {
            app(RendezVousController::class)->processAfterPayment($appointment->id);
            
            // Redirection vers la page de détails avec un message de succès
            return redirect()->route('patient.appointment.details', ['appointment_id' => $appointment->id])
                ->with('success', 'true');
        }
        
        // Passer à la vue les informations nécessaires dans le cas où le processAfterPayment ne gère pas la redirection
        return view('patient.appointment-details', [
            'payment' => $payment,
            'appointment' => $appointment
        ]);
    }
}
