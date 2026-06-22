<?php

namespace App\Livewire\Member;

use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use App\Livewire\Concerns\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;

    protected string $paginationTheme = 'tailwind';

    public bool $showFormModal = false;

    public ?Member $member = null;

    public bool $isEdit = false;

    public string $search = '';

    public string $npk = '';
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public ?string $gender = null;
    public ?string $date_birth = null;
    public string $date_join = '';
    public string $status = 'Active';

    protected function rules(): array
    {
        return [
            'npk' => [
                'required',
                Rule::unique('members', 'npk')->ignore($this->member?->id),
            ],
            'name' => 'required|min:3',
            'email' => [
                'nullable',
                'email',
                Rule::unique('members', 'email')->ignore($this->member?->id),
            ],
            'phone' => 'required',
            'gender' => 'required|in:Male,Female',
            'date_birth' => 'required|date',
            'date_join' => 'required|date',
            'status' => 'required|in:Active,Inactive',

        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->npk = Member::generateNpk();
        $this->showFormModal = true;
    }

    public function edit(Member $member)
    {
        $this->member = $member;
        $this->isEdit = true;

        $this->npk = $member->npk;
        $this->name = $member->name;
        $this->email = $member->email ?? '';
        $this->phone = $member->phone ?? '';
        $this->gender = $member->gender;
        $this->date_birth = $member->date_birth?->format('Y-m-d');
        $this->date_join = $member->date_join?->format('Y-m-d');
        $this->status = $member->status;

        $this->resetValidation();

        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate();
        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug;
        $counter = 1;

        while (Member::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $data = [
            'npk' => $this->npk,
            'name' => $this->name,
            'slug' => $slug,
            'email' => $this->email ?: null,
            'phone' => $this->phone ?: null,
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

        $this->closeModal();
    }

    public function confirmDelete(string $slug): void
    {
        $member = Member::where('slug', $slug)->firstOrFail();

        $this->dispatch(
            'confirm-delete',
            action: 'delete-member',
            slug: $member->slug,
            text: "{$member->npk} - {$member->name}",
        );
    }

    #[On('delete-member')]
    public function delete(string $slug)
    {
        Member::where('slug', $slug)->delete();

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Member berhasil dihapus.',
        );
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
        ]);

        $this->date_join = now()->format('Y-m-d');

        $this->status = 'Active';

        $this->isEdit = false;

        $this->resetValidation();
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
