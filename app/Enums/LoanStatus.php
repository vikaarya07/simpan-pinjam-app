<?php

namespace App\Enums;

enum LoanStatus: string
{
    case Running = 'running';
    case Finish = 'finish';
    case Overdue = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::Running => __('app.loan.loan_status.running'),
            self::Finish => __('app.loan.loan_status.finish'),
            self::Overdue => __('app.loan.loan_status.overdue'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Running => 'blue',
            self::Finish => 'green',
            self::Overdue => 'red',
        };
    }
}
