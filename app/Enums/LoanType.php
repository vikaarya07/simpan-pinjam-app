<?php

namespace App\Enums;

enum LoanType: string
{
    case Loan = 'loan';
    case LoanOverdue = 'loan_overdue';

    public function savingType(): SavingType
    {
        return match ($this) {
            self::Loan => SavingType::Loan,
            self::LoanOverdue => SavingType::LoanOverdue,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Loan => 'Pinjaman',
            self::LoanOverdue => 'Pinjaman Telat',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Loan => 'indigo',
            self::LoanOverdue => 'rose',
        };
    }

    public function interestPercent(): int
    {
        return match ($this) {
            self::Loan => 5,
            self::LoanOverdue => 10,
        };
    }
}
