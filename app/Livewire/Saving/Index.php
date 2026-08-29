<?php

namespace App\Livewire\Saving;

use App\Models\Saving;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->dispatch('open-saving-form-create');
    }

    public function edit(int $id): void
    {
        $this->dispatch('open-saving-form-edit', id: $id);
    }

    public function confirmDelete(int $id): void
    {
        $saving = Saving::findOrFail($id);

        $this->dispatch(
            'confirm-delete',
            action: 'delete-saving',
            id: $saving->id,
            text: $saving->type->value . ' - ' . Str::limit($saving->description, 80)
        );
    }

    #[On('delete-saving')]
    public function delete(int $id): void
    {
        Saving::findOrFail($id)->delete();

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Transaksi kas berhasil dihapus.'
        );
    }

    #[On('saving-saved')]
    public function refreshTable(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.saving.index', [
            'savings' => Saving::orderByDesc('transaction_date')
                ->orderByDesc('created_at')
                ->paginate(10),
        ]);
    }
}
