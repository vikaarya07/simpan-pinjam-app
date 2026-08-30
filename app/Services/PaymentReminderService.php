<?php

namespace App\Services;

use App\Jobs\SendPaymentReminder;
use App\Models\Loan;
use App\Models\Meeting;

class PaymentReminderService
{
    public function dispatchForMeeting(Meeting $meeting): int
    {
        $count = 0;

        Loan::query()
            ->where('status', 'running')
            ->where('remaining', '>', 0)
            ->whereHas('member', function ($query) {
                $query->where('status', 'Active');
            })
            ->whereDoesntHave('payments', function ($query) use ($meeting) {
                $query->where('meeting_id', $meeting->id);
            })
            ->chunkById(100, function ($loans) use ($meeting, &$count) {
                foreach ($loans as $loan) {
                    SendPaymentReminder::dispatch(
                        $loan->id,
                        $meeting->id,
                    );

                    $count++;
                }
            });

        return $count;
    }
}
