<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Restablecer contraseña')
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'actionUrl' => $url,
                'actionText' => 'Restablecer contraseña',
                'introLines' => ['Recibiste este correo porque solicitaste restablecer tu contraseña.'],
                'outroLines' => ['Si no solicitaste este cambio, puedes ignorar este correo.'],
            ]);
    }
}
