<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Saving;
use Carbon\Carbon;

class ReportService
{
    public function monthly(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        // Anggota
        $members = Member::query()
            ->where('status', 'Active')
            ->count();

        // Loan
        $loans = Loan::query()
            ->with('member')
            ->whereBetween('loan_date', [$start, $end])
            ->orderBy('loan_date')
            ->get();

        // Payment
        $payments = Payment::query()
            ->with([
                'loan.member',
                'meeting',
            ])
            ->whereBetween('payment_date', [$start, $end])
            ->orderBy('payment_date')
            ->get();

        // Saving
        $savings = Saving::query()
            ->whereBetween('transaction_date', [$start, $end])
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        // Saldo Awal
        // Ambil transaksi terakhir sebelum periode report.
        $openingSaving = Saving::query()
            ->where('transaction_date', '<', $start)
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->first();

        $openingBalance = $openingSaving?->balance ?? 0;
        $openingReceivable = $openingSaving?->receivable ?? 0;

        // Saldo Akhir
        $closingSaving = Saving::query()
            ->where('transaction_date', '<=', $end)
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->first();

        $closingBalance = $closingSaving?->balance ?? $openingBalance;
        $closingReceivable = $closingSaving?->receivable ?? $openingReceivable;

        // Saving Summary
        $debit = $savings->sum('debit');

        $credit = $savings->sum('credit');

        // Report
        return [
            'period' => [
                'start' => $start,
                'end' => $end,
                'label' => $start->translatedFormat('F Y'),
            ],

            'summary' => [
                'members' => $members,

                // Loan
                'loan_count' => $loans->count(),
                'loan_principal' => $loans->sum('principal'),
                'loan_interest' => $loans->sum('interest_amount'),
                'loan_amount' => $loans->sum('amount'),

                // Payment
                'payment_count' => $payments->count(),
                'payment_amount' => $payments->sum('amount'),

                // Saving
                'opening_balance' => $openingBalance,
                'opening_receivable' => $openingReceivable,

                'debit' => $debit,
                'credit' => $credit,

                'closing_balance' => $closingBalance,
                'closing_receivable' => $closingReceivable,


                // Amount = Balance + Receivable
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

    public function customer(Member $customer): array
    {
        $customer->load([
            'loans' => fn($query) => $query
                ->with([
                    'payments' => fn($query) => $query
                        ->with('meeting')
                        ->orderBy('payment_date')
                        ->orderBy('id'),
                ])
                ->orderBy('created_at', 'desc'),
        ]);

        $loans = $customer->loans;

        $payments = $loans
            ->flatMap(fn($loan) => $loan->payments);

        return [
            'customer' => $customer,
            'loans' => $loans,
            'payments' => $payments,
            'summary' => [
                'loan_count' => $loans->count(),
                'loan_amount' => $loans->sum('amount'),
                'payment_count' => $payments->count(),
                'payment_amount' => $payments->sum('amount'),
                'remaining' => $loans->sum('remaining'),
            ],
        ];
    }

    // public function monthlyWhatsApp(int $year, int $month): string
    // {
    //     $report = $this->monthly($year, $month);

    //     $summary = $report['summary'];

    //     $money = fn($value) =>
    //     'Rp ' . number_format($value, 0, ',', '.');

    //     return implode("\n", [
    //         '📊 *Laporan Simpan Pinjam SATYA MUDA GETAS*',
    //         '* Bulan '  . $report['period']['label'] . '*',
    //         '',
    //         '👥 *ANGGOTA AKTIF*',
    //         number_format($summary['members'], 0, ',', '.') . ' anggota',
    //         '',
    //         '💰 *PINJAMAN*',
    //         'Transaksi : ' . number_format($summary['loan_count'], 0, ',', '.'),
    //         'Pokok     : ' . $money($summary['loan_principal']),
    //         'Jasa      : ' . $money($summary['loan_interest']),
    //         'Total     : ' . $money($summary['loan_amount']),
    //         '',
    //         '💵 *PEMBAYARAN*',
    //         'Transaksi : ' . number_format($summary['payment_count'], 0, ',', '.'),
    //         'Total     : ' . $money($summary['payment_amount']),
    //         '',
    //         '🏦 *KEUANGAN*',
    //         'Debit    : ' . $money($summary['debit']),
    //         'Credit   : ' . $money($summary['credit']),
    //         'Piutang  : ' . $money($summary['closing_receivable']),
    //         '',
    //         '📌 *SALDO*',
    //         $money($summary['closing_balance']),
    //         '',
    //         '💼 *TOTAL KESELURUHAN*',
    //         $money($summary['closing_amount']),
    //     ]);
    // }
}
