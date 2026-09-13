<?php

namespace App\Enums;

enum NotificationType: string
{
    case LoanCreated = 'loan_created';
    case PaymentReceived = 'payment_received';
    case PaymentReminder = 'payment_reminder';
    case AlmostPaidOff = 'almost_paid_off';
    case PaidOff = 'paid_off';
    case LoanOverdueCreated = 'loan_overdue_created';

    public function label(): string
    {
        return __("app.customer_report.notification.types.{$this->value}.label");
    }

    public function color(): string
    {
        return match ($this) {
            self::LoanCreated => 'blue',
            self::PaymentReceived => 'green',
            self::PaymentReminder => 'amber',
            self::AlmostPaidOff => 'orange',
            self::PaidOff => 'emerald',
            self::LoanOverdueCreated => 'red',
        };
    }

    public function iconClass(): string
    {
        return match ($this) {
            self::LoanCreated =>
            'text-blue-600 dark:text-blue-400',

            self::PaymentReceived =>
            'text-green-600 dark:text-green-400',

            self::PaymentReminder =>
            'text-amber-600 dark:text-amber-400',

            self::AlmostPaidOff =>
            'text-orange-600 dark:text-orange-400',

            self::PaidOff =>
            'text-emerald-600 dark:text-emerald-400',

            self::LoanOverdueCreated =>
            'text-red-600 dark:text-red-400',
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
            self::LoanOverdueCreated => 'exclamation-triangle',
        };
    }
}
