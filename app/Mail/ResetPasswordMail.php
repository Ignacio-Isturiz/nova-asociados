<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $actionUrl;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->actionUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
        ], false));
    }

    public function build()
    {
        return $this->subject('Restablecer contraseña')
                    ->view('emails.reset-password'); // tu plantilla HTML
    }
}
