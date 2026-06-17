<?php

namespace App\Livewire\Loan;

use App\Livewire\Concerns\WithSorting;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;

    protected string $paginationTheme = 'tailwind';

    public bool $showFormModal = false;
    public bool $isEdit = false;

    public ?Loan $loan = null;
    public string $search = '';
    public ?int $member_id = null;
    public string $loan_number = '';
    public string $loan_date = '';
    public string $type = '';
    public float $principal = 0;
    public float $interest_percent = 10;
    public float $interest_amount = 0;
    public float $amount = 0;
    public float $remaining = 0;
    public string $status = 'Running';

    protected function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'loan_number' => ['required'],
            'loan_date' => ['required', 'date'],
            'type' => ['required'],
            'principal' => ['required', 'numeric', 'min:1'],
            'interest_percent' => ['required', 'numeric'],
            'status' => ['required', Rule::in(['Running', 'Finish'])],
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();

        $this->loan_date = now()->format('Y-m-d');

        $this->interest_percent = 0;

        $last = Loan::max('id') + 1;

        $this->loan_number = 'LN-' . now()->format('Ymd') . '-' . str_pad($last, 5, '0', STR_PAD_LEFT);

        $this->showFormModal = true;
    }

    public function edit(Loan $loan)
    {
        $this->loan = $loan;
        $this->isEdit = true;

        $this->member_id = $loan->member_id;
        $this->loan_number = $loan->loan_number;
        $this->loan_date = $loan->loan_date->format('Y-m-d');
        $this->type = $loan->type;
        $this->principal = $loan->principal;
        $this->interest_percent = $loan->interest_percent;
        $this->interest_amount = $loan->interest_amount;
        $this->amount = $loan->amount;
        $this->remaining = $loan->remaining;
        $this->status = $loan->status;
        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'member_id' => $this->member_id,
            'loan_number' => $this->loan_number,
            'slug' => Str::slug($this->loan_number),
            'loan_date' => $this->loan_date,
            'type' => $this->type,
            'principal' => $this->principal,
            'status' => $this->status,
        ];

        if ($this->isEdit) {

            $this->loan->update($data);
        } else {

            Loan::create($data);

            // Nanti kita tambahkan transaksi kas koperasi (Savings)
            // agar otomatis mengurangi saldo kas.
        }

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: $this->isEdit
                ? 'Pinjaman berhasil diperbarui.'
                : 'Pinjaman berhasil ditambahkan.'
        );

        $this->closeModal();
    }

    public function onTypeChange()
    {
        $this->interest_percent = $this->type === 'loan_overdue' ? 10 : 5;
    }

    public function updated($property)
    {
        if (in_array($property, ['type', 'principal'])) {

            $percent = match ($this->type) {
                'loan_overdue' => 10,
                default => 5,
            };

            $this->interest_percent = $percent;

            $this->interest_amount = ($this->principal * $percent) / 100;
            $this->amount = $this->principal + $this->interest_amount;
            $this->remaining = $this->amount;
        }
    }

    public function confirmDelete(Loan $loan)
    {
        $this->loan = $loan;

        $this->dispatch(
            'confirm-delete',
            id: $loan->id,
            number: $loan->loan_number
        );
    }

    #[On('delete-loan')]
    public function delete($id)
    {
        Loan::findOrFail($id)->delete();

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Pinjaman berhasil dihapus.'
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
            'loan',
            'member_id',
            'loan_number',
            'loan_date',
            'type',
            'principal',
            'interest_percent',
            'interest_amount',
            'amount',
            'remaining',
        ]);

        $this->status = 'Running';

        $this->isEdit = false;

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.loan.index', [
            'members' => Member::orderBy('name')->get(),

            'loans' => Loan::search($this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
