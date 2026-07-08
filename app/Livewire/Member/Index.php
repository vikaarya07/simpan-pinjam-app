<?php

namespace App\Livewire\Member;

use App\Livewire\Concerns\WithSorting;
use App\Models\Member;
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

    public function create()
    {
        $this->dispatch('open-member-form-create');
    }

    public function edit(Int $id)
    {
        $this->dispatch('open-member-form-edit', id: $id);
    }

    public function confirmDelete(Int $id): void
    {
        $member = Member::findOrFail($id);

        $this->dispatch(
            'confirm-delete',
            action: 'delete-member',
            id: $member->id,
            text: "{$member->npk} - {$member->name}",
        );
    }

    #[On('delete-member')]
    public function delete(Int $id)
    {
        Member::findOrFail($id)->delete();

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Member berhasil dihapus.',
        );
    }

    #[On('member-saved')]
    public function refreshMembers(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.member.index', [
            'members' => Member::search($this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
