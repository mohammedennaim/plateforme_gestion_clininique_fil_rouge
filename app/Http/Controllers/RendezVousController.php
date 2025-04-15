<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class RendezVousController extends Controller
{
    public function create(){
        // dd('hello');
        if (auth()->user()) {
            $user = User::where('role', 'patient')->get()[0];
            $patient = Patient::where('user_id', auth()->user()->id)->first();
            $appointments = Appointment::where('patient_id', $patient->id)->get();
            $doctors = User::where('role', 'doctor')->get();
            $appointment = $appointments->whereNotNull('date')->sortBy('date')->last();
            $doctor = Doctor::where('id', $appointment->doctor_id)->first();
            $medecinDernierVisit = User::where('id', $doctor->user_id)->first();
            $speciality = Speciality::all();
            // dd($medecinDernierVisit);
            // dd($speciality);
            return view('/patient/reserver' , compact('user', 'patient', 'appointments', 'doctors', 'appointment', 'medecinDernierVisit', 'speciality'));
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

    /**
     * Affiche les détails du rendez-vous après le paiement
     */
    public function showAppointmentDetails($appointment_id)
    {
        // Récupérer le rendez-vous
        $appointment = Appointment::findOrFail($appointment_id);
        
        // Récupérer les informations associées
        $doctor = Doctor::with('user', 'speciality')->findOrFail($appointment->doctor_id);
        $patient = Patient::with('user')->findOrFail($appointment->patient_id);
        
        // Si l'utilisateur est authentifié, vérifier qu'il est bien le propriétaire du rendez-vous
        if (auth()->check()) {
            $currentPatient = Patient::where('user_id', auth()->id())->first();
            if ($currentPatient && $currentPatient->id !== $appointment->patient_id) {
                return redirect()->route('home')->with('error', 'Vous n\'avez pas accès à ce rendez-vous');
            }
        }
        
        return view('patient.appointment-details', compact('appointment', 'doctor', 'patient'));
    }
    
    /**
     * Annuler un rendez-vous
     */
    public function cancelAppointment($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        
        // Vérifier que l'utilisateur peut annuler ce rendez-vous
        if (auth()->check()) {
            $currentPatient = Patient::where('user_id', auth()->id())->first();
            if ($currentPatient && $currentPatient->id !== $appointment->patient_id) {
                return redirect()->route('home')->with('error', 'Vous n\'avez pas accès à ce rendez-vous');
            }
        }
        
        // Mettre à jour le statut
        $appointment->status = 'canceled';
        $appointment->save();
        
        return redirect()->back()->with('success', 'Votre rendez-vous a été annulé avec succès');
    }
}
