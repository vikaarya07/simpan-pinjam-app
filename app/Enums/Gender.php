<?php

namespace App\Enums;

enum Gender: string
{
    case Male = 'Male';
    case Female = 'Female';

    public function label(): string
    {
        return match ($this) {
            self::Male => __('app.member.gender_value.male'),
            self::Female => __('app.member.gender_value.female'),
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
