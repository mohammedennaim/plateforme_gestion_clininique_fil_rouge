<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function create(){
        // dd('hello');
        if (auth()->user()) {
            $user = User::where('role', 'patient')->get()[0];
            $patient = Patient::where('user_id', auth()->user()->id)->first();
            $appointment = Appointment::where('patient_id', $patient->id)->get()->last();
            $doctors = User::where('role', 'doctor')->get();
            $speciality = Speciality::all();
            // $appointment = $appointments->where('patient_id', auth()->user()->id)->whereNotNull('date')->sortBy('date')->last();
            if ($appointment != null) {
                $doctor = Doctor::where('id', $appointment->doctor_id)->first();
                $medecinDernierVisit = User::where('id', $doctor->user_id)->first();
                // dd($medecinDernierVisit);
                
                return view('patient.reserver' , compact('user', 'patient', 'doctors', 'appointment', 'medecinDernierVisit', 'speciality'));
            }
            // dd($appointment);
            $speciality = Speciality::all();
            return view('patient.reserver' , compact('user', 'patient', 'appointments', 'appointment', 'speciality'));
            // dd($medecinDernierVisit);
            // dd($speciality);
        }
        return view('patient.reserverSansAuth');

    }

    public function payment(){
        if(auth()->user()){
            // return redirect('/login');
            $patient = Patient::where('user_id', auth()->user()->id)->first();
            $appointments = Appointment::where('patient_id', $patient->id)->get();
            $doctors = User::where('role', 'doctor')->get();
            return view('patient.payment' , compact('patient', 'appointments', 'doctors'));
        }
        // $date_appointment = $appointments->where('date', '!=', null)->format('d/m/Y');
        return view('patient.payment');
    }

    public function showAppointmentDetails($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $doctor = Doctor::with('user', 'speciality')->findOrFail($appointment->doctor_id);
        $patient = Patient::with('user')->findOrFail($appointment->patient_id);
        
        if (auth()->check()) {
            $currentPatient = Patient::where('user_id', auth()->id())->first();
            if ($currentPatient && $currentPatient->id !== $appointment->patient_id) {
                return redirect()->route('home')->with('error', 'Vous n\'avez pas accès à ce rendez-vous');
            }
        }
        
        return view('patient.appointment-details', compact('appointment', 'doctor', 'patient'));
    }
    
    public function cancelAppointment($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        
        if (auth()->check()) {
            $currentPatient = Patient::where('user_id', auth()->id())->first();
            if ($currentPatient && $currentPatient->id !== $appointment->patient_id) {
                return redirect()->route('home')->with('error', 'Vous n\'avez pas accès à ce rendez-vous');
            }
        }
        
        $appointment->status = 'canceled';
        $appointment->save();
        
        return redirect()->back()->with('success', 'Votre rendez-vous a été annulé avec succès');
    }

    /**
     * Enregistre une nouvelle réservation dans la base de données
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'reason' => 'nullable|string|max:255',
            'urgency' => 'nullable|string|in:normal,soon,urgent',
            'notes' => 'nullable|string',
        ]);

        // Créer un nouveau rendez-vous
        $appointment = new Appointment();
        $appointment->doctor_id = $validatedData['doctor_id'];
        $appointment->date = $validatedData['date'];
        $appointment->time = $validatedData['time'];
        $appointment->reason = $validatedData['reason'] ?? null;
        $appointment->status = 'pending'; // Définir un statut par défaut
        $appointment->price = 0; // Vous pouvez définir un prix par défaut ou le calculer plus tard

        // Si l'utilisateur est authentifié, associer le patient
        if (auth()->check()) {
            $patient = Patient::where('user_id', auth()->id())->first();
            if ($patient) {
                $appointment->patient_id = $patient->id;
            } else {
                // Créer un nouveau patient si nécessaire
                if ($request->has('patient_info')) {
                    $patientInfo = $request->input('patient_info');
                    $patient = $this->createOrUpdatePatient($patientInfo);
                    $appointment->patient_id = $patient->id;
                } else {
                    return redirect()->back()->with('error', 'Informations du patient manquantes');
                }
            }
        } else {
            // Pour les utilisateurs non authentifiés, créer un patient temporaire
            if ($request->has('patient_info')) {
                $patientInfo = $request->input('patient_info');
                $patient = $this->createOrUpdatePatient($patientInfo);
                $appointment->patient_id = $patient->id;
            } else {
                return redirect()->back()->with('error', 'Informations du patient manquantes');
            }
        }

        // Sauvegarder le rendez-vous
        $appointment->save();

        // Rediriger vers la page de paiement avec l'ID du rendez-vous
        return redirect()->route('patient.payment', ['patient' => $appointment->patient_id])
            ->with('appointment_id', $appointment->id)
            ->with('success', 'Votre rendez-vous a été enregistré. Procédez au paiement pour confirmer.');
    }

    /**
     * Créer ou mettre à jour un patient à partir des données du formulaire
     */
    private function createOrUpdatePatient($patientInfo)
    {
        // Vérifier si un utilisateur avec cet email existe déjà
        $user = User::where('email', $patientInfo['email'])->first();
        
        if (!$user) {
            // Créer un nouvel utilisateur si aucun n'existe
            $user = new User();
            $user->name = $patientInfo['name'];
            $user->email = $patientInfo['email'];
            $user->phone = $patientInfo['phone'] ?? null;
            $user->date_of_birth = $patientInfo['birthdate'] ?? null;
            $user->password = bcrypt('123456'); // Mot de passe par défaut
            $user->role = 'patient';
            $user->save();
        }
        
        // Vérifier si un patient associé à cet utilisateur existe
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            // Créer un nouveau patient
            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->name_assurance = $patientInfo['name_assurance'] ?? null;
            $patient->assurance_number = $patientInfo['assurance_number'] ?? null;
            $patient->blood_type = $patientInfo['blood_type'] ?? null;
            $patient->emergency_contact = $patientInfo['emergency_contact'] ?? null;
            $patient->save();
        }
        
        return $patient;
    }

    /**
     * Traite les données après un paiement réussi
     */
    public function processAfterPayment($appointment_id)
    {
        // Récupérer le rendez-vous
        $appointment = Appointment::findOrFail($appointment_id);
        
        // Mettre à jour le statut du rendez-vous
        $appointment->status = 'confirmed';
        $appointment->paiement = true;
        $appointment->save();
        
        // Envoyer une notification par email (vous pouvez implémenter cette fonctionnalité plus tard)
        // $this->sendAppointmentConfirmationEmail($appointment);
        
        // Rediriger vers la page de détails du rendez-vous
        return redirect()->route('patient.appointment.details', ['appointment_id' => $appointment->id])
            ->with('success', 'true');
    }
}
