<?php

namespace App\Enums;

enum MemberStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';


    public function label(): string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::Inactive => 'Tidak Aktif',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'green',
            self::Inactive => 'zinc',
        };
    }
}
