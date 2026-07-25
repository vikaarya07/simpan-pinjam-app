<?php

namespace App\Livewire\Payment;

use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Payment;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showFormModal = false;
    public bool $isEdit = false;

    public ?Loan $loan = null;
    public ?Meeting $meeting = null;
    public ?Payment $payment = null;

    public ?int $loan_id = null;
    public int $meeting_id = 1;

    public float $amount = 0;
    public string $amountFormatted = '';
    public string $payment_date = '';
    public ?string $method = null;
    public ?string $note = null;

    protected function rules(): array
    {
        return [
            'loan_id' => ['required', 'exists:loans,id'],
            'meeting_id' => ['required', 'exists:meetings,id'],
            'amount' => ['required', 'numeric', 'max:' . $this->loan->remaining,],
            'payment_date' => ['required', 'date'],
            'method' => [
                Rule::requiredIf($this->amount > 0),
                'nullable',
                Rule::in(['cash', 'transfer', 'qris']),
            ],
            'note' => ['nullable', 'string'],
        ];
    }

    #[On('open-payment-form-create')]
    public function create(int $loanId, int $meetingId): void
    {
        $this->resetForm();

        $this->loan = Loan::findOrFail($loanId);
        $this->meeting = Meeting::findOrFail($meetingId);

        if (! $this->loan->can_pay) {

            $this->dispatch(
                'swal',
                icon: 'error',
                title: 'Gagal',
                text: 'Pinjaman sudah lunas atau telah mencapai 6 kali pembayaran.'
            );

            return;
        }

        $this->loan_id = $this->loan->id;
        $this->meeting_id = $this->meeting->id;

        $this->payment_date = now()->toDateString();

        $this->showFormModal = true;
    }

    #[On('open-payment-form-edit')]
    public function edit(int $id): void
    {
        $payment = Payment::findOrFail($id);

        $this->payment = $payment;

        $this->loan = $payment->loan;
        $this->meeting = $payment->meeting;

        $this->isEdit = true;

        $this->loan_id = $payment->loan_id;
        $this->meeting_id = $payment->meeting_id;

        $this->amount = $payment->amount;
        $this->amountFormatted = number_format($payment->amount, 0, ',', '.');
        $this->payment_date = $payment->payment_date->format('Y-m-d');
        $this->method = $payment->method;
        $this->note = $payment->note;

        $this->showFormModal = true;
    }

    public function save(): void
    {
        if ($this->amount > $this->loan->remaining) {

            $this->addError(
                'amountFormatted',
                'Nominal pembayaran tidak boleh melebihi sisa hutang (' . idr($this->loan->remaining) . ').'
            );

            return;
        }
        
        $this->validate();

        $exists = Payment::query()
            ->where('loan_id', $this->loan_id)
            ->where('meeting_id', $this->meeting_id)
            ->when(
                $this->isEdit,
                fn($q) => $q->whereKeyNot($this->payment->id)
            )
            ->exists();

        if ($exists) {

            $this->addError(
                'meeting_id',
                'Nasabah sudah melakukan pembayaran pada pertemuan ini.'
            );

            return;
        }

        if ($this->isEdit) {

            $paymentCount = $this->payment->payment_count;
        } else {

            $paymentCount = $this->loan->next_payment_count;

            if ($paymentCount > 6) {

                $this->dispatch(
                    'swal',
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Pembayaran sudah mencapai 6 kali.'
                );

                return;
            }
        }

        $data = [
            'loan_id'       => $this->loan_id,
            'meeting_id'    => $this->meeting_id,
            'payment_count' => $paymentCount,
            'amount'        => $this->amount,
            'payment_date'  => $this->payment_date,
            'method'        => $this->amount > 0 ? $this->method : null,
            'note'          => $this->note,
        ];

        if ($this->isEdit) {
            $this->payment->update($data);
        } else {
            Payment::create($data);
        }

        $this->dispatch('payment-saved');

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: $this->isEdit
                ? 'Pembayaran berhasil diperbarui.'
                : 'Pembayaran berhasil ditambahkan.'
        );

        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->showFormModal = false;
        $this->resetForm();
    }

    public function updatedAmountFormatted($value)
    {
        $number = preg_replace('/[^0-9]/', '', $value);

        $this->amount = $number === '' ? 0 : (float) $number;

        $this->amountFormatted = number_format($this->amount, 0, ',', '.');
    }

    protected function resetForm(): void
    {
        $this->reset([
            'payment',
            'loan',
            'meeting',
            'loan_id',
            'meeting_id',
            'amount',
            'payment_date',
            'method',
            'note',
        ]);

        $this->method = null;

        $this->payment_date = now()->toDateString();

        $this->amount = 0;
        $this->amountFormatted = '0';

        $this->isEdit = false;

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.payment.form');
    }
}
