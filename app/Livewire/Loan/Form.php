<?php

namespace App\Livewire\Loan;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
use App\Services\SavingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showFormModal = false;
    public bool $isEdit = false;

    public ?Loan $loan = null;
    public ?Loan $previousLoan = null;

    public ?int $member_id = null;

    public string $loan_number = '';
    public string $loan_date = '';
    public string $type = 'loan';

    public float $principal = 0;
    public string $principalFormatted = '';
    public float $interest_percent = 5;
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
            'type' => ['required', Rule::in(['loan', 'loan_overdue'])],
            'principal' => ['required', 'numeric', 'min:1'],
        ];

        // Loan overdue tidak boleh melebihi sisa pinjaman sebelumnya
        if ($this->type === 'loan_overdue' && $this->previousLoan) {
            $rules['principal'][] = 'max:' . $this->previousLoan->remaining;
        }

        return $rules;
    }

    #[On('open-loan-form-create')]
    public function create(): void
    {
        $this->resetForm();

        $this->loan_date = now()->format('Y-m-d');
        $this->type = 'loan';
        $this->interest_percent = 5;

        $lastId = Loan::max('id') + 1;

        $this->loan_number = 'LN-'
            . now()->format('Ymd')
            . '-'
            . str_pad($lastId, 5, '0', STR_PAD_LEFT);

        $this->showFormModal = true;
    }

    #[On('open-loan-form-edit')]
    public function edit(int $id): void
    {
        $loan = Loan::findOrFail($id);

        $this->loan = $loan;
        $this->isEdit = true;

        $this->member_id = $loan->member_id;
        $this->loan_number = $loan->loan_number;
        $this->loan_date = $loan->loan_date->format('Y-m-d');

        $this->type = $loan->type;

        $this->principal = (float) $loan->principal;
        $this->principalFormatted = number_format($loan->principal, 0, ',', '.');
        $this->interest_percent = (float) $loan->interest_percent;
        $this->interest_amount = (float) $loan->interest_amount;
        $this->amount = (float) $loan->amount;
        $this->remaining = (float) $loan->remaining;
        $this->disbursement = (float) $loan->disbursement;

        $this->status = $loan->status;

        $this->previousLoan = $loan->previousLoan;

        $this->showFormModal = true;
    }

    public function save(): void
    {
        // VALIDASI TOP UP
        if (
            $this->type === 'loan'
            && $this->previousLoan
            && $this->principal < $this->previousLoan->remaining
        ) {
            $this->addError(
                'principalFormatted',
                'Nominal pinjaman harus lebih besar dari sisa hutang (' .
                    idr($this->previousLoan->remaining) .
                    ').'
            );

            return;
        }

        // VALIDASI FORM
        $this->validate();

        // HITUNG LOAN
        $this->calculateLoan();

        // CEK SALDO SAVING
        // Yang dibandingkan adalah PRINCIPAL.
        // Bukan amount, karena amount sudah termasuk jasa.
        $savingBalance = (float) (
            Saving::query()
            ->latest('transaction_date')
            ->latest('id')
            ->value('balance') ?? 0
        );

        // CREATE
        if (! $this->isEdit) {

            if ($this->principal > $savingBalance) {
                $this->addError(
                    'principalFormatted',
                    'Nominal pinjaman tidak boleh melebihi saldo simpanan. '
                        . 'Saldo tersedia: ' . idr($savingBalance)
                );

                return;
            }
        }

        // EDIT
        // Saat edit, jangan menggunakan saldo sekarang secara langsung.
        // Karena Loan lama sudah mengambil saldo sebelumnya.
        if ($this->isEdit) {

            $oldPrincipal = (float) $this->loan->principal;

            // Selisih kebutuhan kas.
            // Contoh:
            // Loan lama = 3.000.000
            // Loan baru = 4.000.000
            // Tambahan = 1.000.000
            $additionalPrincipal = max(
                0,
                $this->principal - $oldPrincipal
            );

            if ($additionalPrincipal > $savingBalance) {
                $this->addError(
                    'principalFormatted',
                    'Penambahan pinjaman tidak boleh melebihi saldo simpanan. '
                        . 'Saldo tersedia: ' . idr($savingBalance)
                );

                return;
            }
        }

        // DATA LOAN
        $data = [
            'member_id' => $this->member_id,
            'loan_number' => $this->loan_number,
            'loan_date' => $this->loan_date,
            'type' => $this->type,

            'principal' => $this->principal,

            'interest_percent' => $this->interest_percent,
            'interest_amount' => $this->interest_amount,

            'amount' => $this->amount,
            'remaining' => $this->remaining,

            'disbursement' => $this->disbursement,

            'status' => $this->remaining <= 0
                ? 'finish'
                : 'running',
        ];

        // DATABASE TRANSACTION
        DB::transaction(function () use ($data) {

            // EDIT
            if ($this->isEdit) {

                // Simpan data lama sebelum update
                $oldLoanDate = $this->loan->loan_date->format('Y-m-d');
                $oldLoanType = $this->loan->type;

                $totalPaid = $this->loan
                    ->payments()
                    ->sum('amount');

                $data['remaining'] = max(
                    0,
                    $this->amount - $totalPaid
                );

                $data['status'] = $data['remaining'] <= 0
                    ? 'finish'
                    : 'running';

                // Update Loan
                $this->loan->update($data);

                $loan = $this->loan->fresh();

                // Sinkronkan tanggal lama
                $oldSavingType = $oldLoanType === 'loan_overdue'
                    ? 'Loan Overdue'
                    : 'Loan';

                app(SavingService::class)->syncAutomaticLoanByDate(
                    date: $oldLoanDate,
                    type: $oldSavingType,
                );

                // Sinkronkan tanggal baru
                $newSavingType = $loan->type === 'loan_overdue'
                    ? 'Loan Overdue'
                    : 'Loan';

                app(SavingService::class)->syncAutomaticLoanByDate(
                    date: $loan->loan_date->format('Y-m-d'),
                    type: $newSavingType,
                );

                app(SavingService::class)->rebuild();

                return;
            }

            // CREATE
            if ($this->previousLoan) {

                $data['previous_loan_id'] =
                    $this->previousLoan->id;

                // Untuk TOP UP loan biasa,
                // Loan lama dianggap selesai.
                if ($this->type === 'loan') {

                    $this->previousLoan->update([
                        'remaining' => 0,
                        'status' => 'finish',
                    ]);
                }
            }

            // CREATE LOAN
            $loan = Loan::create($data);

            // RECORD SAVING
            // Jasa diambil dari Loan yang benar-benar tersimpan.
            app(SavingService::class)
                ->recordLoan($loan);
        });

        // SUCCESS
        $this->dispatch('loan-saved');

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

    protected function calculateLoan(): void
    {
        if ($this->principal <= 0) {
            $this->interest_percent = 0;
            $this->interest_amount = 0;
            $this->amount = 0;
            $this->remaining = 0;
            $this->disbursement = 0;

            return;
        }

        // Loan selalu memiliki jasa
        $this->interest_percent = match ($this->type) {
            'loan' => 5,
            'loan_overdue' => 10,
            default => 0,
        };

        // Jasa
        $this->interest_amount =
            $this->principal * $this->interest_percent / 100;

        // Pokok + jasa
        $this->amount =
            $this->principal + $this->interest_amount;

        if (! $this->isEdit) {
            $this->remaining = $this->amount;

            if (
                $this->type === 'loan'
                && $this->previousLoan
            ) {
                // Uang yang benar-benar dicairkan
                $this->disbursement = max(
                    0,
                    $this->principal - $this->previousLoan->remaining
                );
            } else {
                // Loan pertama
                $this->disbursement = $this->principal;
            }
        }
    }

    public function updatedPrincipal(): void
    {
        $this->calculateLoan();
    }

    public function updatedType(): void
    {
        $this->calculateLoan();
    }

    public function updatedMemberId(): void
    {
        $this->previousLoan = Loan::query()
            ->where('member_id', $this->member_id)
            ->where('status', 'running')
            ->latest()
            ->first();

        $this->calculateLoan();
    }

    public function closeModal(): void
    {
        $this->showFormModal = false;

        $this->resetForm();
    }

    public function updatedPrincipalFormatted($value): void
    {
        $number = preg_replace('/[^0-9]/', '', $value);

        $this->principal = (float) $number;

        $this->principalFormatted = idr($this->principal, false);

        $this->calculateLoan();
    }

    public function resetForm(): void
    {
        $this->reset([
            'loan',
            'previousLoan',
            'member_id',
            'loan_number',
            'loan_date',
        ]);

        $this->type = 'loan';

        $this->principal = 0;
        $this->principalFormatted = '0';
        $this->interest_percent = 5;
        $this->interest_amount = 0;
        $this->amount = 0;
        $this->remaining = 0;
        $this->disbursement = 0;

        $this->status = 'running';

        $this->isEdit = false;

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.loan.form', [
            'members' => Member::active()
                ->orderBy('name')
                ->get(),
        ]);
    }
}
