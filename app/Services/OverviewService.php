<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Saving;
use Carbon\Carbon;

class OverviewService
{
    public function get(string $activitySort = 'date'): array
    {
        $today = Carbon::today();

        return [
            'financial' => $this->financial(),
            'members' => $this->members(),
            'loans' => $this->loans(),
            'monthly' => $this->monthly(
                $today->copy()->startOfMonth(),
                $today->copy()->endOfMonth(),
            ),
            'payments' => $this->payments(),
            'activities' => $this->activities(
                limit: 5,
                sort: $activitySort,
            ),
            'today' => [
                'loans' => Loan::query()
                    ->whereDate('loan_date', $today)
                    ->count(),
                'payments' => Payment::query()
                    ->whereDate('payment_date', $today)
                    ->count(),
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Financial
    |--------------------------------------------------------------------------
    */

    protected function financial(): array
    {
        $saving = Saving::query()
            ->latest('transaction_date')
            ->latest('id')
            ->first();

        return [
            'balance' => (float) ($saving?->balance ?? 0),
            'receivable' => (float) ($saving?->receivable ?? 0),
            'amount' => (float) ($saving?->amount ?? 0),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Members
    |--------------------------------------------------------------------------
    */

    protected function members(): array
    {
        $customers = Member::query()
            ->whereHas('loans', function ($query) {
                $query->whereIn('status', [
                    'running',
                    'finish',
                ]);
            });

        return [
            'total' => Member::count(),

            'active' => Member::query()
                ->where('status', 'Active')
                ->count(),

            'inactive' => Member::query()
                ->where('status', 'Inactive')
                ->count(),

            'customers' => $customers->count(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Loans
    |--------------------------------------------------------------------------
    */

    protected function loans(): array
    {
        $running = Loan::query()
            ->where('status', 'running');

        $finish = Loan::query()
            ->where('status', 'finish');

        $overdue = Loan::query()
            ->where('status', 'overdue');

        return [
            'total_count' => Loan::count(),

            'running_count' => (clone $running)->count(),
            'running_amount' => (float) (clone $running)->sum('amount'),

            'finish_count' => (clone $finish)->count(),
            'finish_amount' => (float) (clone $finish)->sum('amount'),

            'overdue_count' => (clone $overdue)->count(),
            'overdue_amount' => (float) (clone $overdue)->sum('amount'),

            'total_amount' => (float) Loan::sum('amount'),

            'remaining' => (float) Loan::query()
                ->whereIn('status', [
                    'running',
                    'overdue',
                ])
                ->sum('remaining'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Monthly
    |--------------------------------------------------------------------------
    */

    protected function monthly(
        Carbon $startOfMonth,
        Carbon $endOfMonth,
    ): array {
        $loanQuery = Loan::query()
            ->whereBetween('loan_date', [
                $startOfMonth,
                $endOfMonth,
            ]);

        $paymentQuery = Payment::query()
            ->whereBetween('payment_date', [
                $startOfMonth,
                $endOfMonth,
            ]);

        return [
            'loan_count' => (clone $loanQuery)->count(),
            'loan_amount' => (float) (clone $loanQuery)->sum('amount'),

            'payment_count' => (clone $paymentQuery)->count(),
            'payment_amount' => (float) (clone $paymentQuery)->sum('amount'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */

    protected function payments(): array
    {
        /*
         * Ambil seluruh payment untuk meeting 1-6
         * hanya dengan 1 query.
         */
        $payments = Payment::query()
            ->without([
                'loan',
                'meeting',
            ])
            ->whereBetween('payment_count', [1, 6])
            ->get()
            ->groupBy('payment_count');

        /*
         * Ambil seluruh loan running sekali.
         *
         * Kita hanya membutuhkan:
         * - id
         * - daftar payment_count yang sudah dimiliki
         */
        $runningLoans = Loan::query()
            ->where('status', 'running')
            ->with([
                'payments:id,loan_id,payment_count',
            ])
            ->get();

        $meetings = [];

        for ($number = 1; $number <= 6; $number++) {
            $meetingPayments = $payments->get($number, collect());

            $unpaid = $runningLoans
                ->filter(
                    fn(Loan $loan) => ! $loan->payments
                        ->contains('payment_count', $number)
                )
                ->count();

            $meetings[] = [
                'number' => $number,

                'clear' => $meetingPayments
                    ->where('amount', '>', 0)
                    ->count(),

                'skip' => $meetingPayments
                    ->where('amount', 0)
                    ->count(),

                'unpaid' => $unpaid,
            ];
        }

        return [
            'total' => Payment::count(),

            'amount' => (float) Payment::sum('amount'),

            'meetings' => $meetings,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Recent Activities
    |--------------------------------------------------------------------------
    */

    protected function activities(
        int $limit = 5,
        string $sort = 'date',
    ): array {
        $loans = Loan::query()
            ->with('member')
            ->when(
                $sort === 'created',
                fn($query) => $query
                    ->latest('created_at')
                    ->latest('id'),
                fn($query) => $query
                    ->latest('loan_date')
                    ->latest('id'),
            )
            ->limit($limit)
            ->get()
            ->map(function (Loan $loan) use ($sort) {
                return [
                    'type' => 'loan',
                    'title' => __('app.overview.activity.loan_created'),
                    'description' => $loan->member?->name
                        . ' - '
                        . $loan->loan_number,
                    'time' => $sort === 'created'
                        ? $loan->created_at
                        : $loan->loan_date,
                    'amount' => (float) $loan->amount,
                ];
            });

        $payments = Payment::query()
            ->with('loan.member')
            ->when(
                $sort === 'created',
                fn($query) => $query
                    ->latest('created_at')
                    ->latest('id'),
                fn($query) => $query
                    ->latest('payment_date')
                    ->latest('id'),
            )
            ->limit($limit)
            ->get()
            ->map(function (Payment $payment) use ($sort) {
                return [
                    'type' => 'payment',
                    'title' => __('app.overview.activity.payment_created'),
                    'description' => $payment->loan?->member?->name ?? '-',
                    'time' => $sort === 'created'
                        ? $payment->created_at
                        : $payment->payment_date,
                    'amount' => (float) $payment->amount,
                ];
            });

        return $loans
            ->concat($payments)
            ->sortByDesc('time')
            ->take($limit)
            ->values()
            ->all();
    }
}
