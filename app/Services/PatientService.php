<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientService
{
    public function createPatient(array $data): Patient
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'patient',
                'phone' => $data['phone'] ?? null,
                'adresse' => $data['adresse'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
            ]);

            return Patient::create([
                'user_id' => $user->id,
                'name_assurance' => $data['name_assurance'] ?? null,
                'assurance_number' => $data['assurance_number'] ?? null,
                'blood_type' => $data['blood_type'] ?? null,
                'emergency_contact' => $data['emergency_contact'] ?? null,
                'medical_history' => $data['medical_history'] ?? null,
                'allergies' => $data['allergies'] ?? null,
                'height' => $data['height'] ?? null,
                'weight' => $data['weight'] ?? null,
            ]);
        });
    }

    public function updatePatient(Patient $patient, array $data): Patient
    {
        return DB::transaction(function () use ($patient, $data) {
            $patient->user->update([
                'name' => $data['name'] ?? $patient->user->name,
                'email' => $data['email'] ?? $patient->user->email,
                'phone' => $data['phone'] ?? $patient->user->phone,
                'adresse' => $data['adresse'] ?? $patient->user->adresse,
                'date_of_birth' => $data['date_of_birth'] ?? $patient->user->date_of_birth,
            ]);

            $patient->update([
                'name_assurance' => $data['name_assurance'] ?? $patient->name_assurance,
                'assurance_number' => $data['assurance_number'] ?? $patient->assurance_number,
                'blood_type' => $data['blood_type'] ?? $patient->blood_type,
                'emergency_contact' => $data['emergency_contact'] ?? $patient->emergency_contact,
                'medical_history' => $data['medical_history'] ?? $patient->medical_history,
                'allergies' => $data['allergies'] ?? $patient->allergies,
                'height' => $data['height'] ?? $patient->height,
                'weight' => $data['weight'] ?? $patient->weight,
            ]);

            return $patient->fresh();
        });
    }

    public function deletePatient(Patient $patient): bool
    {
        return DB::transaction(function () use ($patient) {
            $patient->appointments()->delete();
            $patient->delete();
            $patient->user->delete();
            return true;
        });
    }

    public function getPatientStats(): array
    {
        return [
            'total' => Patient::count(),
            'with_insurance' => Patient::withInsurance()->count(),
            'without_insurance' => Patient::withoutInsurance()->count(),
            'active' => Patient::active()->count(),
            'by_blood_type' => Patient::select('blood_type', DB::raw('count(*) as total'))
                ->groupBy('blood_type')
                ->get()
                ->pluck('total', 'blood_type'),
            'average_age' => Patient::with('user')
                ->get()
                ->avg('age'),
        ];
    }

    public function searchPatients(string $query)
    {
        return Patient::with('user')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('phone', 'like', "%{$query}%");
            })
            ->orWhere('name_assurance', 'like', "%{$query}%")
            ->orWhere('assurance_number', 'like', "%{$query}%")
            ->get();
    }

    public function getPatientById($id)
    {
        return Patient::with('user')->findOrFail($id);
    }
} 