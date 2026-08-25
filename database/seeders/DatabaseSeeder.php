<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\Member;
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

        Meeting::create([
            'meeting_date' => '2026-07-04',
            'place' => 'Room 1',
        ]);
        Meeting::create([
            'meeting_date' => '2026-07-11',
            'place' => 'Room 2',
        ]);
        Meeting::create([
            'meeting_date' => '2026-07-18',
            'place' => 'Room 3',
        ]);
        Meeting::create([
            'meeting_date' => '2026-07-25',
            'place' => 'Room 4',
        ]);
        Meeting::create([
            'meeting_date' => '2026-08-01',
            'place' => 'Room 5',
        ]);
        Meeting::create([
            'meeting_date' => '2026-08-08',
            'place' => 'Room 6',
        ]);

        Member::create([
            'npk' => 'S001',
            'name' => 'Janggar',
            'email' => 'janggar@gmail.com',
            'phone' => '08512598592',
            'gender' => 'Male',
            'date_birth' => '2000-01-12',
            'date_join' => '2014-08-17',
            'status' => 'Active',
        ]);
        Member::create([
            'npk' => 'S002',
            'name' => 'Wowo',
            'email' => 'wowo@gmail.com',
            'phone' => '08788994984',
            'gender' => 'Male',
            'date_birth' => '2002-02-02',
            'date_join' => '2016-08-17',
            'status' => 'Active',
        ]);

        // Saving::create([
        //     'transaction_date' => now(),
        //     'type' => 'Opening',
        //     'debit' => 5000000,
        //     'credit' => 0,
        //     'balance' => 5000000,
        //     'receivable' => 0,
        //     'amount' => 5000000,
        //     'description' => 'Saldo Awal Kas',
        // ]);

    }
}
