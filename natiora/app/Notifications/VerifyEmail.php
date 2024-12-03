<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{
    public function toMail($notifiable)
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $notifiable->id,
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return (new MailMessage)
            ->subject('Vérification de votre adresse email')
            ->line('Merci pour votre inscription. Cliquez sur le bouton ci-dessous pour vérifier votre email.')
            ->action('Vérifier mon email', $verificationUrl)
            ->line('Si vous n\'avez pas créé de compte, ignorez cet email.');
    }
}
