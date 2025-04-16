<?php

namespace App\Http\Controllers;

use App;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\User;
use App\Services\DashboardService;
use App\Services\DoctorService;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    protected $doctorService;
    protected $appointmentService;
    public function __construct(DoctorService $doctorService, AppointmentService $appointmentService)
    {
        $this->doctorService = $doctorService;
        $this->appointmentService = $appointmentService;
    }
    public function index()
    {
        try {
            $doctor = auth()->user();
            $details = $this->doctorService->getDoctorDetails($doctor->id);
            
            $revenue = $this->appointmentService->getTotalRevenue();
            $todayAppointments = $this->appointmentService->getTodayAppointments();
            $Appointments = $this->appointmentService->getByDoctorId($doctor->id);
            $patients = $this->appointmentService->getByDoctorId($doctor->id);
            $speciality = Speciality::where('id', $details->id_speciality)->first();            // dd($todayAppointments[0]->status);
            $monthlyRevenue = $revenue ?? 0;
            $patientSatisfactionRate = 95; // Default value if not available
            $satisfactionIncreasePercent = 5;
            $reviewCount = 120;
            $nextAppointment = $todayAppointments->first();
            $nextAppointmentCountdown = "2h 30m";
            $currentDateTime = now()->format('l, d F Y | H:i');
            $currentMonth = now()->format('F');
            $currentYear = now()->format('Y');
            $prevMonth = now()->subMonth()->format('m');
            $prevYear = now()->subMonth()->format('Y');
            $nextMonth = now()->addMonth()->format('m');
            $nextYear = now()->addMonth()->format('Y');
            
            // Calendar days for the mini calendar
            $calendarDays = $this->generateCalendarDays();
            $tomorrowAppointmentsCount = 3; // Example value
            $visitsChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $visitsChartData = [65, 59, 80, 81, 56, 55, 72, 78, 80, 85, 90, 95];
            $revenueChartLabels = ['Consultations', 'Traitements', 'Tests Labo', 'Médicaments', 'Autres'];
            $revenueChartData = [35, 25, 20, 15, 5];
            $totalVisitsThisMonth = 145;
            $visitsIncreasePercent = 12;
            $totalRevenue = $revenue ?? 5000;
            $revenueIncreasePercent = 8;
            
            // KPIs
            $averageWaitTime = 15;
            $waitTimeImprovement = 20;
            $averageConsultationTime = 25;
            $consultationTimeVariance = 5;
            $noShowRate = 4;
            $noShowRateImprovement = 25;
            $onlineBookingRate = 68;
            $onlineBookingImprovement = 15;
            
            // Additional information
            $weather = (object) ['temperature' => 22, 'city' => 'Casablanca'];
            $urgentLabResultsCount = 3;
            $unreadMessagesCount = 5;
            $newPatientsThisMonth = 12;
            $appointmentIncreasePercent = 8;
            
            // Tasks and Activity
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
            
            // Patient statistics
            $activePatientCount = count($patients);
            $activePatientPercent = 85;
            $patientsThisWeek = 24;
            $patientsWeeklyChangePercent = 15;
            $followUpsCount = 18;
            $urgentFollowUpsCount = 3;

            return view('doctor.dashboard', compact(
                'details', 'revenue', 'todayAppointments', 'patients',
                'monthlyRevenue', 'patientSatisfactionRate', 'satisfactionIncreasePercent', 'reviewCount',
                'nextAppointment', 'nextAppointmentCountdown', 'currentDateTime',
                'currentMonth', 'currentYear', 'prevMonth', 'prevYear', 'nextMonth', 'nextYear',
                'calendarDays', 'tomorrowAppointmentsCount', 
                'visitsChartLabels', 'visitsChartData', 'revenueChartLabels', 'revenueChartData',
                'totalVisitsThisMonth', 'visitsIncreasePercent', 'totalRevenue', 'revenueIncreasePercent',
                'averageWaitTime', 'waitTimeImprovement', 'averageConsultationTime', 'consultationTimeVariance',
                'noShowRate', 'noShowRateImprovement', 'onlineBookingRate', 'onlineBookingImprovement',
                'weather', 'urgentLabResultsCount', 'unreadMessagesCount', 'newPatientsThisMonth',
                'appointmentIncreasePercent', 'tasks', 'pendingTasksCount', 'recentActivities', 'messages',
                'activePatientCount', 'activePatientPercent', 'patientsThisWeek',
                'patientsWeeklyChangePercent', 'followUpsCount', 'urgentFollowUpsCount','Appointments', 'speciality'
            ));
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Une erreur s\'est produite lors du chargement du tableau de bord: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate calendar days for the mini calendar
     */
    private function generateCalendarDays()
    {
        $days = [];
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $firstDay = now()->startOfMonth();
        $lastDay = now()->endOfMonth();
        
        // Previous month days to fill the first week
        $previousMonthDays = $firstDay->dayOfWeek == 1 ? 0 : $firstDay->dayOfWeek - 1;
        for ($i = $previousMonthDays - 1; $i >= 0; $i--) {
            $days[] = [
                'day' => now()->startOfMonth()->subDays($i + 1)->day,
                'isCurrentMonth' => false,
                'isToday' => false,
                'hasAppointments' => false
            ];
        }
        
        // Current month days
        for ($day = 1; $day <= $lastDay->day; $day++) {
            $date = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, $day);
            $days[] = [
                'day' => $day,
                'isCurrentMonth' => true,
                'isToday' => $date->isToday(),
                'hasAppointments' => $day % 3 == 0 // Example: mark every third day as having appointments
            ];
        }
        
        // Next month days to complete the grid
        $totalDaysShown = count($days);
        $remainingDays = 42 - $totalDaysShown; // 6 rows of 7 days
        
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

    public function appointments()
    {
        try {
            $doctor = auth()->user();
            $appointments = $this->appointmentService->getByDoctorId($doctor->id);
            
            return view('doctor.appointments', compact('appointments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while loading appointments.');
        }
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
            $patient = Patient::findOrFail($id);
            
            return view('doctor.patients.show', compact('patient'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement des détails du patient: ' . $e->getMessage());
        }
    }

    public function patientHistory($id)
    {
        try {
            $doctor = auth()->user();
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
            $doctor = auth()->user();
            $appointment = $this->appointmentService->getById($id);
            
            if (!$appointment) {
                return redirect()->back()->with('error', 'Rendez-vous introuvable.');
            }
            
            return view('doctor.appointments.show', compact('appointment'));
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
            
            return view('doctor.appointments.check-in', compact('appointment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du chargement du check-in: ' . $e->getMessage());
        }
    }
    
    public function updateAppointment(Request $request, $id)
    {
        try {
            $doctor = auth()->user();
            $result = $this->appointmentService->updateAppointment($id, $request->all());
            
            if ($result) {
                return redirect()->route('doctor.appointments')->with('success', 'Rendez-vous mis à jour avec succès.');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de la mise à jour du rendez-vous.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du rendez-vous: ' . $e->getMessage());
        }
    }
    
    public function destroyAppointment($id)
    {
        try {
            $doctor = auth()->user();
            $result = $this->appointmentService->deleteAppointment($id);
            
            if ($result) {
                return redirect()->route('doctor.appointments')->with('success', 'Rendez-vous supprimé avec succès.');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de la suppression du rendez-vous.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du rendez-vous: ' . $e->getMessage());
        }
    }
    
    public function searchPatients(Request $request)
    {
        try {
            $doctor = auth()->user();
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
            $doctor = auth()->user();
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
            $doctor = auth()->user();
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
            $doctor = auth()->user();
            $patients = Patient::all();
            
            return view('doctor.messages.create', compact('patients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du message: ' . $e->getMessage());
        }
    }
    
    public function activities()
    {
        try {
            $doctor = auth()->user();
            
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
            $doctor = auth()->user();
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
            $doctor = auth()->user();
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
            $doctor = auth()->user();
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
    public function createAppointment(){
        try {
            $doctor = auth()->user();
            $patients = Patient::all();
            
            return view('doctor.appointments.create', compact('patients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du rendez-vous: ' . $e->getMessage());
        }
    }
}
