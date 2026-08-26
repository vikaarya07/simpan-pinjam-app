<?php

namespace App\Livewire\Customer;

use App\Livewire\Concerns\WithSorting;
use App\Models\Member;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;

    protected string $paginationTheme = 'tailwind';

    public string $search = '';

    public int $perPage = 10;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $customers = Member::query()
            ->withCount([
                'loans as loans_count' => fn($query) =>
                $query->isCustomer(),
            ])
            ->whereHas('loans', function ($query) {
                $query->isCustomer();
            })
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.customer.index', [
            'customers' => $customers,
        ]);
    }
}
