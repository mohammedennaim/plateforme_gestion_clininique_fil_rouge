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
        // $doctor = auth()->user(); // Supposons que le médecin est connecté
        // $rondez_vous_count = AppointmentRepository::where('doctor_id', $doctor->id)->count();
        // $patients = Patient::where('doctor_id', $doctor->id)->get();
        // $patients_count = $patients->count();
        // return [
        //     'doctor' => $doctor,
        //     'rondez_vous_count' => $rondez_vous_count,
        //     'patients' => $patients,
        //     'patients_count' => $patients_count,
        // ];

        // $doctors = User::where('role', 'doctor')->with('doctor')->get();
        // dd(auth()->user()->id);
        // $doctor = Doctor::with('user')->where('user_id', auth()->user()->id)->get();
        // // dd($doctor);
        // $user = User::findOrFail($doctor->user_id);
        // $doctors = Doctor::All();

        // // $tousAppointments = Appointment::where('doctor_id', $doctor->id)->with('patient')->get();
        // $countPatients = $tousAppointments->where('doctor_id', $doctor->id)->count();
        //     // dd($countPatients);
        // $appointments = Appointment::where('doctor_id', $doctor->id)
        //     ->whereDate('date', now()->format('Y-m-d'))
        //     ->whereTime('time', '>=', now()->format('H:i:s'))
        //     ->count();
        // // For debugging, you can use: dd($appointments);
        // // dd($user);
        
        // // $patients_count = $patients->count();
        // $doctors = Doctor::All();
        // return [
        //     'doctors' =>$doctors,
        //     'doctor' => $user,
        //     'appointments_count' => $appointments,
        //     'patients_count' => $countPatients,
        // ];  

        $doctors = User::where('role', 'doctor')->with('doctor')->get();
        return $doctors->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'doctor_details' => $user->doctor,
            ];
        });
        
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
}
