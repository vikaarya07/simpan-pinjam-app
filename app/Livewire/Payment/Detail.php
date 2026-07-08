<?php

namespace App\Livewire\Payment;

use App\Models\Payment;
use Livewire\Component;

class Detail extends Component
{
    public Payment $payment;

    public function mount(Payment $payment): void
    {
        $this->payment = $payment->load([
            'loan.member',
            'loan',
        ]);
    }

    public function getTotalPaidProperty(): float
    {
        return $this->payment->loan
            ->payments()
            ->sum('amount');
    }

    public function getRemainingProperty(): float
    {
        $loan = $this->payment->loan;

        return max(0, $loan->amount - $this->totalPaid);
    }

    public function render()
    {
        return view('livewire.payment.detail');
    }
}
