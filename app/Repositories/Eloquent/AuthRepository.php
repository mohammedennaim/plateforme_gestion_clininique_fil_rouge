<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function register($data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => $data['role'] === 'patient' ? 'active' : 'pending',
            'phone' => $data['phone'] ?? null,
            'adresse' => $data['adresse'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
        ]);


        if ($data['role'] === "doctor") {
            $doctor = new DoctorRepository()->create([
                'user_id' => $user->id,
                'speciality' => $data['speciality'],
                'is_available' => true,
                'emergency_contact' => $data['emergency_contact']
            ]);
            $doctor->user()->associate($user);
            $doctor->save();
            return $doctor;
        } else {
            $patient = new PatientRepository()->create([
                'user_id' => $user->id,
                'name_assurance' => $data['name_assurance'],
                'assurance_number' => $data['assurance_number'],
                'blood_type' => $data['blood_type'],
                'emergency_contact' => $data['emergency_contact'],
            ]);
            $patient->user()->associate($user);
            $patient->save();

            return $patient;
        }
    }

    public function login($credentials)
    {

        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($credentials)) {
            return false;
        } else {
            $user = Auth::user();

            if ($user->role === 'doctor') {
                $user->load('doctor');
            } elseif ($user->role === 'patient') {
                $user->load('patient');
            } elseif ($user->role === 'admin') {
                $user->load('admin');
            }

            return $user;
        }



    }
    public function logout()
    {
        Auth::logout();
        return true;
    }
}