<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\CustomerNotification;
use App\Models\Loan;
use App\Models\Payment;

class NotificationService
{
    /*
    |--------------------------------------------------------------------------
    | Loan Created
    |--------------------------------------------------------------------------
    */

    public function loanCreated(Loan $loan): CustomerNotification
    {
        $loan->loadMissing('member');

        return $this->create(
            type: NotificationType::LoanCreated,
            memberId: $loan->member_id,
            message: $this->loanCreatedMessage($loan),
            loanId: $loan->id,
        );
    }

    private function loanCreatedMessage(Loan $loan): string
    {
        $member = $loan->member;

        return implode("\n", [
            '📝 *BUKTI PINJAMAN*',
            '',
            "Halo *{$member->name}*,",
            '',
            'Pinjaman Anda telah berhasil dibuat.',
            '',
            "No. Pinjaman   : {$loan->loan_number}",
            'Tanggal        : ' . $loan->waktu,
            '',
            'Pokok Pinjaman : ' . $this->money($loan->principal),
            "Jasa ({$loan->interest_percent}%)      : " . $this->money($loan->interest_amount),
            'Total          : ' . $this->money($loan->amount),
            '',
            'Angsuran       : Maksimal 6 kali',
            '',
            'Terima kasih.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Received
    |--------------------------------------------------------------------------
    */

    public function paymentReceived(Payment $payment): CustomerNotification
    {
        $payment->loadMissing([
            'loan.member',
            'meeting',
        ]);

        $loan = $payment->loan;

        return $this->create(
            type: NotificationType::PaymentReceived,
            memberId: $loan->member_id,
            message: $this->paymentReceivedMessage($payment),
            loanId: $loan->id,
            paymentId: $payment->id,
            meetingId: $payment->meeting_id,
        );
    }

    private function paymentReceivedMessage(Payment $payment): string
    {
        $loan = $payment->loan;
        $member = $loan->member;

        return implode("\n", [
            '💵 *BUKTI PEMBAYARAN*',
            '',
            "Halo *{$member->name}*,",
            '',
            'Pembayaran Anda telah kami terima.',
            '',
            "No. Pinjaman : {$loan->loan_number}",
            'Angsuran     : ' . ($payment->payment_count ?? '-'),
            'Tanggal      : ' . ($payment->waktu ?? '-'),
            '',
            'Pembayaran   : ' . $this->money($payment->amount),
            'Metode       : ' . ($payment->method
                ? $payment->method->value
                : '-'),
            '',
            'Sisa Pinjaman: ' . $this->money($loan->remaining),
            '',
            'Terima kasih.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Reminder
    |--------------------------------------------------------------------------
    */

    public function paymentReminder(
        Loan $loan,
        ?int $meetingId = null,
    ): CustomerNotification {
        $loan->loadMissing('member');

        $member = $loan->member;

        $nextPayment = ((int) $loan->payments()->max('payment_count')) + 1;

        return $this->create(
            type: NotificationType::PaymentReminder,
            memberId: $loan->member_id,
            message: $this->paymentReminderMessage($loan, $nextPayment),
            loanId: $loan->id,
            meetingId: $meetingId,
        );
    }

    private function paymentReminderMessage(
        Loan $loan,
        int $nextPayment,
    ): string {
        $member = $loan->member;

        return implode("\n", [
            '🔔 *REMINDER PEMBAYARAN*',
            '',
            "Halo *{$member->name}*,",
            '',
            'Kami mengingatkan bahwa Anda masih memiliki',
            'angsuran yang perlu dibayarkan.',
            '',
            "No. Pinjaman  : {$loan->loan_number}",
            "Angsuran      : {$nextPayment} dari 6",
            'Sisa Pinjaman : ' . $this->money($loan->remaining),
            '',
            'Silakan melakukan pembayaran pada pertemuan berikutnya.',
            '',
            'Terima kasih.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Almost Paid Off
    |--------------------------------------------------------------------------
    */

    public function almostPaidOff(Payment $payment): CustomerNotification
    {
        $payment->loadMissing([
            'loan.member',
        ]);

        $loan = $payment->loan;

        return $this->create(
            type: NotificationType::AlmostPaidOff,
            memberId: $loan->member_id,
            message: $this->almostPaidOffMessage($payment),
            loanId: $loan->id,
            paymentId: $payment->id,
            meetingId: $payment->meeting_id,
        );
    }

    private function almostPaidOffMessage(Payment $payment): string
    {
        $loan = $payment->loan;
        $member = $loan->member;

        return implode("\n", [
            '🎉 *HAMPIR LUNAS*',
            '',
            "Halo *{$member->name}*,",
            '',
            'Terima kasih, pembayaran angsuran ke-5',
            'telah kami terima.',
            '',
            "No. Pinjaman : {$loan->loan_number}",
            'Angsuran     : 5 dari 6',
            'Pembayaran   : ' . $this->money($payment->amount),
            '',
            'Sisa Pinjaman: ' . $this->money($loan->remaining),
            '',
            'Anda tinggal melakukan 1 kali angsuran lagi',
            'untuk menyelesaikan pinjaman ini.',
            '',
            'Terima kasih.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Paid Off
    |--------------------------------------------------------------------------
    */

    public function paidOff(Payment $payment): CustomerNotification
    {
        $payment->loadMissing([
            'loan.member',
        ]);

        $loan = $payment->loan;

        return $this->create(
            type: NotificationType::PaidOff,
            memberId: $loan->member_id,
            message: $this->paidOffMessage($payment),
            loanId: $loan->id,
            paymentId: $payment->id,
            meetingId: $payment->meeting_id,
        );
    }

    private function paidOffMessage(Payment $payment): string
    {
        $loan = $payment->loan;
        $member = $loan->member;

        return implode("\n", [
            '🎉 *PINJAMAN LUNAS*',
            '',
            "Halo *{$member->name}*,",
            '',
            'Pembayaran Anda telah diterima dan',
            'pinjaman berikut telah dinyatakan lunas.',
            '',
            "No. Pinjaman  : {$loan->loan_number}",
            'Angsuran      : ' . ($payment->payment_count ?? '-'),
            'Tanggal       : ' . ($payment->waktu ?? '-'),
            '',
            'Pembayaran    : ' . $this->money($payment->amount),
            'Sisa Pinjaman : Rp 0',
            '',
            'Terima kasih telah melakukan pembayaran.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Create Notification
    |--------------------------------------------------------------------------
    */

    private function create(
        NotificationType $type,
        int $memberId,
        string $message,
        ?int $loanId = null,
        ?int $paymentId = null,
        ?int $meetingId = null,
    ): CustomerNotification {
        return CustomerNotification::create([
            'member_id' => $memberId,
            'loan_id' => $loanId,
            'payment_id' => $paymentId,
            'meeting_id' => $meetingId,
            'type' => $type,
            'message' => $message,
        ]);
    }

    private function money(float|int|string|null $amount): string
    {
        return 'Rp ' . number_format(
            (float) $amount,
            0,
            ',',
            '.',
        );
    }
}
