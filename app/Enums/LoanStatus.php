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
            self::Running => 'Berjalan',
            self::Finish => 'Lunas',
            self::Overdue => 'Telat',
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
