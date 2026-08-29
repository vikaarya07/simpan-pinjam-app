<?php

namespace App\Livewire\Meeting;

use App\Models\Meeting;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showFormModal = false;

    public ?Meeting $meeting = null;

    public bool $isEdit = false;

    public string $place = '';
    public string $meeting_date = '';

    protected function rules(): array
    {
        return [
            'place' => 'required',
            'meeting_date' => 'required|date',
        ];
    }

    #[On('open-meeting-form-create')]
    public function create(): void
    {
        $this->resetForm();
        $this->showFormModal = true;
    }

    #[On('open-meeting-form-edit')]
    public function edit(Int $id): void
    {
        $meeting = Meeting::findOrFail($id);

        $this->meeting = $meeting;
        $this->isEdit = true;

        $this->place = $meeting->place;
        $this->meeting_date = optional($meeting->meeting_date)->format('Y-m-d\TH:i');

        $this->resetValidation();

        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate();
        $data = [
            'place' => $this->place,
            'meeting_date' => $this->meeting_date,
        ];

        if ($this->isEdit) {

            $this->meeting->update($data);
        } else {

            meeting::create($data);
        }

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: $this->isEdit
                ? 'Meeting berhasil diperbarui.'
                : 'Meeting berhasil ditambahkan.',
        );

        $this->dispatch('meeting-saved');

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showFormModal = false;

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'place',
            'meeting_date',
        ]);

        $this->meeting_date = now()->format('Y-m-d\TH:i');

        $this->isEdit = false;

        $this->resetValidation();
    }
    
    public function render()
    {
        return view('livewire.meeting.form');
    }
}
