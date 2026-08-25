<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\Saving;

class SavingService
{
    // MANUAL
    public function recordOpening(
        string $date,
        float $amount,
        ?string $description = null
    ): Saving {
        return $this->recordManual(
            date: $date,
            type: 'Opening',
            amount: $amount,
            description: $description,
        );
    }

    public function recordAssistance(
        string $date,
        float $amount,
        ?string $description = null
    ): Saving {
        return $this->recordManual(
            date: $date,
            type: 'Assistance',
            amount: $amount,
            description: $description,
        );
    }

    public function recordManual(
        string $date,
        string $type,
        float $amount,
        ?string $description = null,
    ): Saving {
        if (! in_array($type, [
            'Opening',
            'Assistance',
        ])) {
            throw new \InvalidArgumentException(
                'Jenis transaksi manual hanya Opening atau Assistance.'
            );
        }

        $saving = Saving::query()
            ->whereDate('transaction_date', $date)
            ->where('type', $type)
            ->first();

        if ($saving) {
            $saving->increment('debit', $amount);

            if ($description !== null) {
                $saving->update([
                    'description' => $description,
                ]);
            }
        } else {
            $saving = Saving::create([
                'transaction_date' => $date,
                'type' => $type,

                'debit' => $amount,
                'credit' => 0,

                'balance' => 0,
                'receivable' => 0,
                'amount' => 0,

                'interest_percent' => 0,
                'interest_amount' => 0,

                'description' => $description,
            ]);
        }

        $this->rebuild();

        return $saving->fresh();
    }

    // UPDATE MANUAL
    public function updateManual(
        Saving $saving,
        string $date,
        string $type,
        float $amount,
        ?string $description = null,
    ): Saving {
        if (! in_array($saving->type, [
            'Opening',
            'Assistance',
        ])) {
            throw new \InvalidArgumentException(
                'Hanya Opening dan Assistance yang dapat diedit.'
            );
        }

        if (! in_array($type, [
            'Opening',
            'Assistance',
        ])) {
            throw new \InvalidArgumentException(
                'Jenis transaksi manual hanya Opening atau Assistance.'
            );
        }

        $saving->update([
            'transaction_date' => $date,
            'type' => $type,

            'debit' => $amount,
            'credit' => 0,

            'interest_percent' => 0,
            'interest_amount' => 0,

            'description' => $description,
        ]);

        $this->rebuild();

        return $saving->fresh();
    }

    // AUTOMATIC - LOAN
    public function recordLoan(Loan $loan): void
    {
        $date = $loan->loan_date->format('Y-m-d');

        $type = $loan->type === 'loan_overdue'
            ? 'Loan Overdue'
            : 'Loan';

        $this->syncAutomaticLoan(
            date: $date,
            type: $type,
        );

        $this->rebuild();
    }

    public function syncAutomaticLoanByDate(
        string $date,
        string $type
    ): void {
        $this->syncAutomaticLoan($date, $type);
        $this->rebuild();
    }

    private  function syncAutomaticLoan(
        string $date,
        string $type,
    ): void {
        $loanType = $type === 'Loan'
            ? 'loan'
            : 'loan_overdue';

        $loans = Loan::query()
            ->whereDate('loan_date', $date)
            ->where('type', $loanType)
            ->get();

        $saving = Saving::query()
            ->whereDate('transaction_date', $date)
            ->where('type', $type)
            ->first();

        /*
    |--------------------------------------------------------------------------
    | Tidak ada Loan
    |--------------------------------------------------------------------------
    */

        if ($loans->isEmpty()) {
            if ($saving) {
                $saving->delete();
            }

            return;
        }

        /*
    |--------------------------------------------------------------------------
    | Hitung ulang dari Loan
    |--------------------------------------------------------------------------
    */

        $credit = (float) $loans->sum('principal');

        $interestAmount = (float) $loans->sum(
            fn(Loan $loan) => (float) $loan->interest_amount
        );

        $interestPercents = $loans
            ->pluck('interest_percent')
            ->filter(fn($value) => $value !== null)
            ->map(fn($value) => (float) $value)
            ->unique()
            ->values();

        $interestPercent = $interestPercents->count() === 1
            ? $interestPercents->first()
            : 0;

        /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

        if ($saving) {
            $saving->update([
                'credit' => $credit,
                'interest_percent' => $interestPercent,
                'interest_amount' => $interestAmount,
            ]);

            return;
        }

        /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

        Saving::create([
            'transaction_date' => $date,
            'type' => $type,
            'debit' => 0,
            'credit' => $credit,
            'balance' => 0,
            'receivable' => 0,
            'amount' => 0,
            'interest_percent' => $interestPercent,
            'interest_amount' => $interestAmount,
            'description' => null,
        ]);
    }

