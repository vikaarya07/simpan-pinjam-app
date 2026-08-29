<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Payment;

class NotificationService
{
    public function loanCreated(Loan $loan): string
    {
        $loan->loadMissing('member');

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

    public function paymentReceived(Payment $payment): string
    {
        $payment->loadMissing([
            'loan.member',
            'meeting',
        ]);

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

    public function paymentReminder(Loan $loan): string
    {
        $loan->loadMissing('member');

        $member = $loan->member;

        $nextPayment = ((int) $loan->payments()->max('payment_count')) + 1;

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

    public function almostPaidOff(Payment $payment): string
    {
        $payment->loadMissing([
            'loan.member',
        ]);

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

    public function paidOff(Payment $payment): string
    {
        $payment->loadMissing([
            'loan.member',
        ]);

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

    private function money(float|int|string|null $amount): string
    {
        return 'Rp ' . number_format(
            (float) $amount,
            0,
            ',',
            '.'
        );
    }
}
