<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorService
{
    public function getDoctorDetails($doctorId)
    {
        return Doctor::with(['user', 'speciality'])
            ->where('id', $doctorId)
            ->firstOrFail();
    }

    public function getDoctorStats(Doctor $doctor): array
    {
        return [
            'total_patients' => $doctor->patients()->count(),
            'total_appointments' => $doctor->appointments()->count(),
            'today_appointments' => $doctor->appointments()
                ->whereDate('appointment_date', today())
                ->count(),
            'total_revenue' => $doctor->appointments()
                ->where('status', 'completed')
                ->sum('price')
        ];
    }

    public function getDoctorAppointments(Doctor $doctor, string $status = null)
    {
        $query = $doctor->appointments()->with('patient');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->orderBy('appointment_date', 'desc')
            ->paginate(10);
    }

    public function getDoctorPatients(Doctor $doctor)
    {
        return $doctor->patients()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function updateAppointmentStatus(Appointment $appointment, string $status): bool
    {
        return $appointment->update(['status' => $status]);
    }

    public function deleteAppointment(Appointment $appointment): bool
    {
        return $appointment->delete();
    }
}
