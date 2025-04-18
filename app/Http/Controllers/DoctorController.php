<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\Message;
use App\Services\DoctorService;
use App\Services\AppointmentService;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class DoctorController extends Controller
{
    protected $doctorService;
    protected $appointmentService;
    protected $medicalRecordService;
    
    public function __construct(
        DoctorService $doctorService, 
        AppointmentService $appointmentService,
        MedicalRecordService $medicalRecordService
    )
    {
        $this->doctorService = $doctorService;
        $this->appointmentService = $appointmentService;
        $this->medicalRecordService = $medicalRecordService;
    }

    
public function index()
{
        $doctor = Auth::user();
        
        if (!$doctor || !$doctor->isDoctor()) {
            return redirect()->route('login')->with('error', 'Accès non autorisé.');
        }
        $doctorModel = $doctor->doctor;

        if (!$doctorModel) {
            return redirect()->route('login')->with('error', 'Profil de médecin introuvable.');
        }
        
        $details = $this->doctorService->getDoctorDetails($doctorModel->id);
        
        // Récupérer les rendez-vous d'aujourd'hui avec sécurité
        $todayAppointments = $this->appointmentService->getTodayAppointments($doctorModel->id);
        
        // Récupérer tous les rendez-vous du médecin avec sécurité
        $appointments = $this->appointmentService->getByDoctorId($doctorModel->id);
        
        // Sécuriser l'accès à la spécialité
        $speciality = $details->speciality ?? null;
        $department = $details->department ?? 'Cardiologie';
        
        // Générer les jours du calendrier pour le mois actuel
        $calendarDays = [];
        $today = now();
        $currentMonthName = $today->format('F');
        $currentMonth = $today->month;
        $currentYear = $today->year;
        $daysInMonth = $today->daysInMonth;
        
        // Obtenir le premier jour du mois et son jour de semaine (0 = dimanche, 6 = samedi)
        $firstDayOfMonth = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1);
        $firstDayOfWeek = $firstDayOfMonth->dayOfWeek; // 0=dimanche, 1=lundi, etc.
        
        // Ajuster pour commencer par lundi (en France/Europe)
        if ($firstDayOfWeek == 0) {
            $firstDayOfWeek = 6; // Dimanche devient le 7ème jour
        } else {
            $firstDayOfWeek -= 1; // Les autres jours reculent d'une position
        }
        
        // Jours du mois précédent pour remplir le début du calendrier
        $previousMonth = $firstDayOfMonth->copy()->subMonth();
        $daysInPreviousMonth = $previousMonth->daysInMonth;
        
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $day = $daysInPreviousMonth - $firstDayOfWeek + $i + 1;
            $calendarDays[] = [
                'day' => $day,
                'isCurrentMonth' => false,
                'isToday' => false,
                'hasAppointments' => false
            ];
        }
        
        // Jours du mois actuel avec vérifications de sécurité sur $appointments
        $appointmentDates = collect();
        if ($appointments && $appointments->count() > 0) {
            $appointmentDates = $appointments->pluck('appointment_date')->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            })->toArray();
        }
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, $day);
            $formattedDate = $currentDate->format('Y-m-d');
            
            $calendarDays[] = [
                'day' => $day,
                'isCurrentMonth' => true,
                'isToday' => $today->day == $day,
                'hasAppointments' => in_array($formattedDate, $appointmentDates)
            ];
        }
        
        // Jours du mois suivant pour compléter la grille du calendrier (total 42 jours = 6 semaines)
        $remainingDays = 42 - count($calendarDays);
        for ($day = 1; $day <= $remainingDays; $day++) {
            $calendarDays[] = [
                'day' => $day,
                'isCurrentMonth' => false,
                'isToday' => false,
                'hasAppointments' => false
            ];
        }
        
        // Autres données pour le tableau de bord
        $currentDateTime = $today->format('d F Y, H:i');
        
        // Vérification et comptage des rendez-vous de demain avec sécurité
        $tomorrowAppointmentsCount = 0;
        if ($appointments && $appointments->count() > 0) {
            $tomorrowAppointmentsCount = $appointments
                ->filter(function($appointment) {
                    return $appointment->appointment_date && 
                           \Carbon\Carbon::parse($appointment->appointment_date)->isNextDay();
                })
                ->count();
        }
        
        // Préparation des données pour les graphiques
        $visitsChartLabels = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];
        $visitsChartData = [15, 20, 18, 25, 22, 10, 5]; // Données fictives
        
        $revenueChartLabels = ["Consultations", "Procédures", "Tests", "Suivis", "Autres"];
        $revenueChartData = [45000, 25000, 15000, 10000, 5000]; // Données fictives
        
        // Variables pour les mocks dans la vue
        $recentActivities = collect([
            (object)[
                'color' => 'green',
                'icon' => 'check',
                'title' => 'Consultation terminée',
                'highlight' => 'Mohammed Alami',
                'description' => 'Consultation de suivi cardiaque terminée.',
                'time_ago' => 'Il y a 30 minutes'
            ],
            (object)[
                'color' => 'indigo',
                'icon' => 'calendar-check',
                'title' => 'Rendez-vous confirmé',
                'highlight' => 'Sara Bennani',
                'description' => 'a confirmé son rendez-vous de demain à 10h00.',
                'time_ago' => 'Il y a 2 heures'
            ],
            (object)[
                'color' => 'amber',
                'icon' => 'notes-medical',
                'title' => 'Dossier médical mis à jour',
                'highlight' => 'Karim Idrissi',
                'description' => 'Nouveaux résultats d\'analyses sanguines ajoutés.',
                'time_ago' => 'Il y a 5 heures'
            ]
        ]);
        
        $tasks = collect([
            (object)[
                'id' => 1,
                'description' => 'Renouveler l\'ordonnance de M. Alami',
                'completed' => false,
                'priority_color' => 'red',
                'priority_icon' => 'exclamation-circle',
                'priority_label' => 'Urgent',
                'due_label' => 'Aujourd\'hui'
            ],
            (object)[
                'id' => 2,
                'description' => 'Vérifier les résultats d\'analyses de Mme Bennani',
                'completed' => false,
                'priority_color' => 'amber',
                'priority_icon' => 'clock',
                'priority_label' => 'Important',
                'due_label' => 'Dans 2 jours'
            ],
            (object)[
                'id' => 3,
                'description' => 'Compléter le dossier médical de M. Idrissi',
                'completed' => true,
                'priority_color' => 'green',
                'priority_icon' => 'check-circle',
                'priority_label' => 'Terminé',
                'due_label' => 'Hier'
            ]
        ]);
        
        $messages = collect([
            (object)[
                'id' => 1,
                'sender' => (object)['name' => 'Mohammed Alami', 'avatar_url' => null],
                'preview' => 'Bonjour Docteur, je voulais vous demander si...',
                'time' => 'Il y a 30 min',
                'unread_count' => 1
            ],
            (object)[
                'id' => 2,
                'sender' => (object)['name' => 'Dr. Karima Sabri', 'avatar_url' => null],
                'preview' => 'Concernant le patient référé la semaine dernière...',
                'time' => 'Hier',
                'unread_count' => 0
            ]
        ]);
        
        // Variables pour les graphiques et statistiques avec valeurs par défaut sécurisées
        $totalVisitsThisMonth = rand(80, 120);
        $visitsIncreasePercent = rand(5, 15);
        $totalRevenue = rand(25000, 35000);
        $revenueIncreasePercent = rand(5, 20);
        $averageWaitTime = rand(10, 20);
        $waitTimeImprovement = rand(5, 15);
        $averageConsultationTime = rand(15, 25);
        $consultationTimeVariance = rand(5, 10);
        $noShowRate = rand(3, 8);
        $noShowRateImprovement = rand(5, 15);
        $onlineBookingRate = rand(60, 80);
        $onlineBookingImprovement = rand(5, 15);
        $unreadMessagesCount = rand(1, 5);
        $pendingTasksCount = $tasks->where('completed', false)->count();
        $newPatientsThisMonth = rand(5, 20);
        $urgentLabResultsCount = rand(1, 5);
        $appointmentIncreasePercent = rand(5, 15);
        
        // Préparer les données de patients avec sécurité
        $patientsCount = 0;
        $patients = collect();
        
        if ($appointments && $appointments->count() > 0) {
            $patientIds = $appointments->pluck('patient_id')->unique();
            $patientsCount = $patientIds->count();
            
            try {
                $patients = Patient::whereIn('id', $patientIds)->get();
            } catch (\Exception $e) {
                \Log::error('Error fetching patients: ' . $e->getMessage());
                $patients = collect();
            }
        }
        
        $nextAppointment = null;
        if ($todayAppointments && $todayAppointments->count() > 0) {
            $nextAppointment = $todayAppointments->first();
            
            if ($nextAppointment) {
                $appointmentTime = \Carbon\Carbon::parse($nextAppointment->appointment_date);
                $nextAppointment->formatted_time = $appointmentTime->format('H:i');
                $nextAppointment->am_pm = $appointmentTime->format('A');
                $nextAppointment->day_name = $appointmentTime->format('l');
                $nextAppointment->room = $nextAppointment->room ?? '204';
            }
        }
        
        // Calculer le revenu avec une valeur par défaut sécurisée
        $revenue = 0;
        if ($appointments && $appointments->count() > 0) {
            $revenue = $appointments->where('status', 'completed')->sum('price') ?: rand(5000, 15000);
        } else {
            $revenue = rand(5000, 15000); // Valeur par défaut
        }
        
        // Préparation de toutes les variables pour la vue
        $stats = [
            'totalAppointments' => $appointments ? $appointments->count() : 0,
            'todayAppointments' => $todayAppointments ? $todayAppointments->count() : 0,
            'Appointments' => $todayAppointments ?: collect(),
            'patientsCount' => $patientsCount,
            'revenue' => $revenue,
            'date' => $today->format('F Y'),
            'patients' => $patients,
            'patient' => $patients->first(),
            'nextAppointment' => $nextAppointment ? $appointmentTime->diffForHumans() : 'Aucun rendez-vous prévu'
        ];
        
        // Créer un objet mock pour la météo
        $weather = (object)[
            'temperature' => rand(15, 30),
            'city' => 'Casablanca'
        ];

        return view('doctor.dashboard', compact(
            'doctor', 
            'details', 
            'stats',
            'calendarDays',
            'currentDateTime',
            'tomorrowAppointmentsCount',
            'recentActivities',
            'tasks',
            'messages',
            'totalVisitsThisMonth',
            'visitsIncreasePercent',
            'totalRevenue',
            'revenueIncreasePercent',
            'averageWaitTime',
            'waitTimeImprovement',
            'averageConsultationTime',
            'consultationTimeVariance',
            'noShowRate',
            'noShowRateImprovement',
            'onlineBookingRate',
            'onlineBookingImprovement',
            'currentMonth',
            'currentYear',
            'unreadMessagesCount',
            'pendingTasksCount',
            'weather',
            'newPatientsThisMonth',
            'urgentLabResultsCount',
            'appointmentIncreasePercent',
            'visitsChartLabels',
            'visitsChartData',
            'revenueChartLabels',
            'revenueChartData',
            'department',
            'speciality',
            'nextAppointment'
        ));
    }

    public function appointments()
    {
        try {
            $doctor = Auth::user();
            $appointments = $this->appointmentService->getByDoctorId($doctor->id);
            return view('doctor.appointments', compact('appointments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des rendez-vous.');
        }
    }

    public function patients()
    {
        try {
            $doctor = Auth::user();
            $patients = Patient::whereHas('appointments', function($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })->get();
            return view('doctor.patients', compact('patients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des patients.');
        }
    }

    public function showPatient($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $appointments = Appointment::where('patient_id', $id)
                ->where('doctor_id', Auth::id())
                ->get();
            return view('doctor.patients.show', compact('patient', 'appointments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des détails du patient.');
        }
    }

    public function patientHistory($id)
    {
        try {
            $doctor = Auth::user();
            $patient = Patient::findOrFail($id);
            $appointments = $this->appointmentService->getByPatientId($id);
            
            return view('doctor.patients.history', compact('patient', 'appointments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement de l\'historique du patient: ' . $e->getMessage());
        }
    }
    
    public function showAppointment($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            if ($appointment->doctor_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Accès non autorisé.');
            }
            return view('doctor.appointments.show', compact('appointment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du rendez-vous.');
        }
    }
    
    public function checkInAppointment($id)
    {
        try {
            $doctor = Auth::user();
            $appointment = $this->appointmentService->getById($id);
            
            if (!$appointment) {
                return redirect()->back()->with('error', 'Rendez-vous introuvable.');
            }
            
            return view('doctor.appointments.check-in', compact('appointment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du check-in: ' . $e->getMessage());
        }
    }

    public function createAppointment(){
        try {
            $doctor = Auth::user();
            $patients = Patient::all();
            
            return view('doctor.appointments.create', compact('patients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du rendez-vous: ' . $e->getMessage());
        }
    }

    
    public function updateAppointment(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            if ($appointment->doctor_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Accès non autorisé.');
            }

            $appointment->update($request->all());
            return redirect()->route('doctor.appointments')->with('success', 'Rendez-vous mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du rendez-vous.');
        }
    }
    
    public function destroyAppointment($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            if ($appointment->doctor_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Accès non autorisé.');
            }

            $appointment->delete();
            return redirect()->route('doctor.appointments')->with('success', 'Rendez-vous supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du rendez-vous.');
        }
    }
    
    public function searchPatients(Request $request)
    {
        try {
            $doctor = Auth::user();
            $query = $request->input('query');
            $patients = $this->appointmentService->searchPatients($query);
            
            return view('doctor.patients.index', compact('patients', 'query'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la recherche: ' . $e->getMessage());
        }
    }
    
    public function calendar()
    {
        try {
            $doctor = Auth::user();
            $appointments = $this->appointmentService->getByDoctorId($doctor->id);
            
            $month = request('month', now()->month);
            $year = request('year', now()->year);
            
            return view('doctor.calendar.index', compact('appointments', 'month', 'year'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du calendrier: ' . $e->getMessage());
        }
    }
    
    public function messages()
    {
        try {
            $doctor = Auth::user();
            $messages = Message::where('recipient_id', $doctor->id)
                ->orWhere('sender_id', $doctor->id)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('doctor.messages.index', compact('messages'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des messages: ' . $e->getMessage());
        }
    }
    
    public function createMessage()
    {
        try {
            $doctor = Auth::user();
            $patients = Patient::all();
            
            return view('doctor.messages.create', compact('patients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du message: ' . $e->getMessage());
        }
    }
    
    public function activities()
    {
        try {
            $doctor = Auth::user();
            
            // This is a placeholder for actual activity logging system
            $activities = [];
            
            return view('doctor.activities.index', compact('activities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des activités: ' . $e->getMessage());
        }
    }
    
    public function exportRevenue()
    {
        try {
            $doctor = Auth::user();
            $revenue = $this->appointmentService->getTotalRevenue();
            
            // This would normally generate a CSV or Excel file for download
            $filename = 'revenue_' . now()->format('Y-m-d') . '.csv';
            
            return response()->download(storage_path('app/' . $filename), $filename, [
                'Content-Type' => 'text/csv',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'exportation des données: ' . $e->getMessage());
        }
    }

    public function showMedicalRecord($id)
    {
        try {
            $doctor = Auth::user();
            $patient = Patient::findOrFail($id);
            
            // Vérifier que ce médecin a accès au dossier de ce patient
            $hasAccess = $this->appointmentService->getByPatientId($id)
                ->where('doctor_id', $doctor->id)
                ->count() > 0;
                
            if (!$hasAccess) {
                return redirect()->back()->with('error', 'Vous n\'avez pas accès au dossier médical de ce patient.');
            }
            
            // Récupérer le dossier médical
            $medicalRecord = app(\App\Services\DossierMedicalService::class)->getByPatientId($id) ?? null;
            
            return view('doctor.medical-records.show', compact('patient', 'medicalRecord'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du dossier médical: ' . $e->getMessage());
        }
    }
    
    public function medicalRecords($id)
    {
        try {
            $doctor = Auth::user();
            $patient = Patient::findOrFail($id);
            
            // Vérifier que ce médecin a accès au dossier de ce patient
            $hasAccess = $this->appointmentService->getByPatientId($id)
                ->where('doctor_id', $doctor->id)
                ->count() > 0;
                
            if (!$hasAccess) {
                return redirect()->back()->with('error', 'Vous n\'avez pas accès aux dossiers médicaux de ce patient.');
            }
            
            // Récupérer tous les dossiers médicaux du patient
            $medicalRecords = app(\App\Services\DossierMedicalService::class)->getAllByPatientId($id) ?? collect([]);
            
            return view('doctor.medical-records.index', compact('patient', 'medicalRecords'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des dossiers médicaux: ' . $e->getMessage());
        }
    }

    public function allMedicalRecords()
    {
        try {
            $doctor = Auth::user();
            $medicalRecords = $this->medicalRecordService->getDoctorMedicalRecords($doctor->id);
            
            return view('doctor.medical-records.all', compact('medicalRecords'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des dossiers médicaux: ' . $e->getMessage());
        }
    }

    /**
     * Display the medical records for a specific patient
     * 
     * @param int $id The patient ID
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function patientMedicalRecords($id)
    {
        try {
            $doctor = Auth::user();
            $patient = Patient::findOrFail($id);
            
            // Vérifier que ce médecin a accès au dossier de ce patient
            $hasAccess = $this->appointmentService->getByPatientId($id)
                ->where('doctor_id', $doctor->id)
                ->count() > 0;
                
            if (!$hasAccess) {
                return redirect()->back()->with('error', 'Vous n\'avez pas accès aux dossiers médicaux de ce patient.');
            }
            
            // Récupérer tous les dossiers médicaux du patient
            $medicalRecords = app(\App\Services\DossierMedicalService::class)->getAllByPatientId($id) ?? collect([]);
            
            return view('doctor.medical-records.index', compact('patient', 'medicalRecords'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des dossiers médicaux: ' . $e->getMessage());
        }
    }
}
