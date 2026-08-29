<?php

namespace App\Enums;

enum Gender: string
{
    case Male = 'Male';
    case Female = 'Female';

    public function label(): string
    {
        return match ($this) {
            self::Male => '♂ Laki-laki',
            self::Female => '♀ Perempuan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Male => 'blue',
            self::Female => 'pink',
        };
    }
}
