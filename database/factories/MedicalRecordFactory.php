<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'date_consultation' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'diagnostic' => fake()->paragraph(),
            'traitement' => fake()->text(),
            'notes' => fake()->optional(0.7)->paragraph(),
            'documents' => json_encode([
                fake()->optional(0.4)->imageUrl(),
                fake()->optional(0.3)->imageUrl(),
            ]),
        ];
    }

    /**
     * Record with follow-up recommendations
     */
    public function withFollowUp()
    {
        return $this->state(function (array $attributes) {
            return [
                'notes' => 'Suivi recommandé dans 2 semaines. ' . fake()->paragraph(),
            ];
        });
    }
}
