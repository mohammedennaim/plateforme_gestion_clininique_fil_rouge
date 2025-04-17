<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sender = User::factory();
        $receiver = User::factory();

        return [
            'sender_id' => $sender,
            'receiver_id' => $receiver,
            'content' => fake()->paragraph(),
            'read_at' => fake()->randomElement([null, fake()->dateTimeBetween('-1 week', 'now')]),
            'status' => fake()->randomElement(['sent', 'delivered', 'read']),
        ];
    }

    /**
     * Message is unread
     */
    public function unread()
    {
        return $this->state(function (array $attributes) {
            return [
                'read_at' => null,
                'status' => 'delivered',
            ];
        });
    }

    /**
     * Message is read
     */
    public function read()
    {
        return $this->state(function (array $attributes) {
            return [
                'read_at' => now(),
                'status' => 'read',
            ];
        });
    }

    /**
     * Message from doctor to patient
     */
    public function fromDoctorToPatient()
    {
        return $this->state(function (array $attributes) {
            return [
                'sender_id' => User::factory()->doctor(),
                'receiver_id' => User::factory()->patient(),
            ];
        });
    }

    /**
     * Message from patient to doctor
     */
    public function fromPatientToDoctor()
    {
        return $this->state(function (array $attributes) {
            return [
                'sender_id' => User::factory()->patient(),
                'receiver_id' => User::factory()->doctor(),
            ];
        });
    }
}
