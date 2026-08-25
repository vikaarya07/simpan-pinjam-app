<?php

namespace App\Livewire\Payment;

use App\Livewire\Concerns\WithSorting;
use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Payment;
use App\Services\SavingService;
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

    public function confirmResetPayment(int $paymentId): void
    {
        $payment = Payment::findOrFail($paymentId);

        $this->dispatch(
            'confirm-delete',
            action: 'reset-payment',
            id: $payment->id,
            text: 'Pembayaran ini akan dihapus dan dapat diisi kembali.'
        );
    }

    #[On('reset-payment')]
    public function resetPayment(int $id): void
    {
        $payment = Payment::findOrFail($id);

        $date = $payment->payment_date->format('Y-m-d');

        $payment->delete();

        // Sinkronkan Saving
        app(SavingService::class)
            ->syncInstallmentByDate($date);

        $this->dispatch('payment-saved');

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Pembayaran berhasil direset dan dapat diisi ulang.'
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
