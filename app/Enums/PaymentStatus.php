<?php

namespace App\Enums;

enum PaymentStatus: String
{
    case Clear = 'clear';
    case Skip = 'skip';

    public function label(): string
    {
        return match ($this) {
            self::Clear => 'Clear',
            self::Skip => 'Skip',
        };
    }
    public function color(): string
    {
        return match ($this) {
            self::Clear => 'green',
            self::Skip => 'amber',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Clear => 'check-circle',
            self::Skip => 'minus-circle',
        };
    }
}
