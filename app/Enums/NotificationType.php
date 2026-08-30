<?php

namespace App\Enums;

enum NotificationType: string
{
    case LoanCreated = 'loan_created';
    case PaymentReceived = 'payment_received';
    case PaymentReminder = 'payment_reminder';
    case AlmostPaidOff = 'almost_paid_off';
    case PaidOff = 'paid_off';

    public function label(): string
    {
        return match ($this) {
            self::LoanCreated => 'Pinjaman Baru',
            self::PaymentReceived => 'Pembayaran Diterima',
            self::PaymentReminder => 'Pengingat Pembayaran',
            self::AlmostPaidOff => 'Hampir Lunas',
            self::PaidOff => 'Pinjaman Lunas',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LoanCreated => 'blue',
            self::PaymentReceived => 'green',
            self::PaymentReminder => 'amber',
            self::AlmostPaidOff => 'orange',
            self::PaidOff => 'emerald',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::LoanCreated => 'banknotes',
            self::PaymentReceived => 'check-circle',
            self::PaymentReminder => 'bell-alert',
            self::AlmostPaidOff => 'clock',
            self::PaidOff => 'check-badge',
        };
    }
}
