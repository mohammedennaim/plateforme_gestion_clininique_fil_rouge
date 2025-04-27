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


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'reason' => 'nullable|string|max:255',            
        ]);

        $appointment = new Appointment();
        $appointment->doctor_id = $validatedData['doctor_id'];
        $appointment->date = $validatedData['date'];
        $appointment->time = $validatedData['time'];
        $appointment->reason = $validatedData['reason'] ?? null;
        $appointment->status = 'pending';
        $appointment->price = 0;
        
        if (auth()->check()) {
            $patient = Patient::where('user_id', auth()->id())->first();
            if ($patient) {
                $appointment->patient_id = $patient->id;
            } else {
                if ($request->has('patient_info')) {
                    $patientInfo = $request->input('patient_info');
                    $patient = $this->createOrUpdatePatient($patientInfo);
                    $appointment->patient_id = $patient->id;
                } else {
                    return redirect()->back()->with('error', 'Informations du patient manquantes');
                }
            }
        } else {
            if ($request->has('patient_info')) {
                $patientInfo = $request->input('patient_info');
                $patient = $this->createOrUpdatePatient($patientInfo);
                $appointment->patient_id = $patient->id;
            } else {
                return redirect()->back()->with('error', 'Informations du patient manquantes');
            }
        }

        $appointment->save();

        return redirect()->route('patient.payment', ['patient' => $appointment->patient_id])
            ->with('appointment_id', $appointment->id)
            ->with('success', 'Votre rendez-vous a été enregistré. Procédez au paiement pour confirmer.');
    }

    private function createOrUpdatePatient($patientInfo)
    {
        $user = User::where('email', $patientInfo['email'])->first();
        if (!$user) {
            $user = new User();
            $user->name = $patientInfo['name'];
            $user->email = $patientInfo['email'];
            $user->phone = $patientInfo['phone'] ?? null;
            $user->date_of_birth = $patientInfo['birthdate'] ?? null;
            $randomPassword = bin2hex(random_bytes(4));
            $user->password = bcrypt($randomPassword);
            $user->role = 'patient';
            $user->save();
        }
        
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
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

    public function processAfterPayment($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $appointment->status = 'confirmed';
        $appointment->paiement = true;
        $appointment->save();
        
        $this->sendAppointmentConfirmationEmail($appointment);
        
        return redirect()->route('patient.appointment.details', ['appointment_id' => $appointment->id])
            ->with('success', 'true');
    }
}
