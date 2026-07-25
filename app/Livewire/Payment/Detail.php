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
            'loan.payments',
        ]);
    }

    public function getTotalPaidProperty(): float
    {
        return (float) $this->payment->loan
            ->payments()
            ->where('payment_count', '<=', $this->payment->payment_count)
            ->sum('amount');
    }

    public function getRemainingProperty(): float
    {
        return (float) $this->payment->loan->remaining;
    }

    public function render()
    {
        return view('livewire.payment.detail');
    }
}
