<?php

namespace App\Repositories\Eloquent;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\Interfaces\DoctorRepositoryInterface;
use Carbon\Carbon;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function getAll()
    {
        $doctor = auth()->user();
        $appointments_count = Appointment::where('doctor_id', $doctor->id)->count();
        $patients = Appointment::with('patient')->where('doctor_id', $doctor->id)->get();
        $patients_count = $patients->count();

        return [
            'doctor' => $doctor,
            'appointments_count' => $appointments_count,
            'patients_count' => $patients_count
        ];
    }

    public function getById($id)
    {
        return Doctor::findOrFail($id);
    }

    public function create($data)
    {
        return Doctor::create($data);
    }

    public function update($id, $data)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }

    public function delete($id)
    {
        return Doctor::destroy($id);
    }

    public function getDoctorDetails($doctorId)
    {
        return Doctor::with('user')->findOrFail($doctorId);
    }
}
