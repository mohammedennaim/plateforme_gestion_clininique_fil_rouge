<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création d'un super admin
        $adminUser = User::factory()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@mediclinic.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        
        Admin::factory()->create([
            'user_id' => $adminUser->id
        ]);

        // Création des spécialités
        Speciality::factory(7)->create();

        // Création de 5 médecins avec leurs utilisateurs associés
        Doctor::factory(5)->create();

        // Création de 20 patients avec leurs utilisateurs associés
        Patient::factory(20)->create();

        // Récupération de tous les patients et médecins pour créer des rendez-vous
        $patients = Patient::all();
        $doctors = Doctor::all();

        // Création de 50 rendez-vous
        foreach ($patients as $patient) {
            // 2-3 rendez-vous par patient avec des médecins aléatoires
            $numAppointments = rand(2, 3);
            for ($i = 0; $i < $numAppointments; $i++) {
                $doctor = $doctors->random();
                $appointment = Appointment::factory()->create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id
                ]);

                // 70% des rendez-vous ont un paiement
                if (rand(1, 10) <= 7) {
                    Payment::factory()->create([
                        'user_id' => $patient->user_id,
                        'appointment_id' => $appointment->id,
                    ]);
                }
                
                // 60% des rendez-vous confirmés ont un dossier médical
                if ($appointment->status === 'confirmed' && rand(1, 10) <= 6) {
                    MedicalRecord::factory()->create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                    ]);
                }
            }

            // Messages entre patients et médecins
            $doctor = $doctors->random();
            Message::factory()->fromPatientToDoctor()->create([
                'sender_id' => $patient->user_id,
                'receiver_id' => $doctor->user_id,
            ]);
            
            // Le médecin répond parfois
            if (rand(1, 10) <= 6) {
                Message::factory()->fromDoctorToPatient()->create([
                    'sender_id' => $doctor->user_id,
                    'receiver_id' => $patient->user_id,
                ]);
            }
        }

        // Création de quelques rendez-vous supplémentaires pour les prochains jours
        for ($i = 0; $i < 15; $i++) {
            $patient = $patients->random();
            $doctor = $doctors->random();
            $futureDate = now()->addDays(rand(1, 30));
            
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'date' => $futureDate->format('Y-m-d'),
                'status' => 'confirmed',
            ]);
        }

        // Création de quelques modèles supplémentaires pour les dossiers médicaux
        MedicalRecord::factory(10)->withFollowUp()->create([
            'patient_id' => $patients->random()->id,
            'doctor_id' => $doctors->random()->id,
        ]);
    }
}
