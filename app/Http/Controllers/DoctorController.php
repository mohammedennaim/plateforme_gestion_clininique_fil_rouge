<?php

namespace App\Http\Controllers;

use App;
use App\Models\Message;
use App\Models\Patient;
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
       
        $doctor = auth()->user();
        
        $details = $this->doctorService->getDoctorDetails($doctor->id);
        // $patients_count = $this->doctorService->getPatientsCount($doctor->id);
        $revenue = $this->appointmentService->getTotalRevenue();
        $todayAppointments = $this->appointmentService->getTodayAppointments();
        $patients = $this->appointmentService->getByDoctorId($doctor->id);
        // dd(count($revenue));
        // dd( $patients);
        return view('doctor.dashboard', $details,compact('revenue', 'todayAppointments', 'patients'));
        
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
}
