<?php

namespace App\Repositories\Eloquent;

use App\Models\Patient;
use App\Models\User;
use App\Repositories\Interfaces\PatientRepositoryInterface;

class PatientRepository implements PatientRepositoryInterface
{
    public function getAll()
    {
        $patients = User::where('role', 'patient')->with('patient')->get();

        return $patients->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'status' => $user->status,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'addresse' => $user->addresse,
                'country' => $user->country,
                'patient_details' => $user->patient,
            ];
        });
    }

    public function getById($id)
    {
        $patient = User::where('role', 'patient')->find($id);
        return Patient::findOrFail($id);
    }

    public function create($data)
    {
        return Patient::create($data);
    }

    public function update($id, $data)
    {
        $doctor = Patient::findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }

    public function delete($id)
    {
        return Patient::destroy($id);
    }
    public function getByDoctorId($doctorId)
    {
        return Patient::where('doctor_id', $doctorId)->get();
    }


    
}
