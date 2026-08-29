<?php

namespace App\Livewire\Loan;

use App\Livewire\Concerns\WithSorting;
use App\Models\Loan;
use App\Services\SavingService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;

    protected string $paginationTheme = 'tailwind';

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->dispatch('open-loan-form-create');
    }

    public function edit(Int $id)
    {
        $this->dispatch('open-loan-form-edit', id: $id);
    }

    public function confirmDelete(Int $id): void
    {
        $loan = Loan::findOrFail($id);

        $this->dispatch(
            'confirm-delete',
            action: 'delete-loan',
            id: $loan->id,
            text: "{$loan->loan_number} - {$loan->member->name}"
        );
    }

    #[On('delete-loan')]
    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {

            $loan = Loan::with('payments')->findOrFail($id);

            // Ambil tanggal Payment yang terdampak
            $paymentDates = $loan->payments
                ->pluck('payment_date')
                ->map(fn($date) => $date->format('Y-m-d'))
                ->unique();

            // Hapus Payment
            $loan->payments()->delete();

            // Hapus/rebuild Saving Loan
            app(SavingService::class)
                ->removeLoan($loan);

            // Sinkronkan Installment pada tanggal Payment
            foreach ($paymentDates as $date) {
                app(SavingService::class)
                    ->syncInstallmentByDate($date);
            }

            // Hapus Loan
            $loan->delete();
        });

        $this->dispatch('loan-saved');

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Pinjaman, pembayaran, dan transaksi simpanan berhasil dihapus.'
        );
    }

    #[On('loan-saved')]
    public function refreshTable(): void
    {
        // Livewire akan render ulang otomatis
    }

    public function render()
    {
        return view('livewire.loan.index', [
            'loans' => Loan::search($this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
