<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\DashboardService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    protected $patientService;
    protected $dashboardService;

    public function __construct(PatientService $patientService, DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
        $this->patientService = $patientService;
    }

    public function index(Request $request)
    {
        $query = $request->input('search');
        $patients = $query 
            ? $this->patientService->searchPatients($query)
            : Patient::with('user')->paginate(10);

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'name_assurance' => 'nullable|string|max:255',
            'assurance_number' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'emergency_contact' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|array',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $patient = $this->patientService->createPatient($validated);

        return redirect()
            ->route('admin.patients.show', $patient)
            ->with('success', 'Patient créé avec succès');
    }

    public function show(Patient $patient)
    {
        $visitor = $this->dashboardService->getPatientById($patient->id);
        $appointments = $this->dashboardService->getAppointmentsByPatientId($patient->id);
// dd($patient);
        
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'phone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'name_assurance' => 'nullable|string|max:255',
            'assurance_number' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'emergency_contact' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|array',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $patient = $this->patientService->updatePatient($patient, $validated);

        return redirect()
            ->route('admin.patients.show', $patient)
            ->with('success', 'Patient mis à jour avec succès');
    }

    public function destroy(Patient $patient)
    {
        $this->patientService->deletePatient($patient);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient supprimé avec succès');
    }

    public function stats(): JsonResponse
    {
        $stats = $this->patientService->getPatientStats();
        return response()->json($stats);
    }
} 