<?php

namespace App\Livewire\Meeting;

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

    public function create()
    {
        $this->dispatch('open-meeting-form-create');
    }

    public function edit(Int $id)
    {
        $this->dispatch('open-meeting-form-edit', id: $id);
    }

    public function confirmDelete(Int $id): void
    {
        $meeting = Meeting::findOrFail($id);

        $this->dispatch(
            'confirm-delete',
            action: 'delete-meeting',
            id: $meeting->id,
            text: "{$meeting->place}",
        );
    }

    #[On('delete-meeting')]
    public function delete(Int $id)
    {
        meeting::findOrFail($id)->delete();

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Meeting berhasil dihapus.',
        );
    }

    #[On('meeting-saved')]
    public function refreshmeetings(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.meeting.index', [
            'meetings' => Meeting::search($this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->orderByDesc('meeting_date')
                ->paginate(10),
        ]);
    }
}
