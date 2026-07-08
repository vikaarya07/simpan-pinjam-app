<?php

namespace App\Livewire\Payment;

use App\Livewire\Concerns\WithSorting;
use App\Models\Meeting;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;

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
            'meetings' => Meeting::search($this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
