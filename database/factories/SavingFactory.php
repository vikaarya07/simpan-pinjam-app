<?php

namespace Database\Factories;

use App\Models\Saving;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Saving>
 */
class SavingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_date' => fake()->date(),
            'type' => fake()->randomElement([
                'Opening',
                'Assistance',
                'Loan',
                'Installment',
            ]),
            'debit' => fake()->numberBetween(0, 5000000),
            'credit' => 0,
            'balance' => fake()->numberBetween(100000, 3000000),
            'receivable' => fake()->numberBetween(100000, 3000000),
            'amount' => fake()->numberBetween(300000, 5000000),
            'description' => fake()->sentence(),
        ];
    }
}
