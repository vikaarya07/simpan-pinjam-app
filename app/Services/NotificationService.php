<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\CustomerNotification;
use App\Models\Loan;
use App\Models\Payment;

class NotificationService
{
    // Loan Created 
    public function loanCreated(Loan $loan): CustomerNotification
    {
        $loan->loadMissing('member');

        return $this->create(
            type: NotificationType::LoanCreated,
            memberId: $loan->member_id,
            message: $this->loanCreatedMessage($loan),
            loanId: $loan->id,
        );
    }

    private function loanCreatedMessage(Loan $loan): string
    {
        $member = $loan->member;

        return implode("\n", [
            __('app.customer_report.notification.organization.name'),
            __('app.customer_report.notification.organization.division'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            '',
            __('app.customer_report.notification.messages.loan_created.title'),
            '',
            __('app.customer_report.notification.messages.loan_created.greeting', [
                'name' => $member->name,
            ]),
            '',
            __('app.customer_report.notification.messages.loan_created.success'),
            '',
            __('app.customer_report.notification.messages.loan_created.loan_number', [
                'value' => $loan->loan_number,
            ]),
            '',
            __('app.customer_report.notification.messages.loan_created.date', [
                'value' => $loan->waktu,
            ]),
            '',
            __('app.customer_report.notification.messages.loan_created.details'),
            __('app.customer_report.notification.messages.loan_created.principal', [
                'value' => $this->money($loan->principal),
            ]),
            __('app.customer_report.notification.messages.loan_created.interest', [
                'percent' => $loan->interest_percent,
                'value' => $this->money($loan->interest_amount),
            ]),
            __('app.customer_report.notification.messages.loan_created.total', [
                'value' => $this->money($loan->amount),
            ]),
            '',
            __('app.customer_report.notification.messages.loan_created.installment_title'),
            __('app.customer_report.notification.messages.loan_created.installment'),
            '',
            __('app.customer_report.notification.messages.loan_created.thanks'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            __('app.customer_report.notification.messages.automatic_note'),
            __('app.customer_report.notification.messages.ignore_note'),
        ]);
    }

    // Payment Received
    public function paymentReceived(Payment $payment): ?CustomerNotification
    {
        $payment->loadMissing([
            'loan.member',
            'meeting',
        ]);

        $loan = $payment->loan;

        if (! $loan) {
            return null;
        }

        $alreadyExists = CustomerNotification::query()
            ->where('type', NotificationType::PaymentReceived)
            ->where('payment_id', $payment->id)
            ->exists();

        if ($alreadyExists) {
            return null;
        }

        return $this->create(
            type: NotificationType::PaymentReceived,
            memberId: $loan->member_id,
            message: $this->paymentReceivedMessage($payment),
            loanId: $loan->id,
            paymentId: $payment->id,
            meetingId: $payment->meeting_id,
        );
    }

    private function paymentReceivedMessage(Payment $payment): string
    {
        $loan = $payment->loan;
        $member = $loan->member;

        return implode("\n", [
            __('app.customer_report.notification.organization.name'),
            __('app.customer_report.notification.organization.division'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            '',
            __('app.customer_report.notification.messages.payment_received.title'),
            '',
            __('app.customer_report.notification.messages.payment_received.greeting', [
                'name' => $member->name,
            ]),
            '',
            __('app.customer_report.notification.messages.payment_received.success'),
            '',
            __('app.customer_report.notification.messages.payment_received.loan_number', [
                'value' => $loan->loan_number,
            ]),
            '',
            __('app.customer_report.notification.messages.payment_received.date', [
                'value' => $payment->waktu ?? '-',
            ]),
            '',
            __('app.customer_report.notification.messages.payment_received.installment', [
                'value' => $payment->payment_count ?? '-',
            ]),
            __('app.customer_report.notification.messages.payment_received.payment', [
                'value' => $this->money($payment->amount),
            ]),
            __('app.customer_report.notification.messages.payment_received.method', [
                'value' => $payment->method?->label() ?? '-',
            ]),
            '',
            __('app.customer_report.notification.messages.payment_received.remaining', [
                'value' => $this->money($loan->remaining),
            ]),
            '',
            __('app.customer_report.notification.messages.payment_received.thanks'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            __('app.customer_report.notification.messages.automatic_note'),
            __('app.customer_report.notification.messages.ignore_note'),
        ]);
    }

    //  Payment Reminder
    public function paymentReminder(Loan $loan, ?int $meetingId = null,): ?CustomerNotification
    {
        $loan->loadMissing('member');

        $nextPayment = $this->nextPaymentNumber($loan);

        /*
     * Payment Reminder hanya untuk angsuran 1–5.
     *
     * Angsuran ke-6 menggunakan Almost Paid Off.
     */
        if ($nextPayment > 5) {
            return null;
        }

        /*
     * Jangan kirim reminder jika pinjaman sudah lunas.
     */
        if ((float) $loan->remaining <= 0) {
            return null;
        }

        /*
     * Satu reminder untuk satu loan
     * pada satu meeting.
     */
        $alreadyExists = CustomerNotification::query()
            ->where('type', NotificationType::PaymentReminder)
            ->where('loan_id', $loan->id)
            ->when(
                $meetingId,
                fn($query) => $query->where('meeting_id', $meetingId),
            )
            ->exists();

        if ($alreadyExists) {
            return null;
        }

        return $this->create(
            type: NotificationType::PaymentReminder,
            memberId: $loan->member_id,
            message: $this->paymentReminderMessage(
                loan: $loan,
                nextPayment: $nextPayment,
            ),
            loanId: $loan->id,
            meetingId: $meetingId,
        );
    }

    private function paymentReminderMessage(Loan $loan, int $nextPayment,): string
    {
        $member = $loan->member;

        return implode("\n", [
            __('app.customer_report.notification.messages.payment_reminder.title'),
            '',
            __('app.customer_report.notification.messages.payment_reminder.greeting', [
                'name' => $member->name,
            ]),
            '',
            __('app.customer_report.notification.messages.payment_reminder.reminder'),
            '',
            __('app.customer_report.notification.messages.payment_reminder.loan_number', [
                'value' => $loan->loan_number,
            ]),
            __('app.customer_report.notification.messages.payment_reminder.installment', [
                'value' => $nextPayment,
            ]),
            __('app.customer_report.notification.messages.payment_reminder.remaining', [
                'value' => $this->money($loan->remaining),
            ]),
            '',
            __('app.customer_report.notification.messages.payment_reminder.action'),
            '',
            __('app.customer_report.notification.messages.payment_reminder.thanks'),
        ]);
    }

    // Almost Paid Off 
    public function almostPaidOff(Loan $loan, ?int $meetingId = null,): ?CustomerNotification
    {
        $loan->loadMissing('member');

        /*
     * Almost Paid Off hanya untuk
     * angsuran berikutnya = 6.
     */
        $nextPayment = $this->nextPaymentNumber($loan);

        if ($nextPayment !== 6) {
            return null;
        }

        /*
     * Jika sudah lunas, tidak perlu reminder.
     */
        if ((float) $loan->remaining <= 0) {
            return null;
        }

        /*
     * Satu notifikasi Almost Paid Off
     * untuk satu loan pada satu meeting.
     */
        $alreadyExists = CustomerNotification::query()
            ->where('type', NotificationType::AlmostPaidOff)
            ->where('loan_id', $loan->id)
            ->when(
                $meetingId,
                fn($query) => $query->where('meeting_id', $meetingId),
            )
            ->exists();

        if ($alreadyExists) {
            return null;
        }

        return $this->create(
            type: NotificationType::AlmostPaidOff,
            memberId: $loan->member_id,
            message: $this->almostPaidOffMessage(
                loan: $loan,
                nextPayment: $nextPayment,
            ),
            loanId: $loan->id,
            meetingId: $meetingId,
        );
    }

    private function almostPaidOffMessage(Loan $loan, int $nextPayment,): string
    {
        $member = $loan->member;

        return implode("\n", [
            __('app.customer_report.notification.messages.almost_paid_off.title'),

            '',

            __('app.customer_report.notification.messages.almost_paid_off.greeting', [
                'name' => $member->name,
            ]),

            '',

            __('app.customer_report.notification.messages.almost_paid_off.message'),

            '',

            __('app.customer_report.notification.messages.almost_paid_off.loan_number', [
                'value' => $loan->loan_number,
            ]),

            __('app.customer_report.notification.messages.almost_paid_off.installment', [
                'value' => $nextPayment,
            ]),

            __('app.customer_report.notification.messages.almost_paid_off.remaining', [
                'value' => $this->money($loan->remaining),
            ]),

            '',

            __('app.customer_report.notification.messages.almost_paid_off.next'),

            '',

            __('app.customer_report.notification.messages.almost_paid_off.thanks'),
        ]);
    }

    private function nextPaymentNumber(Loan $loan): int
    {
        return ((int) $loan->payments()->max('payment_count')) + 1;
    }

    // Loan Created 
    public function loanOverdueCreated(Loan $loan, ?int $meetingId = null,): CustomerNotification
    {
        $loan->loadMissing([
            'member',
            'previousLoan',
        ]);

        return $this->create(
            type: NotificationType::LoanOverdueCreated,
            memberId: $loan->member_id,
            message: $this->loanOverdueCreatedMessage($loan),
            loanId: $loan->id,
            meetingId: $meetingId,
        );
    }
    public function loanOverdueCreatedMessage(Loan $loan): string
    {
        $member = $loan->member;

        return implode("\n", [
            __('app.customer_report.notification.organization.name'),
            __('app.customer_report.notification.organization.division'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.title'),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.greeting', [
                'name' => $member->name,
            ]),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.message'),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.loan_number', [
                'value' => $loan->loan_number,
            ]),
            __('app.customer_report.notification.messages.loan_overdue_created.previous_loan_number', [
                'value' => $loan->previousLoan?->loan_number,
            ]),
            __('app.customer_report.notification.messages.loan_overdue_created.date', [
                'value' => $loan->waktu,
            ]),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.principal', [
                'value' => idr($loan->principal),
            ]),
            __('app.customer_report.notification.messages.loan_overdue_created.interest', [
                'value' => idr($loan->interest_amount),
            ]),
            __('app.customer_report.notification.messages.loan_overdue_created.amount', [
                'value' => idr($loan->amount),
            ]),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.installment'),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.note'),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.closing'),
            '',
            __('app.customer_report.notification.messages.loan_overdue_created.thanks'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            __('app.customer_report.notification.messages.automatic_note'),
            __('app.customer_report.notification.messages.ignore_note'),
        ]);
    }

    // Paid Off
    public function paidOff(Payment $payment): ?CustomerNotification
    {
        $payment->loadMissing([
            'loan.member',
        ]);

        $loan = $payment->loan;

        //   Paid Off hanya jika remaining sudah 0.
        if ((float) $loan->remaining > 0) {
            return null;
        }

        //   Cegah duplicate notification.
        $alreadyExists = CustomerNotification::query()
            ->where('type', NotificationType::PaidOff)
            ->where('payment_id', $payment->id)
            ->exists();

        if ($alreadyExists) {
            return null;
        }

        return $this->create(
            type: NotificationType::PaidOff,
            memberId: $loan->member_id,
            message: $this->paidOffMessage($payment),
            loanId: $loan->id,
            paymentId: $payment->id,
            meetingId: $payment->meeting_id,
        );
    }

    private function paidOffMessage(Payment $payment): string
    {
        $loan = $payment->loan;
        $member = $loan->member;

        return implode("\n", [
            __('app.customer_report.notification.organization.name'),
            __('app.customer_report.notification.organization.division'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            '',
            __('app.customer_report.notification.messages.paid_off.title'),
            '',
            __('app.customer_report.notification.messages.paid_off.greeting', [
                'name' => $member->name,
            ]),
            '',
            __('app.customer_report.notification.messages.paid_off.message'),
            '',
            __('app.customer_report.notification.messages.paid_off.loan_number', [
                'value' => $loan->loan_number,
            ]),
            '',
            __('app.customer_report.notification.messages.paid_off.installment', [
                'value' => $payment->payment_count ?? '-',
            ]),
            __('app.customer_report.notification.messages.paid_off.date', [
                'value' => $payment->waktu ?? '-',
            ]),
            __('app.customer_report.notification.messages.paid_off.payment', [
                'value' => $this->money($payment->amount),
            ]),
            __('app.customer_report.notification.messages.paid_off.remaining'),
            '',
            __('app.customer_report.notification.messages.paid_off.thanks'),
            '',
            '━━━━━━━━━━━━━━━━━━',
            __('app.customer_report.notification.messages.automatic_note'),
            __('app.customer_report.notification.messages.ignore_note'),
        ]);
    }

    // Create Notification
    private function create(
        NotificationType $type,
        int $memberId,
        string $message,
        ?int $loanId = null,
        ?int $paymentId = null,
        ?int $meetingId = null,
    ): CustomerNotification {
        return CustomerNotification::create([
            'member_id' => $memberId,
            'loan_id' => $loanId,
            'payment_id' => $paymentId,
            'meeting_id' => $meetingId,
            'type' => $type,
            'title' => $this->title($type),
            'message' => $message,
        ]);
    }

    private function title(NotificationType $type): string
    {
        return match ($type) {
            NotificationType::LoanCreated =>
            __('app.customer_report.notification.messages.loan_created.title'),

            NotificationType::PaymentReceived =>
            __('app.customer_report.notification.messages.payment_received.title'),

            NotificationType::PaymentReminder =>
            __('app.customer_report.notification.messages.payment_reminder.title'),

            NotificationType::AlmostPaidOff =>
            __('app.customer_report.notification.messages.almost_paid_off.title'),

            NotificationType::LoanOverdueCreated =>
            __('app.customer_report.notification.messages.loan_overdue_created.title'),

            NotificationType::PaidOff =>
            __('app.customer_report.notification.messages.paid_off.title'),
        };
    }

    //   Generate ulang message notification untuk Preview.
    //   Menggunakan template message yang sama dengan
    //   message saat notification pertama kali dibuat.
    public function previewMessage(CustomerNotification $notification): string
    {
        $notification->loadMissing([
            'loan.member',
            'loan.payments',
            'payment.loan.member',
            'payment.meeting',
            'meeting',
        ]);

        return match ($notification->type) {
            NotificationType::LoanCreated => $notification->loan
                ? $this->loanCreatedMessage($notification->loan)
                : $notification->message,

            NotificationType::PaymentReceived => $notification->payment
                ? $this->paymentReceivedMessage($notification->payment)
                : $notification->message,

            NotificationType::PaymentReminder => $notification->loan
                ? $this->paymentReminderMessage(
                    loan: $notification->loan,
                    nextPayment: $this->nextPaymentNumber($notification->loan),
                )
                : $notification->message,

            NotificationType::AlmostPaidOff => $notification->loan
                ? $this->almostPaidOffMessage(
                    loan: $notification->loan,
                    nextPayment: 6,
                )
                : $notification->message,

            NotificationType::LoanOverdueCreated => $notification->loan
                ? $this->loanOverdueCreatedMessage($notification->loan)
                : $notification->message,

            NotificationType::PaidOff => $notification->payment
                ? $this->paidOffMessage($notification->payment)
                : $notification->message,

            default => $notification->message,
        };
    }

    //  Money
    private function money(float|int|string|null $amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.',);
    }
}
