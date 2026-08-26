<?php

namespace App\Livewire\Saving;

use App\Models\Saving;
use App\Services\SavingService;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showFormModal = false;

    public bool $isEdit = false;

    public ?Saving $saving = null;

    public string $transaction_date = '';

    public string $type = '';

    public string $amountFormatted = '';

    public float $amount = 0;

    public string $description = '';

    #[On('open-saving-form-create')]
    public function create(): void
    {
        $this->resetForm();

        $this->transaction_date = now()->format('Y-m-d');

        $this->showFormModal = true;
    }

    #[On('open-saving-form-edit')]
    public function edit(int $id): void
    {
        $this->saving = Saving::findOrFail($id);

        // Hanya Opening dan Assistance yang boleh
        // diedit secara manual.
        abort_unless(
            in_array($this->saving->type, [
                'Opening',
                'Assistance',
            ]),
            403
        );

        $this->isEdit = true;

        $this->transaction_date =
            $this->saving->transaction_date->format('Y-m-d');

        $this->type = $this->saving->type;

        $this->amount = (float) $this->saving->debit;

        $this->amountFormatted = idr($this->amount);

        $this->description =
            $this->saving->description ?? '';

        $this->showFormModal = true;
    }

    public function updatedAmountFormatted($value): void
    {
        $number = preg_replace('/[^0-9]/', '', $value);

        $this->amount = $number === ''
            ? 0
            : (float) $number;

        $this->amountFormatted = number_format(
            $this->amount,
            0,
            ',',
            '.'
        );
    }

    public function save(): void
    {
        $validated = $this->validate([
            'transaction_date' => [
                'required',
                'date',
            ],

            'type' => [
                'required',
                'in:Opening,Assistance',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        // CREATE
        if (! $this->isEdit) {

            app(SavingService::class)->recordManual(
                date: $validated['transaction_date'],
                type: $validated['type'],
                amount: $validated['amount'],
                description: $validated['description'],
            );
        } else {

            // EDIT
            app(SavingService::class)->updateManual(
                saving: $this->saving,
                date: $validated['transaction_date'],
                type: $validated['type'],
                amount: $validated['amount'],
                description: $validated['description'],
            );
        }

        $this->close();

        $this->dispatch('saving-saved');

        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Berhasil',
            text: $this->isEdit
                ? 'Transaksi berhasil diperbarui.'
                : 'Transaksi berhasil ditambahkan.'
        );
    }

    public function close(): void
    {
        $this->showFormModal = false;

        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'saving',
            'isEdit',
            'transaction_date',
            'type',
            'amountFormatted',
            'amount',
            'description',
        ]);

        $this->isEdit = false;

        $this->amount = 0;
    }

    public function render()
    {
        return view('livewire.saving.form');
    }
}
