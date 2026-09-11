<?php

namespace App\Livewire\Loan;

use App\Enums\LoanStatus;
use App\Enums\LoanType;
use App\Enums\SavingType;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
use App\Services\CustomerNotificationService;
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

    public int|string $member_id = '';

    public string $loan_number = '';

    public string $loan_date = '';

    public string $type = LoanType::Loan->value;

    public float $principal = 0;

    public string $principalFormatted = '';

    public float $interest_percent = 5;

    public float $interest_amount = 0;

    public float $amount = 0;

    public float $remaining = 0;

    public float $disbursement = 0;

    public string $status = LoanStatus::Running->value;

    protected function rules(): array
    {
        $rules = [
            'member_id' => [
                'required',
                'exists:members,id',
            ],

            'loan_number' => [
                'required',
            ],

            'loan_date' => [
                'required',
                'date',
            ],

            'type' => [
                'required',
                Rule::enum(LoanType::class),
            ],

            'principal' => [
                'required',
                'integer',
                'min:10000',
            ],
        ];

        /*
         * Loan Overdue tidak boleh melebihi
         * sisa pinjaman sebelumnya.
         */
        if (
            $this->type === LoanType::LoanOverdue->value
            && $this->previousLoan
        ) {
            $rules['principal'][] = 'max:' . $this->previousLoan->remaining;
        }

        return $rules;
    }

    #[On('open-loan-form-create')]
    public function create(): void
    {
        $this->resetForm();

        $this->loan_date = now()->format('Y-m-d');

        $this->type = LoanType::Loan->value;

        $this->interest_percent = 5;

        $this->loan_number = Loan::generateLoanNumber(
            $this->loan_date
        );

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

        $this->type = $loan->type->value;

        $this->principal = (float) $loan->principal;

        $this->principalFormatted = number_format(
            $loan->principal,
            0,
            ',',
            '.'
        );

        $this->interest_percent = (float) $loan->interest_percent;

        $this->interest_amount = (float) $loan->interest_amount;

        $this->amount = (float) $loan->amount;

        $this->remaining = (float) $loan->remaining;

        $this->disbursement = (float) $loan->disbursement;

        $this->status = $loan->status->value;

        $this->previousLoan = $loan->previousLoan;

        $this->showFormModal = true;
    }

    public function save(): void
    {
        /*
         * VALIDASI TOP UP
         *
         * Loan baru harus lebih besar dari
         * sisa pinjaman sebelumnya.
         */
        if (
            $this->type === LoanType::Loan->value
            && $this->previousLoan
            && $this->principal < $this->previousLoan->remaining
        ) {
            $this->addError(
                'principalFormatted',
                'Nominal pinjaman harus lebih besar dari sisa hutang ('
                    . idr($this->previousLoan->remaining)
                    . ').'
            );

            return;
        }

        $this->validate();

        $this->calculateLoan();

        /*
         * CEK SALDO SAVING
         *
         * Yang dibandingkan adalah PRINCIPAL,
         * bukan amount karena amount sudah termasuk jasa.
         */
        $savingBalance = (float) (
            Saving::query()
            ->latest('transaction_date')
            ->latest('id')
            ->value('balance') ?? 0
        );

        /*
         * CREATE
         */
        if (! $this->isEdit) {
            if ($this->principal > $savingBalance) {
                $this->addError(
                    'principalFormatted',
                    'Nominal pinjaman tidak boleh melebihi saldo simpanan. '
                        . 'Saldo tersedia: '
                        . idr($savingBalance)
                );

                return;
            }
        }

        /*
         * EDIT
         *
         * Hanya tambahan principal yang membutuhkan
         * saldo baru.
         */
        if ($this->isEdit) {
            $oldPrincipal = (float) $this->loan->principal;

            $additionalPrincipal = max(
                0,
                $this->principal - $oldPrincipal
            );

            if ($additionalPrincipal > $savingBalance) {
                $this->addError(
                    'principalFormatted',
                    'Penambahan pinjaman tidak boleh melebihi '
                        . 'saldo simpanan. Saldo tersedia: '
                        . idr($savingBalance)
                );

                return;
            }
        }

        /*
         * DATA LOAN
         */
        $data = [
            'member_id' => $this->member_id,

            'loan_number' => $this->loan_number,

            'loan_date' => $this->loan_date,

            'type' => LoanType::from($this->type),

            'principal' => $this->principal,

            'interest_percent' => $this->interest_percent,

            'interest_amount' => $this->interest_amount,

            'amount' => $this->amount,

            'remaining' => $this->remaining,

            'disbursement' => $this->disbursement,

            'status' => $this->remaining <= 0
                ? LoanStatus::Finish
                : LoanStatus::Running,
        ];

        /*
         * DATABASE TRANSACTION
         */
        $loan = DB::transaction(function () use ($data) {

            /*
             * EDIT
             */
            if ($this->isEdit) {

                $oldLoanDate =
                    $this->loan->loan_date->format('Y-m-d');

                $oldLoanType =
                    $this->loan->type;

                /*
                 * Total pembayaran tetap dipertahankan.
                 */
                $totalPaid = (float) $this->loan
                    ->payments()
                    ->sum('amount');

                /*
                 * Hitung remaining berdasarkan
                 * amount baru.
                 */
                $remaining = max(
                    0,
                    $this->amount - $totalPaid
                );

                $data['remaining'] = $remaining;

                $data['status'] = $remaining <= 0
                    ? LoanStatus::Finish
                    : LoanStatus::Running;

                /*
                 * Update Loan
                 */
                $this->loan->update($data);

                $loan = $this->loan->fresh();

                /*
                 * Sinkronisasi Saving lama.
                 */
                app(SavingService::class)
                    ->syncAutomaticLoanByDate(
                        date: $oldLoanDate,
                        type: $oldLoanType === LoanType::LoanOverdue
                            ? SavingType::LoanOverdue
                            : SavingType::Loan,
                    );

                /*
                 * Sinkronisasi Saving baru.
                 *
                 * Kalau tanggal/type tidak berubah,
                 * method sync cukup dipanggil sekali.
                 */
                app(SavingService::class)
                    ->syncAutomaticLoanByDate(
                        date: $loan->loan_date->format('Y-m-d'),
                        type: $loan->type === LoanType::LoanOverdue
                            ? SavingType::LoanOverdue
                            : SavingType::Loan,
                    );

                /*
                 * Bangun ulang seluruh saldo.
                 */
                app(SavingService::class)->rebuild();

                return $loan;
            }

            /*
             * CREATE
             */
            if ($this->previousLoan) {
                $data['previous_loan_id'] =
                    $this->previousLoan->id;

                /*
                 * Untuk TOP UP Loan biasa,
                 * loan sebelumnya dianggap selesai.
                 */
                if ($this->type === LoanType::Loan->value) {
                    $this->previousLoan->update([
                        'remaining' => 0,
                        'status' => LoanStatus::Finish,
                    ]);
                }
            }

            /*
             * CREATE LOAN
             */
            $loan = Loan::create($data);

            /*
             * RECORD SAVING
             */
            app(SavingService::class)
                ->recordLoan($loan);

            return $loan->fresh();
        });

        /*
         * NOTIFICATION
         */
        if (! $this->isEdit) {
            $message = app(CustomerNotificationService::class)
                ->loanCreated($loan);

            $this->dispatch(
                'loan-notification-created',
                message: $message,
            );
        }

        /*
         * SUCCESS
         */
        $this->dispatch('loan-saved');

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: $this->isEdit
                ? 'Pinjaman berhasil diperbarui.'
                : 'Pinjaman berhasil ditambahkan.',
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

        /*
         * Tentukan jasa berdasarkan enum LoanType.
         */
        $loanType = LoanType::from($this->type);

        $this->interest_percent = match ($loanType) {
            LoanType::Loan => 5,
            LoanType::LoanOverdue => 10,
        };

        /*
         * Jasa
         */
        $this->interest_amount =
            $this->principal
            * $this->interest_percent
            / 100;

        /*
         * Pokok + jasa
         */
        $this->amount =
            $this->principal
            + $this->interest_amount;

        if (! $this->isEdit) {

            $this->remaining = $this->amount;

            /*
             * TOP UP
             */
            if (
                $loanType === LoanType::Loan
                && $this->previousLoan
            ) {
                /*
                 * Uang yang benar-benar dicairkan.
                 */
                $this->disbursement = max(
                    0,
                    $this->principal
                        - $this->previousLoan->remaining
                );
            } else {
                /*
                 * Loan pertama / Loan Overdue.
                 */
                $this->disbursement = $this->principal;
            }
        }
    }

    public function updatedLoanDate($value): void
    {
        if (blank($value)) {
            $this->loan_number = '';

            return;
        }

        // Hanya generate ulang untuk form CREATE.
        // Saat EDIT, nomor pinjaman tidak berubah.
        if (! $this->isEdit) {
            $this->loan_number = Loan::generateLoanNumber($value);
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
            ->where('status', LoanStatus::Running)
            ->latest()
            ->first();

        $this->calculateLoan();
    }

    public function updatedPrincipalFormatted($value): void
    {
        $number = preg_replace(
            '/[^0-9]/',
            '',
            $value
        );

        $this->principal = (float) $number;

        $this->principalFormatted = idr(
            $this->principal,
            false
        );

        $this->calculateLoan();
    }

    public function closeModal(): void
    {
        $this->showFormModal = false;

        $this->resetForm();
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

        $this->type = LoanType::Loan->value;

        $this->principal = 0;

        $this->principalFormatted = '0';

        $this->interest_percent = 5;

        $this->interest_amount = 0;

        $this->amount = 0;

        $this->remaining = 0;

        $this->disbursement = 0;

        $this->status = LoanStatus::Running->value;

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
