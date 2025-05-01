<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Speciality;
use App\Services\AppointmentService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use App\Services\DashboardService;

class AdminController extends Controller
{
    protected $dashboardService;
    protected $appointmentService;
    protected $patientService;

    public function __construct(DashboardService $dashboardService, AppointmentService $appointmentService, PatientService $patientService)
    {
        $this->appointmentService = $appointmentService;
        $this->dashboardService = $dashboardService;
        $this->patientService = $patientService;
    }

    public function index()
    {
            $patients = $this->dashboardService->getAllPatients();
            $doctors = $this->dashboardService->getAllDoctors()->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->user->name,
                    'email' => $doctor->user->email,
                    'phone' => $doctor->user->phone,
                    'doctor_details' => $doctor,
                    'status' => $doctor->user->status,
                    'is_available' => $doctor->is_available,
                    'speciality' => Speciality::find($doctor->id_speciality)->name,
                ];
            });

            $totalPatients = $this->dashboardService->getTotalPatients();
            $totalDoctors = $this->dashboardService->getTotalDoctorsCount();
            $totalAppointments = $this->dashboardService->getTotalAppointments();
            $totalRevenue = $this->dashboardService->getTotalRevenue();
            $appointments = $this->appointmentService->getAll();
            $pendingAppointments = $this->appointmentService->getPending();
            $confirmedAppointments = $this->appointmentService->getConfirmed();
            $terminatedAppointments = $this->appointmentService->getTermine();
            $canceledAppointments = $this->appointmentService->getCanceled();

            // dd($doctorStats);
            $appointmentStats = [
                'pending' => $pendingAppointments,
                'confirmed' => $confirmedAppointments,
                'terminated' => $terminatedAppointments,
                'canceled' => $canceledAppointments
            ];

            return view('admin.dashboard', compact(
                'patients',
                'doctors',
                'appointments',
                'totalPatients',
                'totalDoctors',
                'totalAppointments',
                'totalRevenue',
                'appointmentStats'
            ));

    }

    public function showPatient(Request $request)
    
    {
        $patient = $this->patientService->getPatientById($request->id)->first();
        $doctors = $this->dashboardService->getAllDoctors();
        // dd($doctors);
        return view('admin.patients.show', compact('patient', 'doctors'));
    }

    public function showDoctor($id)
    {
        $doctor = $this->dashboardService->getDoctorById($id);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function storeDoctor(Request $request)
    {
        return response()->json($this->dashboardService->createDoctor($request->all()), 201);
    }

    public function updateDoctor(Request $request, $id)
    {
        $doctorData= [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role' => $request->input('role'),
        ];
        return response()->json($this->dashboardService->updateDoctor($id, $request->all()));
    }

    public function destroyDoctor($id)
    {
        return response()->json($this->dashboardService->deleteDoctor($id));
    }


    public function storeAppointment(Request $request)
    {
        return response()->json($this->dashboardService->createAppointment($request->all()), 201);
    }
    public function updateAppointment(Request $request, $id)
    {
        return response()->json($this->dashboardService->updateAppointment($id, $request->all()));
    }
    public function destroyAppointment($id)
    {
        return response()->json($this->dashboardService->deleteAppointment($id));
    }
    
    public function editPatient($id)
    {
        $patient = $this->dashboardService->getPatientById($id);
        return view('admin.patients.edit', compact('patient'));
    }

    public function deletePatient($id)
    {
        return view('admin.patients.delete', compact('id'));
    }
}
