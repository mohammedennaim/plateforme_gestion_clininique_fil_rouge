<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        // return response()->json($this->dashboardService->getAllDoctors());
        return view('admin.dashboard');
    }

    public function showDoctor($id)
    {
        return response()->json($this->dashboardService->getDoctorById($id));
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

    public function showPatients()
    {
        $patients = $this->dashboardService->getAllPatients();
        // dd($patients);
        return view('admin.dashboard', compact('patients'));
    }

}
