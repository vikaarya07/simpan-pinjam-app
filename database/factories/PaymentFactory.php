<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
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
            'loan_id' => Loan::query()->inRandomOrder()->value('id') ?? Loan::factory(),
            'meeting_id' => Meeting::query()->inRandomOrder()->value('id') ?? Meeting::factory(),
            'amount' => fake()->numberBetween(50_000, 500_000),
            'payment_date' => fake()->date(),
            // 'payment_count' => 0,
            'method' => fake()->randomElement([
                'cash',
                'transfer',
                'qris',
            ]),
            'note' => fake()->sentence(),
        ];
    }
}
