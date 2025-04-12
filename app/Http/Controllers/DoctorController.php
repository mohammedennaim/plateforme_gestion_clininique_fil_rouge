<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Patient;
use App\Models\User;
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
        // $doctorAuth = User::auth();
        // dd($auth);
        $details =  $this->dashboardService->getAllDoctors();
        $doctor = $details['doctor'];
        
        $appointments_count = $details['appointments_count'];
        $patients_count = $details['patients_count'];
        $todayAppointments = $this->dashboardService->getTodayAppointments()->where('doctor_id', 4);
        // dd($todayAppointments);
        return view('doctor.dashboard', compact('doctor', 'appointments_count', 'patients_count', 'todayAppointments'));
    }
}
