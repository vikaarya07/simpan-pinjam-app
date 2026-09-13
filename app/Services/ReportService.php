<?php

namespace App\Services;

use App\Enums\LoanType;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Saving;
use Carbon\Carbon;

class ReportService
{
    //  Monthly Report
    public function monthly(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        //  Anggota
        $members = Member::query()
            ->where('status', 'Active')
            ->count();

        //  Loan
        $loans = Loan::query()
            ->with('member')
            ->whereBetween('loan_date', [$start, $end])
            ->orderBy('loan_date')
            ->get();

        //  Payment
        $payments = Payment::query()
            ->with([
                'loan.member',
                'meeting',
            ])
            ->whereBetween('payment_date', [$start, $end])
            ->orderBy('payment_date')
            ->get();

        //  Saving
        $savings = Saving::query()
            ->whereBetween('transaction_date', [$start, $end])
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        //  Saldo Awal
        $openingSaving = Saving::query()
            ->where('transaction_date', '<', $start)
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->first();

        $openingBalance = $openingSaving?->balance ?? 0;
        $openingReceivable = $openingSaving?->receivable ?? 0;

        //  Saldo Akhir
        $closingSaving = Saving::query()
            ->where('transaction_date', '<=', $end)
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->first();

        $closingBalance = $closingSaving?->balance ?? $openingBalance;
        $closingReceivable = $closingSaving?->receivable ?? $openingReceivable;

        //  Saving Summary
        $debit = $payments->sum('amount');

        $credit = $loans
            ->where('type', LoanType::Loan)
            ->sum('principal');

        //  Report
        return [
            'period' => [
                'start' => $start,
                'end' => $end,
                'label' => $start->translatedFormat('F Y'),
            ],

            'summary' => [
                'members' => $members,

                //  Loan
                'loan_count' => $loans->count(),
                'loan_principal' => $loans->sum('principal'),
                'loan_interest' => $loans->sum('interest_amount'),
                'loan_amount' => $loans->sum('amount'),

                //  Payment                                
                'payment_count' => $payments->count(),
                'payment_amount' => $payments->sum('amount'),

                //  Saving
                'opening_balance' => $openingBalance,
                'opening_receivable' => $openingReceivable,

                'debit' => $debit,
                'credit' => $credit,

                'closing_balance' => $closingBalance,
                'closing_receivable' => $closingReceivable,

                //  Amount = Balance + Receivable
                'opening_amount' =>
                $openingBalance + $openingReceivable,

                'closing_amount' =>
                $closingBalance + $closingReceivable,
            ],

            'loans' => $loans,
            'payments' => $payments,
            'savings' => $savings,
        ];
    }

    //  Customer Report
    public function customer(Member $customer): array
    {
        $loans = $customer->loans()
            ->with('payments')
            ->orderByDesc('loan_date')
            ->orderByDesc('id')
            ->get();

        $overdueLoans = $loans->where('type', LoanType::LoanOverdue);

        $normalLoans = $loans->where('type', LoanType::Loan);

        $summary = [
            'loan_count' => $loans->count(),

            'loan_amount' => $normalLoans->sum('amount'),

            'payment_amount' => $loans
                ->flatMap->payments
                ->sum('amount'),

            //  Remaining
            //  Jika terdapat Loan Overdue, gunakan remaining dari
            //  Loan Overdue sebagai piutang aktif customer.
            'remaining' => $overdueLoans->isNotEmpty()
                ? $overdueLoans->sum('remaining')
                : $normalLoans->sum('remaining'),
        ];

        return [
            'customer' => $customer,
            'summary' => $summary,
            'loans' => $loans,
        ];
    }

    // Create Notification From Payment
    public function createNotification(Payment $payment): void
    {
        $notificationService = app(NotificationService::class);

        $payment->loadMissing([
            'loan.member',
            'meeting',
        ]);

        $loan = $payment->loan;

        if (! $loan) {
            return;
        }

        // Pembayaran membuat pinjaman menjadi lunas.
        if ((float) $loan->remaining <= 0) {
            $notificationService->paidOff($payment);

            return;
        }

        // Pembayaran ke-6 tetapi masih memiliki sisa.
        if ((int) $payment->payment_count === 6) {
            // Bukti pembayaran pinjaman lama.
            $notificationService->paymentReceived($payment);

            // Cari Loan Overdue yang baru dibuat.
            $overdueLoan = Loan::query()
                ->where('previous_loan_id', $loan->id)
                ->where('type', LoanType::LoanOverdue)
                ->latest('id')
                ->first();

            if ($overdueLoan) {
                $notificationService->loanOverdueCreated(
                    loan: $overdueLoan,
                    meetingId: $payment->meeting_id,
                );
            }

            return;
        }

        // Pembayaran biasa.
        $notificationService->paymentReceived($payment);
    }
}
