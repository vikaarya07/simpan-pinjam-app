<?php

namespace App\Jobs;

use App\Models\Loan;
use App\Models\Meeting;
use App\Services\CustomerNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendPaymentReminder implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $loanId,
        public int $meetingId,
    ) {}

    public function handle(
        CustomerNotificationService $notification
    ): void {
        $loan = Loan::find($this->loanId);

        $meeting = Meeting::find($this->meetingId);

        if (! $loan || ! $meeting) {
            return;
        }

        // Loan sudah selesai
        if (
            $loan->status !== 'running' ||
            $loan->remaining <= 0
        ) {
            return;
        }

        // Customer ternyata sudah membayar
        $alreadyPaid = $loan->payments()
            ->where('meeting_id', $meeting->id)
            ->exists();

        if ($alreadyPaid) {
            return;
        }

        $notification->paymentReminder(
            $loan,
            $meeting,
        );
    }
}
