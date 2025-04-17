<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('-1 month', '+2 months');
        
        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'date' => $startTime->format('Y-m-d'),
            'time' => $startTime->format('H:i:s'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'canceled']),
            'reason' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 200, 800),
        ];
    }

    /**
     * Indicate that the appointment is confirmed.
     */
    public function confirmed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the appointment is completed (using confirmed status).
     */
    public function completed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the appointment is cancelled.
     */
    public function cancelled()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'canceled',
        ]);
    }
}
