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
        // return response()->json($this->dashboardService->getAllDoctors());
        $patients = $this->dashboardService->getAllPatients();
        $doctors = $this->dashboardService->getAllDoctors();
        $appointments = $this->dashboardService->getAllAppointments();
        $totalPatients = $this->dashboardService->getTotalPatients();
        $totalDoctors = $this->dashboardService->getTotalDoctors();
        $totalAppointments = $this->dashboardService->getTotalAppointments();
        $totalRevenue = $this->dashboardService->getTotalRevenue();
        $todayAppointments = $this->dashboardService->getTodayAppointments();
        $pendingRequests = $this->dashboardService->getPendingRequests();
        // $monthlyRevenue = $this->dashboardService->getMonthlyRevenue();
        $today = now()->format('Y-m-d');
        // $appointments = $this->dashboardService->getAppointmentsByDate($today);
        return view('admin.dashboard', compact('patients', 'doctors', 'appointments', 'totalPatients', 'totalDoctors', 'totalAppointments', 'totalRevenue', 'todayAppointments', 'pendingRequests'));
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
        return response()->json($this->dashboardService->updateDoctor($id, $request->all()));
    }

    public function destroyDoctor($id)
    {
        return response()->json($this->dashboardService->deleteDoctor($id));
    }

    // public function showPatients()
    // {
    //     $patients = $this->dashboardService->getAllPatients();
    //     return view('admin.dashboard', compact('patients'));
    // }

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

}
