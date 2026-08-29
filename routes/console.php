<?php

use App\Models\Meeting;
use App\Services\PaymentReminderService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $meeting = Meeting::query()
        ->whereDate('meeting_date', today()->addDay())
        ->first();

    if (! $meeting) {
        return;
    }

    app(PaymentReminderService::class)
        ->dispatchForMeeting($meeting);
})->dailyAt('08:00');
