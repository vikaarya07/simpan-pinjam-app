<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loanNumber = 'LN-' . now()->format('Ymd') . '-' . str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);

        $principal = $this->faker->numberBetween(1000000, 10000000);

        $type = $this->faker->randomElement([
            'loan',
            'loan_overdue'
        ]);

        $rate = $type === 'loan_overdue' ? 10 : 5;

        $interest = ($principal * $rate) / 100;
        $amount = $principal + $interest;

        return [
            'member_id' => Member::factory(),
            'loan_number' => $loanNumber,
            'slug' => Str::slug($loanNumber),
            'loan_date' => $this->faker->date(),
            'type' => $type,
            'principal' => $principal,
            'interest_percent' => $rate,
            'interest_amount' => $interest,
            'amount' => $amount,
            'remaining' => $amount,
            'status' => $this->faker->randomElement([
                'running',
                'finish'
            ]),
        ];
    }
}
