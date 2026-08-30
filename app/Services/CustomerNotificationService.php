<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\CustomerNotification;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Payment;

class CustomerNotificationService
{
    public function create(
        Member $member,
        NotificationType $type,
        string $title,
        string $message,
        ?Loan $loan = null,
        ?Payment $payment = null,
        ?int $meetingId = null,
        array $data = [],
    ): CustomerNotification {
        return CustomerNotification::create([
            'member_id' => $member->id,
            'loan_id' => $loan?->id,
            'payment_id' => $payment?->id,
            'meeting_id' => $meetingId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function loanCreated(Loan $loan): CustomerNotification
    {
        $loan->loadMissing('member');

        return $this->create(
            member: $loan->member,
            type: NotificationType::LoanCreated,
            title: 'Pinjaman Baru',
            message: "Pinjaman {$loan->loan_number} berhasil dibuat.",
            loan: $loan,
            data: [
                'loan_number' => $loan->loan_number,
                'principal' => $loan->principal,
                'amount' => $loan->amount,
                'interest_amount' => $loan->interest_amount,
            ],
        );
    }

    public function paymentReceived(Payment $payment): CustomerNotification
    {
        $payment->loadMissing([
            'loan.member',
            'meeting',
        ]);

        $loan = $payment->loan;

        return $this->create(
            member: $loan->member,
            type: NotificationType::PaymentReceived,
            title: 'Pembayaran Diterima',
            message: sprintf(
                'Pembayaran sebesar Rp %s telah diterima.',
                number_format(
                    $payment->amount,
                    0,
                    ',',
                    '.'
                )
            ),
            loan: $loan,
            payment: $payment,
            meetingId: $payment->meeting_id,
            data: [
                'amount' => $payment->amount,
                'payment_date' => $payment->payment_date,
                'payment_count' => $payment->payment_count,
            ],
        );
    }

    public function almostPaidOff(Loan $loan): CustomerNotification
    {
        $loan->loadMissing('member');

        return $this->create(
            member: $loan->member,
            type: NotificationType::AlmostPaidOff,
            title: 'Pinjaman Hampir Lunas',
            message: "Pinjaman {$loan->loan_number} Anda hampir lunas.",
            loan: $loan,
            data: [
                'remaining' => $loan->remaining,
            ],
        );
    }

    public function paidOff(Loan $loan): CustomerNotification
    {
        $loan->loadMissing('member');

        return CustomerNotification::firstOrCreate(
            [
                'member_id' => $loan->member_id,
                'loan_id' => $loan->id,
                'type' => NotificationType::PaidOff,
            ],
            [
                'title' => 'Pinjaman Lunas',
                'message' => "Pinjaman {$loan->loan_number} Anda telah lunas.",
                'data' => [
                    'remaining' => 0,
                ],
            ],
        );
    }
}
