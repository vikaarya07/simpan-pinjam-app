<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        Member::factory()->count(10)->create();

        Saving::create([
            'transaction_date' => now(),
            'type' => 'Opening',
            'debit' => 5000000,
            'credit' => 0,
            'balance' => 5000000,
            'receivable' => 0,
            'amount' => 5000000,
            'description' => 'Saldo Awal Kas',
        ]);

        Saving::create([
            'transaction_date' => now(),
            'type' => 'Loan',
            'debit' => 0,
            'credit' => 1000000,
            'balance' => 4500000,
            'receivable' => 1000000,
            'amount' => 5550000,
            'description' => 'Pinjaman dari Nasabah',
        ]);

        Saving::create([
            'transaction_date' => now(),
            'type' => 'Assistance',
            'debit' => 500000,
            'credit' => 0,
            'balance' => 5500000,
            'receivable' => 0,
            'amount' => 5500000,
            'description' => 'Bantuan Pemerintah',
        ]);

        Loan::factory()->count(5)->for(Member::factory())->create();
    }
}
