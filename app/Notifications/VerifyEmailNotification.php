<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly string $code)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Confirma tu correo electrónico | '.config('app.name'))
            ->view('emails.verify-email', [
                'user' => $notifiable,
                'code' => $this->code,
                'expirationMinutes' => config('auth.verification.expire', 10),
                'appName' => config('app.name'),
            ]);
    }
}
