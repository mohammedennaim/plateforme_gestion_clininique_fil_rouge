<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Patient;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    protected $dashboardService;
    public function __construct(DashboardService $DashboardService)
    {
        $this->dashboardService = $DashboardService;
    }
    public function index()
    {
        // $doctor = $this->dashboardService->getDoctorById(auth()->user()->id);
        // $rondez_vous_count = $this->dashboardService->getRendezVousCount($doctor->id);
        // $patients = $this->dashboardService->getPatientsByDoctorId($doctor->id);
        // $patients_count = $patients->count();
        $doctor = auth()->user();
        return view('doctor.dashboard', compact('doctor'));
    }
}
