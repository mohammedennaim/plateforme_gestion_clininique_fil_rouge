<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'appointment_id' => Appointment::factory(),
            'amount' => fake()->randomFloat(2, 200, 1500),
            'transaction_id' => 'tx_' . fake()->unique()->regexify('[A-Za-z0-9]{20}'),
            'status' => fake()->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'currency' => 'MAD',
            'payment_method' => fake()->randomElement(['stripe', 'cash', 'insurance']),
            'description' => fake()->sentence(),
        ];
    }

    /**
     * Payment is completed
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
            ];
        });
    }

    /**
     * Payment is pending
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }

    /**
     * Payment is failed
     */
    public function failed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'failed',
            ];
        });
    }
}
