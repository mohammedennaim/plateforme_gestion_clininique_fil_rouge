<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Speciality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->doctor(),
            'speciality' => $this->faker->randomElement(['Cardiologie', 'Dermatologie', 'Gynécologie', 'Pédiatrie', 'Psychiatrie', 'Radiologie', 'Médecine générale']),
            'id_speciality' => function () {
                return Speciality::inRandomOrder()->first()?->id ?? Speciality::factory()->create()->id;
            },
            'is_available' => $this->faker->boolean(80), // 80% chance of being available
            'emergency_contact' => $this->faker->phoneNumber(),
        ];
    }

    /**
     * Doctor who is always available
     */
    public function available()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_available' => true,
            ];
        });
    }
}
