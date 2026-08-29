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
            'meeting_date' => '2026-08-29 19:30:00',
            'place' => 'Room 9',
        ]);
        Meeting::create([
            'meeting_date' => '2026-08-22 19:30:00',
            'place' => 'Room 8',
        ]);
        Meeting::create([
            'meeting_date' => '2026-08-15 19:30:00',
            'place' => 'Room 7',
        ]);
        Meeting::create([
            'meeting_date' => '2026-08-08 19:30:00',
            'place' => 'Room 6',
        ]);
        Meeting::create([
            'meeting_date' => '2026-08-01 19:30:00',
            'place' => 'Room 5',
        ]);
        Meeting::create([
            'meeting_date' => '2026-07-25 19:30:00',
            'place' => 'Room 4',
        ]);
        Meeting::create([
            'meeting_date' => '2026-07-18 19:30:00',
            'place' => 'Room 3',
        ]);
        Meeting::create([
            'meeting_date' => '2026-07-11 19:30:00',
            'place' => 'Room 2',
        ]);
        Meeting::create([
            'meeting_date' => '2026-07-04 19:30:00',
            'place' => 'Room 1',
        ]);

        Member::create([
            'npk' => 'S003',
            'name' => 'Mulyono',
            'email' => 'mulyono@gmail.com',
            'phone' => '0817895984',
            'gender' => 'Male',
            'date_birth' => '1999-07-09',
            'date_join' => '2013-08-17',
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
