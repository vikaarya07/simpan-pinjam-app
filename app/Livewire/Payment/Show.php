<?php

namespace App\Livewire\Payment;

use App\Livewire\Concerns\WithSorting;
use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Payment;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    use WithSorting;

    public Meeting $meeting;

    public string $search = '';

    public function mount(Meeting $meeting): void
    {
        $this->meeting = $meeting;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(int $loanId): void
    {
        $this->dispatch(
            'open-payment-form-create',
            loanId: $loanId,
            meetingId: $this->meeting->id,
        );
    }

    public function edit(int $paymentId): void
    {
        $this->dispatch(
            'open-payment-form-edit',
            id: $paymentId,
        );
    }

    public function confirmDelete(int $paymentId): void
    {
        $payment = Payment::findOrFail($paymentId);

        $this->dispatch(
            'confirm-delete',
            action: 'delete-payment',
            id: $paymentId,
            text: "{$payment->loan->loan_number} - {$payment->loan->member->name}",
        );
    }

    #[On('delete-payment')]
    public function delete(int $paymentId): void
    {
        Payment::findOrFail($paymentId)->delete();

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Pembayaran berhasil dihapus.',
        );
    }

    #[On('payment-saved')]
    public function refreshPayments()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.payment.show', [
            'loans' => Loan::query()
                ->search($this->search)
                ->forMeeting($this->meeting)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
