<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur
     */
    public function showProfile()
    {
        $user = Auth::user();
        
        if ($user->isDoctor()) {
            $profile = Doctor::where('user_id', $user->id)->first();
            return view('profile.doctor', compact('user', 'profile'));
        } elseif ($user->isPatient()) {
            $profile = Patient::where('user_id', $user->id)->first();
            return view('profile.patient', compact('user', 'profile'));
        } elseif ($user->isAdmin()) {
            return view('profile.admin', compact('user'));
        }
        
        return view('profile.show', compact('user'));
    }
    
    /**
     * Mettre à jour le profil de l'utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        // Vérifier le mot de passe actuel si un nouveau mot de passe est fourni
        if (isset($validated['password']) && !Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }
        
        // Mettre à jour les informations de base
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->address = $validated['address'] ?? $user->address;
        
        // Mettre à jour le mot de passe si fourni
        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        // Mettre à jour les informations spécifiques au rôle
        if ($user->isDoctor() && $request->has('speciality')) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $doctor->speciality = $request->speciality;
                $doctor->experience = $request->experience;
                $doctor->qualification = $request->qualification;
                $doctor->is_available = $request->has('is_available');
                $doctor->save();
            }
        } elseif ($user->isPatient()) {
            $patient = Patient::where('user_id', $user->id)->first();
            if ($patient && $request->has('medical_history')) {
                $patient->medical_history = $request->medical_history;
                $patient->blood_type = $request->blood_type;
                $patient->emergency_contact = $request->emergency_contact;
                $patient->save();
            }
        }
        
        return back()->with('success', 'Profil mis à jour avec succès.');
    }
    
    /**
     * Afficher les paramètres de l'utilisateur
     */
    public function showSettings()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }
}