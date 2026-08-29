<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\CustomerNotification;
use App\Models\Loan;
use App\Models\Payment;

class CustomerNotificationService
{
    public function __construct(
        protected NotificationService $notification,
    ) {}

    public function loanCreated(Loan $loan): CustomerNotification
    {
        $existing = CustomerNotification::query()
            ->where('loan_id', $loan->id)
            ->where('type', NotificationType::LoanCreated)
            ->first();

        if ($existing) {
            return $existing;
        }

        $loan->loadMissing('member');

        return CustomerNotification::create([
            'member_id' => $loan->member_id,
            'loan_id' => $loan->id,
            'payment_id' => null,
            'meeting_id' => null,
            'type' => NotificationType::LoanCreated,
            'message' => $this->notification->loanCreated($loan),
        ]);
    }

    public function paymentReceived(Payment $payment): CustomerNotification
    {
        $existing = CustomerNotification::query()
            ->where('payment_id', $payment->id)
            ->first();

        if ($existing) {
            return $existing;
        }

        $payment->loadMissing([
            'loan.member',
        ]);

        $loan = $payment->loan;

        if ($loan->remaining <= 0) {
            $type = NotificationType::PaidOff;

            $message = $this->notification
                ->paidOff($payment);
        } elseif ((int) $payment->payment_count === 5) {
            $type = NotificationType::AlmostPaidOff;

            $message = $this->notification
                ->almostPaidOff($payment);
        } else {
            $type = NotificationType::PaymentReceived;

            $message = $this->notification
                ->paymentReceived($payment);
        }

        return CustomerNotification::create([
            'member_id' => $loan->member_id,
            'loan_id' => $loan->id,
            'payment_id' => $payment->id,
            'meeting_id' => $payment->meeting_id,
            'type' => $type,
            'message' => $message,
        ]);
    }

    public function paymentReminder(Loan $loan): ?CustomerNotification
    {
        $existing = CustomerNotification::query()
            ->where('loan_id', $loan->id)
            ->where('type', NotificationType::PaymentReminder)
            ->whereDate('created_at', today())
            ->first();

        if ($existing) {
            return $existing;
        }

        if (
            $loan->status !== 'running' ||
            $loan->remaining <= 0
        ) {
            return null;
        }

        $loan->loadMissing('member');

        return CustomerNotification::create([
            'member_id' => $loan->member_id,
            'loan_id' => $loan->id,
            'payment_id' => null,
            'meeting_id' => null,
            'type' => NotificationType::PaymentReminder,
            'message' => $this->notification->paymentReminder($loan),
        ]);
    }
}
