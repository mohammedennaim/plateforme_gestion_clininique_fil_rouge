<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Services\DossierMedicalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DossierMedicalController extends Controller
{
    protected $dossierMedicalService;

    public function __construct(DossierMedicalService $dossierMedicalService)
    {
        $this->dossierMedicalService = $dossierMedicalService;
    }

    /**
     * Afficher la liste des dossiers médicaux
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $dossiersMedicaux = $this->dossierMedicalService->getAllByDoctorId($doctor->id);
        } elseif ($user->isPatient()) {
            $patient = Patient::where('user_id', $user->id)->first();
            $dossiersMedicaux = $this->dossierMedicalService->getAllByPatientId($patient->id);
        } else {
            $dossiersMedicaux = $this->dossierMedicalService->getAll();
        }
        
        return view('dossiers.index', compact('dossiersMedicaux'));
    }

    /**
     * Afficher le formulaire de création d'un dossier médical
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        return view('dossiers.create', compact('patients'));
    }

    /**
     * Enregistrer un nouveau dossier médical
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnostic' => 'required|string',
            'traitement' => 'nullable|string',
            'notes' => 'nullable|string',
            'date_consultation' => 'required|date',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        
        $user = Auth::user();
        $doctorId = null;
        
        if ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $doctorId = $doctor->id;
        }
        
        $dossierMedical = $this->dossierMedicalService->create(array_merge(
            $validated,
            ['doctor_id' => $doctorId]
        ));
        
        return redirect()->route('dossiers.show', $dossierMedical->id)
            ->with('success', 'Dossier médical créé avec succès.');
    }

    /**
     * Afficher un dossier médical spécifique
     */
    public function show($id)
    {
        $dossierMedical = $this->dossierMedicalService->getById($id);
        
        if (!$dossierMedical) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Dossier médical non trouvé.');
        }
        
        // Vérification des autorisations
        $user = Auth::user();
        $canAccess = false;
        
        if ($user->isAdmin()) {
            $canAccess = true;
        } elseif ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $canAccess = $dossierMedical->doctor_id == $doctor->id;
        } elseif ($user->isPatient()) {
            $patient = Patient::where('user_id', $user->id)->first();
            $canAccess = $dossierMedical->patient_id == $patient->id;
        }
        
        if (!$canAccess) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à consulter ce dossier médical.');
        }
        
        return view('dossiers.show', compact('dossierMedical'));
    }

    /**
     * Afficher le formulaire de modification d'un dossier médical
     */
    public function edit($id)
    {
        $dossierMedical = $this->dossierMedicalService->getById($id);
        
        if (!$dossierMedical) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Dossier médical non trouvé.');
        }
        
        // Vérification des autorisations
        $user = Auth::user();
        $canEdit = false;
        
        if ($user->isAdmin()) {
            $canEdit = true;
        } elseif ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $canEdit = $dossierMedical->doctor_id == $doctor->id;
        }
        
        if (!$canEdit) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce dossier médical.');
        }
        
        $patients = Patient::with('user')->get();
        return view('dossiers.edit', compact('dossierMedical', 'patients'));
    }

    /**
     * Mettre à jour un dossier médical
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnostic' => 'required|string',
            'traitement' => 'nullable|string',
            'notes' => 'nullable|string',
            'date_consultation' => 'required|date',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        
        $dossierMedical = $this->dossierMedicalService->getById($id);
        
        if (!$dossierMedical) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Dossier médical non trouvé.');
        }
        
        // Vérification des autorisations
        $user = Auth::user();
        $canUpdate = false;
        
        if ($user->isAdmin()) {
            $canUpdate = true;
        } elseif ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $canUpdate = $dossierMedical->doctor_id == $doctor->id;
        }
        
        if (!$canUpdate) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce dossier médical.');
        }
        
        $this->dossierMedicalService->update($id, $validated);
        
        return redirect()->route('dossiers.show', $id)
            ->with('success', 'Dossier médical mis à jour avec succès.');
    }

    /**
     * Supprimer un dossier médical
     */
    public function destroy($id)
    {
        $dossierMedical = $this->dossierMedicalService->getById($id);
        
        if (!$dossierMedical) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Dossier médical non trouvé.');
        }
        
        // Vérification des autorisations
        $user = Auth::user();
        $canDelete = false;
        
        if ($user->isAdmin()) {
            $canDelete = true;
        } elseif ($user->isDoctor()) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $canDelete = $dossierMedical->doctor_id == $doctor->id;
        }
        
        if (!$canDelete) {
            return redirect()->route('dossiers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce dossier médical.');
        }
        
        $this->dossierMedicalService->delete($id);
        
        return redirect()->route('dossiers.index')
            ->with('success', 'Dossier médical supprimé avec succès.');
    }

    /**
     * Afficher les dossiers du patient connecté
     */
    public function patientIndex()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return redirect()->route('home')
                ->with('error', 'Profil patient non trouvé.');
        }
        
        $dossiersMedicaux = $this->dossierMedicalService->getAllByPatientId($patient->id);
        
        return view('patient.dossiers.index', compact('dossiersMedicaux'));
    }
}