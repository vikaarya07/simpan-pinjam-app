<?php

namespace App\Enums;

enum SavingType: string
{
    case Opening = 'Opening';
    case Assistance = 'Assistance';
    case Loan = 'Loan';
    case LoanOverdue = 'Loan Overdue';
    case Installment = 'Installment';

    public function isManual(): bool
    {
        return match ($this) {
            self::Opening,
            self::Assistance => true,

            self::Loan,
            self::Installment,
            self::LoanOverdue => false,
        };
    }

    public function loanType(): LoanType
    {
        return match ($this) {
            self::Loan => LoanType::Loan,
            self::LoanOverdue => LoanType::LoanOverdue,

            default => throw new \LogicException(
                "{$this->value} bukan jenis Saving untuk Loan."
            ),
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Opening => 'Pembukaan',
            self::Assistance => 'Bantuan',
            self::Loan => 'Pinjaman',
            self::LoanOverdue => 'Pinjaman Telat',
            self::Installment => 'Angsuran',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Opening => 'slate',
            self::Assistance => 'amber',
            self::Loan => 'indigo',
            self::LoanOverdue => 'rose',
            self::Installment => 'teal',
        };
    }
}
