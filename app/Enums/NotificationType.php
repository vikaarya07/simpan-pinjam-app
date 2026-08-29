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
            self::LoanCreated => 'Bukti Pinjaman',
            self::PaymentReceived => 'Bukti Pembayaran',
            self::PaymentReminder => 'Reminder Pembayaran',
            self::AlmostPaidOff => 'Hampir Lunas',
            self::PaidOff => 'Pinjaman Lunas',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::LoanCreated => 'document-text',
            self::PaymentReceived => 'banknotes',
            self::PaymentReminder => 'bell-alert',
            self::AlmostPaidOff => 'sparkles',
            self::PaidOff => 'check-circle',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LoanCreated => 'blue',
            self::PaymentReceived => 'green',
            self::PaymentReminder => 'amber',
            self::AlmostPaidOff => 'violet',
            self::PaidOff => 'emerald',
        };
    }
}