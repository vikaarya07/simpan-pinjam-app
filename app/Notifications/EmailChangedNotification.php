<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $oldEmail,
        protected string $newEmail,
        protected bool $isOldEmail = false,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(
                $this->isOldEmail
                    ? 'Email Akun Diubah - ' . config('app.name')
                    : 'Email Akun Berhasil Diperbarui - ' . config('app.name')
            )
            ->view('emails.email-changed', [
                'user' => $notifiable,
                'oldEmail' => $this->oldEmail,
                'newEmail' => $this->newEmail,
                'isOldEmail' => $this->isOldEmail,
            ]);
    }
}
