<?php

namespace App\Enums;

enum MemberStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';


    public function label(): string
    {
        return match ($this) {
            self::Active => __('app.member.member_status.active'),
            self::Inactive => __('app.member.member_status.inactive'),
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
