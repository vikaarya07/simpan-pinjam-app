<?php

namespace App\Jobs;

use App\Models\Loan;
use App\Models\Meeting;
use App\Services\NotificationService;
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
        NotificationService $service
    ): void {
        $loan = Loan::find($this->loanId);

        $meeting = Meeting::find($this->meetingId);

        if (! $loan || ! $meeting) {
            return;
        }

        $service->paymentReminder(
            loan: $loan,
            meetingId: $meeting->id,
        );
    }
}
