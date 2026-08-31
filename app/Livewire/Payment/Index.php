<?php

namespace App\Livewire\Payment;

use App\Enums\LoanType;
use App\Enums\PaymentStatus;
use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[On('payment-saved')]
    public function refreshPayments(): void
    {
        $this->resetPage();
    }

    protected function loadPaymentSummaries(Collection $meetings): void
    {
        if ($meetings->isEmpty()) {
            return;
        }

        /*
         * Ambil semua pasangan Meeting + Loan yang memenuhi
         * aturan forMeeting(), dalam SATU query.
         */
        $rows = Loan::query()
            ->select([
                'loans.id',
                'loans.member_id',
                'loans.loan_date',
            ])
            ->selectRaw('meetings.id as meeting_id')
            ->leftJoin('meetings', function ($join) {
                $join->whereColumn(
                    'loans.loan_date',
                    '<',
                    'meetings.meeting_date'
                );
            })
            ->whereIn('loans.type', [
                LoanType::Loan,
                LoanType::LoanOverdue,
            ])
            ->where('loans.status', 'running')
            ->whereIn('meetings.id', $meetings->pluck('id'))
            ->whereRaw('DATE(loans.loan_date) < DATE(meetings.meeting_date)')
            ->whereRaw(
                '(SELECT COUNT(*)
                  FROM payments
                  WHERE payments.loan_id = loans.id) < 6'
            )
            ->get();

        /*
         * Ambil payment untuk pasangan meeting + loan
         * yang sudah ditemukan di atas.
         */
        $payments = Payment::query()
            ->without(['loan', 'meeting'])
            ->whereIn('meeting_id', $meetings->pluck('id'))
            ->whereIn('loan_id', $rows->pluck('id')->unique())
            ->get()
            ->groupBy(fn($payment) => "{$payment->meeting_id}:{$payment->loan_id}");

        /*
         * Buat summary untuk setiap meeting.
         */
        foreach ($meetings as $meeting) {
            $loans = $rows->where('meeting_id', $meeting->id);

            $clear = 0;
            $skip = 0;
            $unpaid = 0;

            foreach ($loans as $loan) {
                $payment = $payments->get(
                    "{$meeting->id}:{$loan->id}"
                )?->first();

                if (! $payment) {
                    $unpaid++;
                    continue;
                }

                match ($payment->status) {
                    PaymentStatus::Clear => $clear++,
                    PaymentStatus::Skip => $skip++,
                };
            }

            /*
             * Attach hasil ke model Meeting.
             *
             * Blade tetap bisa memakai:
             * $meeting->payment_summary
             */
            $meeting->setAttribute('payment_summary', [
                'clear' => $clear,
                'skip' => $skip,
                'unpaid' => $unpaid,
            ]);
        }
    }

    public function render()
    {
        $meetings = Meeting::search($this->search)
            ->orderByDesc('meeting_date')
            ->orderByDesc('created_at')
            ->paginate(10);

        $this->loadPaymentSummaries(
            $meetings->getCollection()
        );

        return view('livewire.payment.index', [
            'paymentStatus' => PaymentStatus::class,
            'meetings' => $meetings,
        ]);
    }
}
