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
        // dd($doctorId);
        $details = $this->doctorService->getDoctorDetails($doctorId);
        $todayAppointments = $this->appointmentService->getTodayAppointments($doctorId);
        $todayAppointmentsConfirmed = $this->appointmentService->getTodayAppointments($doctorId)->where('status', 'confirmed')->first();
        // dd(isset($todayAppointmentsConfirmed));
        $appointments = $this->appointmentService->getByDoctorId($doctorId);
        // dd($appointments);
        // dd($appointments[0]->patient->user->name);
        $appointmentsUnique = $this->appointmentService->getByDoctorId($doctorId);

        // dd($patients);
        $countPatients = $this->appointmentService->getCountByPatientsByDoctorId($doctorId);
        // dd($todayAppointments[0]->date->format('d/m/Y'));
        // dd($countPatients);

        // foreach($appointments as $appointment) {
        //     if ($appointment->patient && !$appointmentsUnique->contains('id', $appointment->patient->id)) {
        //         $appointmentsUnique->push($appointment->patient);
        //     }
        // }

        // dd($appointmentsUnique);

        $revenue = $this->appointmentService->getTotalRevenue($doctorId) ?? 0;

        $speciality = null;
        if ($details && isset($details->id_speciality)) {
            $speciality = Speciality::where('id', $details->id_speciality)->first();
        }

        $monthlyRevenue = $revenue;
        $reviewCount = 120;

        $nextAppointment = $todayAppointments->sortBy([
            ['date', 'asc'],
            ['time', 'asc'],
        ])->first();
        
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
        $visitsChartData = $this->appointmentService->getByDoctorId($doctorId)->groupBy(function ($appointment) {
            return \Carbon\Carbon::parse($appointment->date)->format('M');
        })->map(function ($appointments) {
            return $appointments->count();
        })->values()->toArray();

        $revenueChartLabels = ['Consultations', 'Traitements', 'Tests Labo', 'Médicaments', 'Autres'];
        $revenueChartData = [35, 25, 20, 15, 5];
        $totalRevenue = $revenue ?? 5000;
        $revenueIncreasePercent = 8;

        $weather = (object) ['temperature' => 22, 'city' => 'Youssoufia'];

        $activePatientCount = $appointmentsUnique->count();
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
            'patientsCount' => $appointmentsUnique->count(),
            'revenue' => $revenue,
            'patients' => $appointmentsUnique,
            'patient' => $appointmentsUnique->first(),
            'nextAppointment' => $nextAppointment ? $nextAppointmentCountdown : 'Aucun rendez-vous prévu'
        ];

        return view('doctor.dashboard', compact(
            'details',
            'revenue',
            'todayAppointments',
            'appointmentsUnique',
            'monthlyRevenue',
            'reviewCount',
            'nextAppointment',
            'nextAppointmentCountdown',
            'currentDateTime',
            'currentMonth',
            'currentYear',
            'prevMonth',
            'prevYear',
            'nextMonth',
            'nextYear',
            'calendarDays',
            'visitsChartLabels',
            'visitsChartData',
            'revenueChartLabels',
            'revenueChartData',
            'totalRevenue',
            'revenueIncreasePercent',
            'weather',
            'activePatientCount',
            'activePatientPercent',
            'patientsThisWeek',
            'patientsWeeklyChangePercent',
            'followUpsCount',
            'urgentFollowUpsCount',
            'appointments',
            'speciality',
            'doctorId',
            'stats',
            'todayAppointmentsConfirmed',
            'countPatients'
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

    public function showPatient($id)
    {
        try {
            $user = auth()->user();
            $patient = $this->patientService->findPatientById($id);
            $appointments = Appointment::where('patient_id', $patient->id)
                ->where('doctor_id', auth()->user()->doctor->id)
                ->orderBy('date', 'desc')
                ->take(5)
                ->get();

            return view('doctor.patients.show', compact('patient', 'appointments'));
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
            ]);
            $randomPassword = bin2hex(random_bytes(4));
            $password = bcrypt($randomPassword);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $password,
                'role' => 'patient',
                'phone' => $validated['phone'] ?? null,
                'adresse' => $validated['adresse'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'name_assurance' => $validated['name_assurance'] ?? null,
                'assurance_number' => $validated['assurance_number'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
            ]);
            return redirect()->route('doctor.dashboard')->with('success', 'Patient créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du patient: ' . $e->getMessage());
        }
    }

    public function editPatient($id)
    {
        $patient = $this->patientService->getPatientById($id)->first();
        return view('doctor.patients.edit', compact('patient'));
    }

    public function updatePatient(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'name_assurance' => 'nullable|string|max:255',
            'assurance_number' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'emergency_contact' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
        ]);

        try {
            $patient = $this->patientService->getPatientById($id)->firstOrFail();
            
            $patient->update([
                'emergency_contact' => $validated['emergency_contact'] ?? $patient->emergency_contact,
                'name_assurance' => $validated['name_assurance'] ?? $patient->name_assurance,
                'assurance_number' => $validated['assurance_number'] ?? $patient->assurance_number,
                'blood_type' => $validated['blood_type'],
            ]);

            $patient->user()->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'adresse' => $validated['adresse'],
                'date_of_birth' => $validated['date_of_birth'],
                'email' => $validated['email'],
            ]);

            return redirect()->back()->with('success', 'Patient mis à jour avec succès.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Patient introuvable.');
        } catch (\Throwable $e) {
            \Log::error('Erreur updatePatient: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du patient.');
        }
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

            return view('doctor.appointments.show', compact('appointment', 'patient', 'user', 'doctor', 'speciality'));
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
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
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

    public function createAppointment()
    {
        try {
            $detailsDoctor = auth()->user();
            $doctor = $this->doctorService->getDoctorDetails($detailsDoctor->doctor->id);
            // dd($doctor);
            $patients = Appointment::where('doctor_id', $doctor->id)->with('patient')->get();

            $patientUserIds = [];
            foreach ($patients as $appointment) {
                if ($appointment->patient && $appointment->patient->user_id) {
                    $patientUserIds[] = $appointment->patient->user_id;
                }
            }
            $users = User::whereIn('id', $patientUserIds)->get();

            return view('doctor.appointments.create', compact('detailsDoctor', 'doctor', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du rendez-vous: ' . $e->getMessage());
        }
    }

    public function storeAppointment(Request $request)
    {
        try {
            $data = $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'reason' => 'required|string',
                'status' => 'required|in:pending,confirmed,completed,canceled',
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

    public function changeStatus(Request $request, $id)
    {
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

    public function pending()
    {
        return view('doctor.pending');
    }
}