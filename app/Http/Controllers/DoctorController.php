<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
{
    return view('doctor.dashboard', [
        'totalPatients' => Patient::count(),
        // 'todayAppointments' => Appointment::whereDate('date', today())->count(),
        // 'pendingRequests' => Appointment::where('status', 'pending')->count(),
        // 'monthlyRevenue' => Transaction::whereMonth('created_at', now()->month)->sum('amount'),
        // 'appointments' => Appointment::where('date', '>=', today())->get(),
    ]);
}
}