    // REMOVE LOAN
    public function removeLoan(Loan $loan): void
    {
        $date = $loan->loan_date->format('Y-m-d');

        $type = $loan->type === 'loan_overdue'
            ? 'Loan Overdue'
            : 'Loan';

        // Sinkronkan Installment
        // Payment dari Loan ini mungkin sudah menghasilkan Saving Installment.
        // Setelah Loan/Payment dihapus, Installment pada tanggal tersebut
        // harus dihitung ulang.
        $this->syncInstallmentByDate($date);

        // Cek Loan sejenis yang masih tersisa
        $remainingLoans = Loan::query()
            ->whereDate('loan_date', $date)
            ->where('type', $loan->type)
            ->whereKeyNot($loan->id)
            ->exists();

        // Tidak ada Loan lagi
        if (! $remainingLoans) {

            Saving::query()
                ->whereDate('transaction_date', $date)
                ->where('type', $type)
                ->delete();
        }

        //   Masih ada Loan
        else {

            $this->syncAutomaticLoan(
                date: $date,
                type: $type,
            );
        }

        $this->rebuild();
    }

    // INSTALLMENT - CREATE
    public function recordInstallment(Payment $payment): ?Saving
    {
        $date = $payment->payment_date->format('Y-m-d');

        $this->syncInstallmentByDate($date);

        return Saving::query()
            ->whereDate('transaction_date', $date)
            ->where('type', 'Installment')
            ->first();
    }

    // INSTALLMENT - UPDATE
    public function updateInstallment(
        Payment $oldPayment,
        Payment $payment
    ): void {
        $oldDate = $oldPayment->payment_date->format('Y-m-d');
        $newDate = $payment->payment_date->format('Y-m-d');

        // Jika tanggal berubah
        if ($oldDate !== $newDate) {
            $this->syncInstallmentByDate($oldDate);
        }

        // Sinkronisasi tanggal baru
        $this->syncInstallmentByDate($newDate);

        $this->rebuild();
    }

    // INSTALLMENT - RESET
    // Dipanggil SEBELUM payment kehilangan payment_date.
    public function resetInstallment(string $date): void
    {
        $this->syncInstallmentByDate($date);

        $this->rebuild();
    }

    // SYNC INSTALLMENT BY DATE
    // Semua Payment pada tanggal yang sama dijumlahkan.
    // Payment amount = 0 tidak dihitung.
    public function syncInstallmentByDate(string $date): void
    {
        $debit = Payment::query()
            ->whereDate('payment_date', $date)
            ->where('amount', '>', 0)
            ->sum('amount');

        $saving = Saving::query()
            ->whereDate('transaction_date', $date)
            ->where('type', 'Installment')
            ->first();

        if ($debit <= 0) {
            if ($saving) {
                $saving->delete();
            }

            $this->rebuild();

            return;
        }

        if ($saving) {
            $saving->update([
                'debit' => $debit,
            ]);
        } else {
            Saving::create([
                'transaction_date' => $date,
                'type' => 'Installment',
                'debit' => $debit,
                'credit' => 0,
                'balance' => 0,
                'receivable' => 0,
                'amount' => 0,
                'interest_percent' => 0,
                'interest_amount' => 0,
                'description' => null,
            ]);
        }

        $this->rebuild();
    }

    // REBUILD
    // Menghitung ulang:
    // balance
    // receivable
    // amount
    public function rebuild(): void
    {
        $balance = 0;
        $receivable = 0;

        $savings = Saving::query()
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        foreach ($savings as $saving) {

            switch ($saving->type) {

                // OPENING
                case 'Opening':

                    $balance += (float) $saving->debit;

                    break;

                // ASSISTANCE
                case 'Assistance':

                    $balance += (float) $saving->debit;

                    break;

                // LOAN
                case 'Loan':

                    $balance -= (float) $saving->credit;

                    $receivable +=
                        (float) $saving->credit
                        + (float) $saving->interest_amount;

                    break;

                // LOAN OVERDUE
                case 'Loan Overdue':

                    $receivable += (float) $saving->interest_amount;

                    break;

                // INSTALLMENT
                case 'Installment':

                    $balance += (float) $saving->debit;
                    $receivable -= (float) $saving->debit;

                    break;
            }

            // PIUTANG TIDAK BOLEH NEGATIF
            $receivable = max(0, $receivable);

            // TOTAL
            // Amount = Balance + Receivable
            $amount = $balance + $receivable;

            $saving->updateQuietly([
                'balance' => $balance,
                'receivable' => $receivable,
                'amount' => $amount,
            ]);
        }
    }
}
