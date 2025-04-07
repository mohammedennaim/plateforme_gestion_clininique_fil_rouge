<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
{$doctorId = auth()->user()->id; // Supposons que le médecin est connecté

    // Récupérer les conversations groupées par patient
    $conversations = Message::with('patient')
        ->where('doctor_id', $doctorId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('patient_id')
        ->map(function ($messages) {
            return [
                'patient' => $messages->first()->patient,
                'unread' => $messages->where('is_read', false)->where('type', 'incoming')->count() > 0,
                'messages' => $messages->map(function ($message) {
                    return [
                        'type' => $message->type,
                        'text' => $message->content,
                        'time' => Carbon::parse($message->created_at)->format('H:i'),
                        'date' => Carbon::parse($message->created_at)->locale('fr')->diffForHumans(),
                    ];
                })->all(),
            ];
        })->values();

    return view('doctor.dashboard', [
        'totalPatients' => Patient::count(),
        'chatMessages' => $conversations,
        // 'todayAppointments' => Appointment::whereDate('date', today())->count(),
        // 'pendingRequests' => Appointment::where('status', 'pending')->count(),
        // 'monthlyRevenue' => Transaction::whereMonth('created_at', now()->month)->sum('amount'),
        // 'appointments' => Appointment::where('date', '>=', today())->get(),
    ]);
}
}
