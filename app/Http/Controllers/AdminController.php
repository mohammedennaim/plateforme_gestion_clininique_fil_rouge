<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class AdminController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        try {
            $patients = $this->dashboardService->getAllPatients();
            
            $doctors = $this->dashboardService->getAllDoctors()->map(function ($doctor) {
                return [
                    'id' => $doctor->id ?? null,
                    'name' => $doctor->user->name ?? 'N/A',
                    'email' => $doctor->user->email ?? 'N/A',
                    'phone' => $doctor->user->phone ?? 'N/A',
                    'doctor_details' => $doctor,
                    'status' => $doctor->user->status ?? 'inactive',
                    'is_available' => $doctor->is_available ?? false,
                    'speciality' => $doctor->speciality ?? 'N/A',
                    'nombre_cabinet' => $doctor->nombre_cabinet ?? 'N/A',
                    'qualification' => $doctor->qualification ?? 'N/A'
                ];
            });

            $appointments = $this->dashboardService->getAllAppointments();
            $totalPatients = $this->dashboardService->getTotalPatients();
            $totalDoctors = $this->dashboardService->getTotalDoctors();
            $totalAppointments = $this->dashboardService->getTotalAppointments();
            $totalRevenue = $this->dashboardService->getTotalRevenue();
            $todayAppointments = $this->dashboardService->getTodayAppointments();
            $pendingRequests = $this->dashboardService->getPendingRequests();

            return view('admin.dashboard', compact(
                'patients',
                'doctors',
                'appointments',
                'totalPatients',
                'totalDoctors',
                'totalAppointments',
                'totalRevenue',
                'todayAppointments',
                'pendingRequests'
            ));
        } catch (\Exception $e) {
            \Log::error('Admin Dashboard Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors du chargement du tableau de bord: ' . $e->getMessage());
        }
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
