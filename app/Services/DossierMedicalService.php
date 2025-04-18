<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Collection;

class DossierMedicalService
{
    /**
     * Récupère le dossier médical d'un patient par son ID
     * 
     * @param int $patientId
     * @return object|null
     */
    public function getByPatientId($patientId)
    {
        // Pour l'instant, nous renvoyons un mock de dossier médical
        // À remplacer par une vraie implémentation avec modèles et base de données
        $patient = Patient::find($patientId);
        if (!$patient) {
            return null;
        }

        return (object) [
            'id' => $patientId,
            'patient_id' => $patientId,
            'patient_name' => $patient->name ?? 'Nom du patient',
            'blood_type' => $patient->blood_type ?? 'O+',
            'height' => $patient->height ?? 175,
            'weight' => $patient->weight ?? 70,
            'allergies' => $patient->allergies ?? ['Pollen', 'Arachides'],
            'chronic_diseases' => ['Hypertension', 'Asthme'],
            'created_at' => now()->subMonths(6),
            'updated_at' => now()->subDays(10),
            'medical_history' => $patient->medical_history ?? 'Historique médical à compléter',
            'last_visit_date' => now()->subDays(30)->format('Y-m-d'),
            'prescribed_medications' => [
                ['name' => 'Paracétamol', 'dosage' => '500mg', 'frequency' => '3 fois par jour', 'duration' => '7 jours'],
                ['name' => 'Amoxicilline', 'dosage' => '250mg', 'frequency' => '2 fois par jour', 'duration' => '10 jours']
            ],
            'treatments' => [
                ['type' => 'Kinésithérapie', 'sessions' => 10, 'status' => 'En cours'],
                ['type' => 'Orthophonie', 'sessions' => 5, 'status' => 'Terminé']
            ],
            'notes' => 'Patient en bonne santé générale. Suivi régulier recommandé.'
        ];
    }

    /**
     * Récupère tous les dossiers médicaux d'un patient
     * 
     * @param int $patientId
     * @return Collection
     */
    public function getAllByPatientId($patientId)
    {
        // Pour l'instant, nous renvoyons un mock de dossier médical
        // À remplacer par une vraie implémentation avec modèles et base de données
        return collect([
            $this->getByPatientId($patientId),
            (object) [
                'id' => $patientId + 1000,
                'patient_id' => $patientId,
                'title' => 'Consultation spécialiste',
                'date' => now()->subMonths(3)->format('Y-m-d'),
                'doctor' => 'Dr. Sophie Martin',
                'specialty' => 'Cardiologie',
                'diagnosis' => 'Examen cardiaque normal',
                'notes' => 'Pas de traitement particulier prescrit.'
            ],
            (object) [
                'id' => $patientId + 2000,
                'patient_id' => $patientId,
                'title' => 'Examen annuel',
                'date' => now()->subYears(1)->format('Y-m-d'),
                'doctor' => 'Dr. Jean Dupont',
                'specialty' => 'Médecine générale',
                'diagnosis' => 'Bonne santé générale',
                'notes' => 'Patient en excellente forme physique.'
            ]
        ]);
    }

    /**
     * Crée un nouveau dossier médical pour un patient
     * 
     * @param array $data
     * @return object
     */
    public function create($data)
    {
        // À implémenter avec un vrai modèle et base de données
        return (object) array_merge([
            'id' => rand(1000, 9999),
            'created_at' => now(),
            'updated_at' => now()
        ], $data);
    }

    /**
     * Met à jour le dossier médical d'un patient
     * 
     * @param int $id
     * @param array $data
     * @return object
     */
    public function update($id, $data)
    {
        // À implémenter avec un vrai modèle et base de données
        return (object) array_merge([
            'id' => $id,
            'updated_at' => now()
        ], $data);
    }

    /**
     * Récupère tous les dossiers médicaux
     * 
     * @return Collection
     */
    public function getAll()
    {
        // Simulating database query
        $patients = Patient::take(10)->get();
        $records = collect();
        
        foreach ($patients as $patient) {
            $records->push($this->getByPatientId($patient->id));
        }
        
        return $records;
    }
    
    /**
     * Récupère un dossier médical par son ID
     * 
     * @param int $id
     * @return object|null
     */
    public function getById($id)
    {
        // Pour l'instant, nous renvoyons un mock de dossier médical
        // Simulating find by ID
        return (object) [
            'id' => $id,
            'patient_id' => rand(1, 100),
            'title' => 'Dossier médical #' . $id,
            'date' => now()->subDays(rand(1, 30))->format('Y-m-d'),
            'doctor' => 'Dr. ' . ['Jean Dupont', 'Marie Martin', 'Pierre Durand'][rand(0, 2)],
            'diagnosis' => 'Diagnostic exemple',
            'notes' => 'Notes d\'exemple pour le dossier médical'
        ];
    }
    
    /**
     * Récupère tous les dossiers médicaux d'un docteur
     * 
     * @param int $doctorId
     * @return Collection
     */
    public function getAllByDoctorId($doctorId)
    {
        // Simulating database query
        return collect([
            (object) [
                'id' => $doctorId * 10 + 1,
                'patient_id' => rand(1, 100),
                'title' => 'Consultation routine',
                'date' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'doctor_id' => $doctorId,
                'diagnosis' => 'Examen de routine normal',
                'notes' => 'Patient en bonne santé'
            ],
            (object) [
                'id' => $doctorId * 10 + 2,
                'patient_id' => rand(1, 100),
                'title' => 'Traitement suivi',
                'date' => now()->subDays(rand(1, 15))->format('Y-m-d'),
                'doctor_id' => $doctorId,
                'diagnosis' => 'Suivi de traitement',
                'notes' => 'Évolution positive du traitement'
            ]
        ]);
    }
    
    /**
     * Supprime un dossier médical
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        // Simuler la suppression (retourne toujours true pour l'instant)
        return true;
    }
}