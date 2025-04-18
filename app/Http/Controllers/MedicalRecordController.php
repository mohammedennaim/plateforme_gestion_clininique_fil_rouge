<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the medical records.
     */
    public function index()
    {
        $user = Auth::user();
        $records = [];
        
        if ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $records = $this->medicalRecordService->getDoctorMedicalRecords($doctor->id);
            return view('doctor.medical_records.index', compact('records'));
        } elseif ($user->isPatient()) {
            $patient = Patient::where('user_id', $user->id)->first();
            $records = $this->medicalRecordService->getPatientMedicalRecords($patient->id);
            return view('patient.medical_records.index', compact('records'));
        } elseif ($user->isAdmin()) {
            $records = MedicalRecord::with(['patient', 'doctor'])->get();
            return view('admin.medical_records.index', compact('records'));
        }
        
        return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isDoctor()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        
        $doctor = Doctor::where('user_id', $user->id)->first();
        $patients = Patient::all();
        
        return view('doctor.medical_records.create', compact('patients', 'doctor'));
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isDoctor()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'record_date' => 'required|date',
            'record_type' => 'required|in:lab_results,prescription,medical_image,report,other',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,mp3,mp4|max:10240',
        ]);
        
        $doctor = Doctor::where('user_id', $user->id)->first();
        
        $record = $this->medicalRecordService->uploadMedicalRecord(
            $validated,
            $request->file('file'),
            $doctor->id
        );
        
        return redirect()->route('medical-records.index')
            ->with('success', 'Dossier médical ajouté avec succès.');
    }

    /**
     * Display the specified medical record.
     */
    public function show($id)
    {
        $user = Auth::user();
        $record = MedicalRecord::with(['patient', 'doctor'])->findOrFail($id);
        
        // Check authorization
        $canAccess = false;
        
        if ($user->isAdmin()) {
            $canAccess = true;
        } elseif ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $canAccess = $record->doctor_id == $doctor->id;
        } elseif ($user->isPatient()) {
            $patient = Patient::where('user_id', $user->id)->first();
            $canAccess = $record->patient_id == $patient->id;
        }
        
        if (!$canAccess) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à ce dossier médical.');
        }
        
        return view('medical_records.show', compact('record'));
    }

    /**
     * Download the medical record file.
     */
    public function download($id)
    {
        $user = Auth::user();
        $record = MedicalRecord::findOrFail($id);
        
        // Check authorization
        $canAccess = false;
        
        if ($user->isAdmin()) {
            $canAccess = true;
        } elseif ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $canAccess = $record->doctor_id == $doctor->id;
        } elseif ($user->isPatient()) {
            $patient = Patient::where('user_id', $user->id)->first();
            $canAccess = $record->patient_id == $patient->id;
        }
        
        if (!$canAccess) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à ce fichier.');
        }
        
        if (!Storage::disk('public')->exists($record->file_path)) {
            return redirect()->back()->with('error', 'Le fichier n\'existe pas.');
        }
        
        return Storage::disk('public')->download($record->file_path, $record->file_name);
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $record = MedicalRecord::findOrFail($id);
        
        // Check authorization
        $canDelete = false;
        
        if ($user->isAdmin()) {
            $canDelete = true;
        } elseif ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $canDelete = $record->doctor_id == $doctor->id;
        }
        
        if (!$canDelete) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce dossier médical.');
        }
        
        $this->medicalRecordService->deleteMedicalRecord($id);
        
        return redirect()->route('medical-records.index')
            ->with('success', 'Dossier médical supprimé avec succès.');
    }
}