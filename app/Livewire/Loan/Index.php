<?php

namespace App\Livewire\Loan;

use App\Livewire\Concerns\WithSorting;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
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

    public ?Loan $previousLoan = null;
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
    public float $disbursement = 0;
    public string $status = 'running';

    protected function rules(): array
    {
        $rules = [
            'member_id' => ['required', 'exists:members,id'],
            'loan_number' => ['required'],
            'loan_date' => ['required', 'date'],
            'type' => ['required'],
            'principal' => ['required', 'numeric', 'min:1'],
            'interest_percent' => ['required', 'numeric'],
            'status' => ['required', Rule::in(['running', 'finish'])],
        ];

        if (
            $this->type === 'loan_overdue' &&
            $this->previousLoan
        ) {
            $rules['principal'][] = 'max:' . $this->previousLoan->remaining;
        }

        return $rules;
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
        $this->calculateLoan();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'member_id'        => $this->member_id,
            'loan_number'      => $this->loan_number,
            'slug'             => Str::slug($this->loan_number),
            'loan_date'        => $this->loan_date,
            'type'             => $this->type,
            'principal'        => $this->principal,
            'interest_percent' => $this->interest_percent,
            'interest_amount'  => $this->interest_amount,
            'amount'           => $this->amount,
            'disbursement'     => $this->disbursement,
            'status'           => $this->status,
        ];

        if ($this->isEdit) {

            $paid = $this->loan->amount - $this->loan->remaining;

            $data['remaining'] = max(0, $this->amount - $paid);

            $this->loan->update($data);
        }

        if ($this->previousLoan) {

            if (
                $this->type === 'loan' &&
                $this->principal <= $this->previousLoan->remaining
            ) {
                $this->addError(
                    'principal',
                    'Pinjaman baru harus lebih besar dari sisa hutang sebelumnya.'
                );

                return;
            }

            if (
                $this->type === 'loan_overdue' &&
                $this->principal > $this->previousLoan->remaining
            ) {
                $this->addError(
                    'principal',
                    'Pinjaman telat tidak boleh melebihi sisa hutang sebelumnya.'
                );

                return;
            }
        }

        DB::transaction(function () use ($data) {

            if ($this->previousLoan) {

                $this->previousLoan->update([
                    'remaining' => 0,
                    'status'    => 'finish',
                ]);

                $data['previous_loan_number'] = $this->previousLoan->number;
            }

            Loan::create($data);
        });

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

    protected function calculateLoan()
    {
        $principal = (float) ($this->principal ?? 0);

        if ($principal <= 0 || !$this->type) {
            $this->interest_amount = 0;
            $this->amount = 0;
            return;
        }

        $this->interest_percent = Loan::getInterestPercent($this->type);

        $this->interest_amount =
            ($this->principal * $this->interest_percent) / 100;

        $this->amount = $this->principal + $this->interest_amount;

        $remaining = $this->previousLoan?->remaining ?? 0;

        $this->disbursement = max(
            0,
            $this->principal - $remaining
        );

        if (!$this->isEdit) {
            $this->remaining = $this->amount;
        }
    }

    public function updatedPrincipal($value)
    {
        $this->principal = is_numeric($value) ? (float) $value : 0;

        $this->calculateLoan();
    }

    public function updatedType()
    {
        $this->calculateLoan();
    }

    public function updatedMemberId()
    {
        $query = Loan::where('member_id', $this->member_id)
            ->where('status', 'running');

        if ($this->isEdit) {
            $query->whereKeyNot($this->loan->id);
        }

        $this->previousLoan = $query->latest()->first();

        $this->calculateLoan();
    }

    public function confirmDelete(string $slug): void
    {
        $loan = Loan::where('slug', $slug)->firstOrFail();

        $this->dispatch(
            'confirm-delete',
            action: 'delete-loan',
            slug: $loan->slug,
            text: "{$loan->loan_number} - {$loan->member->name}",
        );
    }

    #[On('delete-loan')]
    public function delete(string $slug)
    {
        Loan::where('slug', $slug)->delete();

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Pinjaman berhasil dihapus.',
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
            'type'
        ]);

        // reset manual numeric fields (lebih aman di Livewire)
        $this->principal = 0;
        $this->interest_percent = 5;
        $this->interest_amount = 0;
        $this->amount = 0;
        $this->remaining = 0;

        $this->previousLoan = null;
        $this->disbursement = 0;

        $this->status = 'running';
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
