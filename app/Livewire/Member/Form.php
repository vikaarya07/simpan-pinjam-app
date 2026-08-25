<?php

namespace App\Livewire\Member;

use App\Models\Member;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showFormModal = false;

    public ?Member $member = null;

    public bool $isEdit = false;

    public string $npk = '';
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $gender = '';
    public string $date_birth = '';
    public string $date_join = '';
    public string $status = 'Active';

    protected function rules(): array
    {
        return [
            'npk' => [
                'required',
                Rule::unique('members', 'npk')->ignore($this->member?->id),
            ],
            'name' => ['required', 'min:3',],
            'email' => [
                'required',
                'email',
                Rule::unique('members', 'email')->ignore($this->member?->id),
            ],
            'phone' => ['required', 'string', 'max:20',],
            'gender' => [
                'required',
                Rule::in(Member::GENDERS),
            ],
            'date_birth' => ['required', 'date',],
            'date_join' => ['required', 'date',],
            'status' => [
                'required',
                Rule::in(['Active', 'Inactive']),
            ],
        ];
    }

    #[On('open-member-form-create')]
    public function create(): void
    {
        $this->resetForm();
        $this->npk = Member::generateNpk();
        $this->showFormModal = true;
    }

    #[On('open-member-form-edit')]
    public function edit(int $id): void
    {
        $member = Member::findOrFail($id);

        $this->member = $member;
        $this->isEdit = true;

        $this->npk = $member->npk;
        $this->name = $member->name;
        $this->email = $member->email;
        $this->phone = $member->phone;
        $this->gender = $member->gender;
        $this->date_birth = $member->date_birth;
        $this->date_join = $member->date_join;
        $this->status = $member->status;

        $this->resetValidation();

        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate();
        $data = [
            'npk' => $this->npk,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'date_birth' => $this->date_birth,
            'date_join' => $this->date_join,
            'status' => $this->status,
        ];

        if ($this->isEdit) {

            $this->member->update($data);
        } else {

            Member::create($data);
        }

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: $this->isEdit
                ? 'Member berhasil diperbarui.'
                : 'Member berhasil ditambahkan.',
        );

        $this->dispatch('member-saved');

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
            'member',
            'npk',
            'name',
            'email',
            'phone',
            'gender',
            'date_birth',
            'date_join',
            'status',
        ]);

        $this->date_join = now()->format('Y-m-d');

        $this->status = 'Active';

        $this->isEdit = false;

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.member.form');
    }
}
