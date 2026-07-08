<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $meetings = Meeting::orderBy('meeting_date')->get();

        Loan::all()->each(function (Loan $loan) use ($meetings) {

            $totalPayments = fake()->numberBetween(
                1,
                min(6, $meetings->count())
            );

            for ($i = 1; $i <= $totalPayments; $i++) {

                Payment::factory()->create([

                    'loan_id' => $loan->id,

                    'meeting_id' => $meetings[$i - 1]->id,

                    'payment_count' => $i,

                    'payment_date' => $meetings[$i - 1]->meeting_date,

                ]);
            }
        });
    }
}
