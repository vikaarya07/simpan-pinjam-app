<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['Male', 'Female']);
        $name = $gender === 'Male'
            ? fake('id_ID')->name('male')
            : fake('id_ID')->name('female');

        return [
            'npk' => 'S' . fake()->unique()->numerify('###'),
            'name' => $name,
            'email' => fake('id_ID')->unique()->safeEmail(),
            'phone' => '08' . fake()->numerify('##########'),
            'gender' => $gender,
            'date_birth' => fake()->dateTimeBetween('-32 years', '-15 years')
                ->format('Y-m-d'),
            'date_join' => fake()->dateTimeBetween('-5 years', 'now')
                ->format('Y-m-d'),
            'status' => fake()->randomElement(['Active', 'Inactive']),
        ];
    }
}
