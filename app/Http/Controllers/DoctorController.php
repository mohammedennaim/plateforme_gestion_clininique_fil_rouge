<?php

namespace App\Http\Controllers;

use App;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\User;
use App\Services\DashboardService;
use App\Services\DoctorService;
use App\Services\AppointmentService;
use App\Services\PatientService;
use Hash;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    protected $doctorService;
    protected $appointmentService;

    protected $patientService;
    public function __construct(DoctorService $doctorService, AppointmentService $appointmentService, PatientService $patientService)
    {
        $this->doctorService = $doctorService;
        $this->appointmentService = $appointmentService;
        $this->patientService = $patientService;
    }
    public function index()
    {
      
            $doctor = auth()->user();
            $doctorId = $doctor->doctor->id;
            $details = $this->doctorService->getDoctorDetails($doctorId);
            $todayAppointments = $this->appointmentService->getTodayAppointments($doctorId);
            $todayAppointmentsConfirmed = $this->appointmentService->getTodayAppointments($doctorId)->where('status', 'confirmed')->first();
            // dd(isset($todayAppointmentsConfirmed));
            $appointments = $this->appointmentService->getByDoctorId($doctorId);
            // dd($appointments[0]->patient->user->name);
            $patients = $this->appointmentService->getByDoctorId($doctorId);
            $countPatients = $this->appointmentService->getCountByPatientsByDoctorId($doctorId);
            // dd($todayAppointments[0]->date->format('d/m/Y'));
            // dd($countPatients);
  
            foreach($appointments as $appointment) {
                if ($appointment->patient && !$patients->contains('id', $appointment->patient->id)) {
                    $patients->push($appointment->patient);
                }
            }
            
            $revenue = $this->appointmentService->getTotalRevenue($doctor->id) ?? 0;
            $speciality = null;
            if ($details && isset($details->id_speciality)) {
                $speciality = Speciality::where('id', $details->id_speciality)->first();
            }
            
            $monthlyRevenue = $revenue;
            $patientSatisfactionRate = 95;
            $satisfactionIncreasePercent = 5;
            $reviewCount = 120;
        
            $nextAppointment = $todayAppointments->sortBy([
                ['date', 'asc'],
                ['time', 'asc'],
            ])->first();
            // dd($nextAppointment);
            $appointmentDateTime = $nextAppointment ? $nextAppointment->date->setTimeFromTimeString($nextAppointment->time) : null;
            $diffInMinutes = now()->diffInMinutes($appointmentDateTime);
            $hours = floor($diffInMinutes / 60);
            $minutes = $diffInMinutes % 60;
            $nextAppointmentCountdown = $hours . 'h ' . $minutes . 'm';
            
            $currentDateTime = now()->format('l, d F Y | H:i');
            
            $now = now();
            $currentMonth = $now->format('F');
            $currentYear = $now->format('Y');
            $prevMonth = $now->copy()->subMonth()->format('m');
            $prevYear = $now->copy()->subMonth()->format('Y');
            $nextMonth = $now->copy()->addMonth()->format('m');
            $nextYear = $now->copy()->addMonth()->format('Y');
            $calendarDays = $this->generateCalendarDays();
            
            $visitsChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $visitsChartData = [65, 59, 80, 81, 56, 55, 72, 78, 80, 85, 90, 95];
            $revenueChartLabels = ['Consultations', 'Traitements', 'Tests Labo', 'Médicaments', 'Autres'];
            $revenueChartData = [35, 25, 20, 15, 5];
            $totalVisitsThisMonth = 145;
            $visitsIncreasePercent = 12;
            $totalRevenue = $revenue ?? 5000;
            $revenueIncreasePercent = 8;
            
            $averageWaitTime = 15;
            $waitTimeImprovement = 20;
            $averageConsultationTime = 25;
            $consultationTimeVariance = 5;
            $noShowRate = 4;
            $noShowRateImprovement = 25;
            $onlineBookingRate = 68;
            $onlineBookingImprovement = 15;
            
       
            $weather = (object) ['temperature' => 22, 'city' => 'Casablanca'];
            $urgentLabResultsCount = 3;
            $unreadMessagesCount = 5;
            $newPatientsThisMonth = 12;
            $appointmentIncreasePercent = 8;
            $tomorrowAppointmentsCount = 0;
            $tasks = collect([
                (object) ['id' => 1, 'description' => 'Réviser les rapports de laboratoire', 'completed' => false, 'priority_label' => 'Urgent', 'priority_color' => 'red-600', 'priority_icon' => 'exclamation-circle', 'due_label' => "Aujourd'hui"],
                (object) ['id' => 2, 'description' => 'Appeler les patients de suivi', 'completed' => false, 'priority_label' => 'Moyen', 'priority_color' => 'amber-600', 'priority_icon' => 'clock', 'due_label' => "Demain"]
            ]);
            $pendingTasksCount = 2;
            
            $recentActivities = collect([
                (object) ['color' => 'indigo', 'icon' => 'user', 'title' => 'Nouveau patient enregistré', 'highlight' => 'Ahmed Benani', 'description' => 'a été ajouté à votre liste de patients.', 'time_ago' => 'Il y a 30 minutes'],
                (object) ['color' => 'green', 'icon' => 'check', 'title' => 'Rendez-vous terminé', 'highlight' => 'Consultation avec Fatima Zahra', 'description' => 'a été complétée avec succès.', 'time_ago' => 'Il y a 2 heures']
            ]);
            
            $messages = collect([
                (object) ['id' => 1, 'sender' => (object) ['name' => 'Dr. Karim', 'avatar_url' => null], 'preview' => 'Pouvez-vous examiner les résultats du patient #12345?', 'time' => '09:45', 'unread_count' => 1],
                (object) ['id' => 2, 'sender' => (object) ['name' => 'Administration', 'avatar_url' => null], 'preview' => 'Planning de la semaine prochaine disponible', 'time' => 'Hier', 'unread_count' => 0]
            ]);
            
            $activePatientCount = $patients->count();
            $activePatientPercent = 85;
            $patientsThisWeek = 24;
            $patientsWeeklyChangePercent = 15;
            $followUpsCount = 18;
            $urgentFollowUpsCount = 3;
            // dd($todayAppointmentsConfirmed);
            $stats = [
                'totalAppointments' => $appointments ? $appointments->count() : 0,
                'todayAppointmentsConfirmed' => $todayAppointmentsConfirmed ? $todayAppointmentsConfirmed->count() : 0,
                'Appointments' => $todayAppointments ?: collect(),
                'patientsCount' => $patients->count(),
                'revenue' => $revenue,
                'patients' => $patients,
                'patient' => $patients->first(),
                'nextAppointment' => $nextAppointment ? $nextAppointmentCountdown : 'Aucun rendez-vous prévu'
            ];

            return view('doctor.dashboard', compact(
                'details', 'revenue', 'todayAppointments', 'patients',
                'monthlyRevenue', 'patientSatisfactionRate', 'satisfactionIncreasePercent', 'reviewCount',
                'nextAppointment', 'nextAppointmentCountdown', 'currentDateTime',
                'currentMonth', 'currentYear', 'prevMonth', 'prevYear', 'nextMonth', 'nextYear',
                'calendarDays', 
                'visitsChartLabels', 'visitsChartData', 'revenueChartLabels', 'revenueChartData',
                'totalVisitsThisMonth', 'visitsIncreasePercent', 'totalRevenue', 'revenueIncreasePercent',
                'averageWaitTime', 'waitTimeImprovement', 'averageConsultationTime', 'consultationTimeVariance',
                'noShowRate', 'noShowRateImprovement', 'onlineBookingRate', 'onlineBookingImprovement',
                'weather', 'urgentLabResultsCount', 'unreadMessagesCount', 'newPatientsThisMonth',
                'appointmentIncreasePercent', 'tasks', 'pendingTasksCount', 'recentActivities', 'messages',
                'activePatientCount', 'activePatientPercent', 'patientsThisWeek',
                'patientsWeeklyChangePercent', 'followUpsCount', 'urgentFollowUpsCount', 'appointments', 'speciality','doctorId',
                'stats','tomorrowAppointmentsCount', 'todayAppointmentsConfirmed', 'countPatients'
            ));
        
      
    }
   
    private function generateCalendarDays()
    {
        $days = [];
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $firstDay = now()->startOfMonth();
        $lastDay = now()->endOfMonth();
        
        $previousMonthDays = $firstDay->dayOfWeek == 1 ? 0 : $firstDay->dayOfWeek - 1;
        for ($i = $previousMonthDays - 1; $i >= 0; $i--) {
            $days[] = [
                'day' => now()->startOfMonth()->subDays($i + 1)->day,
                'isCurrentMonth' => false,
                'isToday' => false,
                'hasAppointments' => false
            ];
        }
        
        for ($day = 1; $day <= $lastDay->day; $day++) {
            $date = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, $day);
            $days[] = [
                'day' => $day,
                'isCurrentMonth' => true,
                'isToday' => $date->isToday(),
                'hasAppointments' => $day % 3 == 0 
            ];
        }
        
        $totalDaysShown = count($days);
        $remainingDays = 42 - $totalDaysShown; 
        
        for ($day = 1; $day <= $remainingDays; $day++) {
            $days[] = [
                'day' => $day,
                'isCurrentMonth' => false,
                'isToday' => false,
                'hasAppointments' => false
            ];
        }
        
        return collect($days);
    }

    public function patients()
    {
        try {
            $doctor = auth()->user();
            $patients = $this->appointmentService->getById($doctor->id);
            
            return view('doctor.patients', compact('patients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while loading patients.');
        }
    }

    public function showPatient($id)
    {
        try {
            $doctor = auth()->user();
            $patient = $this->patientService->findPatientById($id);
            
            return view('doctor.patients.show', compact('patient'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des détails du patient: ' . $e->getMessage());
        }
    }

    public function createPatient()
    {
        try {
            return view('doctor.patients.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du patient: ' . $e->getMessage());
        }
    }

    public function storePatient(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'nullable|string|max:20',
                'adresse' => 'nullable|string|max:255',
                'date_of_birth' => 'nullable|date',
                'name_assurance' => 'nullable|string|max:255',
                'assurance_number' => 'nullable|string|max:255',
                'blood_type' => 'nullable|string|max:10',
                'emergency_contact' => 'nullable|string|max:255',
                'allergies' => 'nullable|string',
                'height' => 'nullable|numeric|min:0',
                'weight' => 'nullable|numeric|min:0',
            ]);
            $randomPassword = bin2hex(random_bytes(4));
            $password = bcrypt($randomPassword);
            
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $password,
                'role' => 'patient',
                'phone' => $validated['phone'] ?? null,
                'adress' => $validated['adresse'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'name_assurance' => $validated['name_assurance'] ?? null,
                'assurance_number' => $validated['assurance_number'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'allergies' => $validated['allergies'] ?? null,
                'height' => $validated['height'] ?? null,
                'weight' => $validated['weight'] ?? null,
            ]);
            return redirect()->route('doctor.dashboard')->with('success', 'Patient créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du patient: ' . $e->getMessage());
        }
    }

    public function updatePatient(Request $request, $id)
    {
        try {
            $patient = $this->patientService->getPatientById($id)->first();
            // $user = $this->patientService->getUserById($patient->user_id);
            // $user->update($request->all());
            $patient->update($request->all());
            $patient->user->update($request->all());
            
            return redirect()->back()->with('success', 'Patient mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du patient: ' . $e->getMessage());
        }
    }
    public function editPatient($id){
        $patient = $this->patientService->getPatientById($id)->first();
        return view('doctor.patients.edit', compact('patient'));
    }
    
    public function showAppointment($id)
    {
        try {
            $doctor = auth()->user();
            $details = $this->doctorService->getDoctorDetails($doctor->doctor->id);
            $appointment = $this->appointmentService->getById($id);
            $user = $this->patientService->getUserById($appointment->patient_id);
            $patient = $this->patientService->getPatientById($user->id)->first();
            $detailsPatient = $this->patientService->getPatientById($user->id);
            $speciality = Speciality::where('id', $details->id_speciality)->first();
            if (!$appointment) {
                return redirect()->back()->with('error', 'Rendez-vous introuvable.');
            }
            
            return view('doctor.appointments.show', compact('appointment','patient', 'user', 'doctor', 'speciality'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du rendez-vous: ' . $e->getMessage());
        }
    }
    
    public function checkInAppointment($id)
    {
        try {
            $doctor = auth()->user();
            $appointment = $this->appointmentService->getById($id);
            
            if (!$appointment) {
                return redirect()->back()->with('error', 'Rendez-vous introuvable.');
            }
            
            return view('doctor.appointments.check', compact('appointment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du check-in: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            $doctor = auth()->user();
            $appointment = Appointment::findOrFail($id);
            
            if ($appointment->doctor_id != $doctor->doctor->id) {
                return redirect()->back()->with('error', 'Vous n\'avez pas accès à ce rendez-vous.');
            }
            
            $patient = $appointment->patient;
            
            return view('doctor.appointments.edit', compact('appointment', 'patient'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du rendez-vous: ' . $e->getMessage());
        }
    }
    
    public function updateAppointment(Request $request, $id)
    {
    
        try {
            $doctor = auth()->user();
            $appointment = Appointment::findOrFail($id);
            
            if ($appointment->doctor_id != $doctor->doctor->id) {
                return redirect()->back()->with('error', 'Vous n\'avez pas accès à ce rendez-vous.');
            }
            
            $validated = $request->validate([
                'doctor_id' => $request->patient_id,
                'patient_id' => $request->doctor_id,
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'status' => 'required|in:pending,confirmed,completed,canceled',
                'reason' => 'required|string',
                'price' => 'nullable|numeric'
            ]);
            
            $data = [
                'doctor_id' => $validated['doctor_id'],
                'patient_id' => $validated['patient_id'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'status' => $validated['status'],
                'reason' => $validated['reason'],
                'price' => $validated['price'] ?? $appointment->price
            ];
            
            $updatedAppointment = $this->appointmentService->update($id, $data);
            
            if (!$updatedAppointment) {
                return redirect()->back()->with('error', 'Erreur lors de la mise à jour du rendez-vous. Veuillez réessayer.');
            }
            
            return redirect()->route('doctor.appointments.show', $appointment->id)
                ->with('success', 'Rendez-vous mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du rendez-vous: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function createAppointment(){
        try {
            $detailsDoctor = auth()->user();
            $doctor = $this->doctorService->getDoctorDetails($detailsDoctor->doctor->id);
            // dd($doctor);
            $patients = Appointment::where('doctor_id',$doctor->id)->with('patient')->get();
            
            $patientUserIds = [];
            foreach ($patients as $appointment) {
                if ($appointment->patient && $appointment->patient->user_id) {
                    $patientUserIds[] = $appointment->patient->user_id;
                }
            }
            $users = User::whereIn('id', $patientUserIds)->get();

            return view('doctor.appointments.create', compact('detailsDoctor', 'doctor','users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du rendez-vous: ' . $e->getMessage());
        }
    }

    public function storeAppointment(Request $request){
        try {
            $user = auth()->user();
            $doctor = Doctor::where('user_id',$user->id)->first();
            $data = $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'reason' => 'required|string',
                'status' => 'required|in:pending,confirmed,canceled',
                'price' => 'nullable|numeric'
            ]);
            
            $appointment = new Appointment();
            $appointment->doctor_id = $data['doctor_id'];
            $appointment->patient_id = $data['patient_id'];
            $appointment->date = $data['date'];
            $appointment->time = $data['time'];
            $appointment->reason = $data['reason'];
            $appointment->status = $data['status'];
            $appointment->price = $data['price'] ?? null;
            $appointment->save();
            
            return redirect()->route('doctor.dashboard')->with('success', 'Rendez-vous créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du rendez-vous: ' . $e->getMessage());
        }
    }
    
    public function destroyAppointment($id)
    {
        try {
            $result = $this->appointmentService->deleteAppointment($id);
            
            if ($result) {
                return redirect()->route('doctor.dashboard')->with('success', 'Rendez-vous supprimé avec succès.');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de la suppression du rendez-vous.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du rendez-vous: ' . $e->getMessage());
        }
    }
    
    public function changeStatus(Request $request, $id){
        try {
            $doctor = auth()->user();
            $appointment = Appointment::findOrFail($id);
            
            if ($appointment->doctor_id != $doctor->doctor->id) {
                return redirect()->back()->with('error', 'Vous n\'avez pas accès à ce rendez-vous.');
            }
            
            $appointment->status = $request->input('status');
            $appointment->save();
            
            return redirect()->back()->with('success', 'Le statut du rendez-vous a été mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du statut: ' . $e->getMessage());
        }
    }

    // public function patientHistory($id)
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $patient = $this->patientService->getPatientById($id);
    //         $appointments = $this->appointmentService->getByPatientId($id);
            
    //         return view('doctor.patients.history', compact('patient', 'appointments'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors du chargement de l\'historique du patient: ' . $e->getMessage());
    //     }
    // }

    // public function searchPatients(Request $request)
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $query = $request->input('query');
    //         $patients = $this->appointmentService->searchPatients($query);
            
    //         return view('doctor.patients.index', compact('patients', 'query'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors de la recherche: ' . $e->getMessage());
    //     }
    // }
    
    // public function calendar()
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $appointments = $this->appointmentService->getByDoctorId($doctor->id);
            
    //         $month = request('month', now()->month);
    //         $year = request('year', now()->year);
            
    //         return view('doctor.calendar.index', compact('appointments', 'month', 'year'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors du chargement du calendrier: ' . $e->getMessage());
    //     }
    // }
    
    // public function messages()
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $messages = Message::where('recipient_id', $doctor->id)
    //             ->orWhere('sender_id', $doctor->id)
    //             ->orderBy('created_at', 'desc')
    //             ->get();
            
    //         return view('doctor.messages.index', compact('messages'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors du chargement des messages: ' . $e->getMessage());
    //     }
    // }
    
    // public function createMessage()
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $patients = Patient::all();
            
    //         return view('doctor.messages.create', compact('patients'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors de la création du message: ' . $e->getMessage());
    //     }
    // }
    
    // public function activities()
    // {
    //     try {
    //         $doctor = auth()->user();
            
    //         // This is a placeholder for actual activity logging system
    //         $activities = [];
            
    //         return view('doctor.activities.index', compact('activities'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors du chargement des activités: ' . $e->getMessage());
    //     }
    // }
    
    // public function exportRevenue()
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $revenue = $this->appointmentService->getTotalRevenue();
            
    //         // This would normally generate a CSV or Excel file for download
    //         $filename = 'revenue_' . now()->format('Y-m-d') . '.csv';
            
    //         return response()->download(storage_path('app/' . $filename), $filename, [
    //             'Content-Type' => 'text/csv',
    //         ]);
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors de l\'exportation des données: ' . $e->getMessage());
    //     }
    // }

    // public function showMedicalRecord($id)
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $patient = $this->patientService->getPatientById($id);
            
    //         // Vérifier que ce médecin a accès au dossier de ce patient
    //         $hasAccess = $this->appointmentService->getByPatientId($id)
    //             ->where('doctor_id', $doctor->id)
    //             ->count() > 0;
                
    //         if (!$hasAccess) {
    //             return redirect()->back()->with('error', 'Vous n\'avez pas accès au dossier médical de ce patient.');
    //         }
            
    //         // Récupérer le dossier médical
    //         $medicalRecord = app(\App\Services\DossierMedicalService::class)->getByPatientId($id) ?? null;
            
    //         return view('doctor.medical-records.show', compact('patient', 'medicalRecord'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors du chargement du dossier médical: ' . $e->getMessage());
    //     }
    // }
    
    // public function medicalRecords($id)
    // {
    //     try {
    //         $doctor = auth()->user();
    //         $patient = $this->patientService->getPatientById($id);
    //         $hasAccess = $this->appointmentService->getByPatientId($id)
    //             ->where('doctor_id', $doctor->id)
    //             ->count() > 0;
                
    //         if (!$hasAccess) {
    //             return redirect()->back()->with('error', 'Vous n\'avez pas accès aux dossiers médicaux de ce patient.');
    //         }
            
    //         $medicalRecords = app(\App\Services\DossierMedicalService::class)->getAllByPatientId($id) ?? collect([]);
            
    //         return view('doctor.medical-records.index', compact('patient', 'medicalRecords'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors du chargement des dossiers médicaux: ' . $e->getMessage());
    //     }
    // }
}


