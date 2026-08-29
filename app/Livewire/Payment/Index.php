<?php

namespace App\Livewire\Payment;

use App\Enums\PaymentStatus;
use App\Models\Meeting;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('payment-saved')]
    public function refreshPayments()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.payment.index', [
            'paymentStatus' => PaymentStatus::class,
            'meetings' => Meeting::search($this->search)
                ->orderByDesc('meeting_date')
                ->orderByDesc('created_at')
                ->paginate(10),
        ]);
    }
}
