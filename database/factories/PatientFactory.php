<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $allergies = ['Pollen', 'Lactose', 'Gluten', 'Fruits de mer', 'Arachides', 'Pénicilline', null];
        
        return [
            'user_id' => User::factory()->patient(),
            'name_assurance' => fake()->randomElement(['CNOPS', 'CNSS', 'AMO', 'RAMED', null]),
            'assurance_number' => fake()->unique()->numerify('ASR-######'),
            'blood_type' => fake()->randomElement($bloodTypes),
            'emergency_contact' => fake()->phoneNumber(),
            'medical_history' => fake()->paragraph(),
            'allergies' => json_encode(fake()->randomElements($allergies, fake()->numberBetween(0, 3))),
            'height' => fake()->randomFloat(2, 140, 200),
            'weight' => fake()->randomFloat(2, 40, 120),
            'last_visit_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
