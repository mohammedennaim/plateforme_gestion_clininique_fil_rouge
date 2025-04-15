<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('admin.dashboard', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'has_insurance' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'has_insurance' => $request->has_insurance ?? false,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Patient ajouté avec succès');
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'has_insurance' => 'boolean',
        ]);

        $patient->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $patient->update([
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'has_insurance' => $request->has_insurance ?? $patient->has_insurance,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Patient mis à jour avec succès');
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete();
        $patient->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Patient supprimé avec succès');
    }
} 