<?php

// namespace App\Notifications;

// use Illuminate\Notifications\Messages\MailMessage;
// use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

// class CustomVerifyEmail extends BaseVerifyEmail
// {
//     // public function toMail($notifiable)
//     // {
//     //     $verificationUrl = $this->verificationUrl($notifiable);

//     //     return (new MailMessage)
//     //         ->subject('Confirmez votre adresse email')
//     //         ->greeting('Bonjour !')
//     //         ->line('Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email.')
//     //         ->action('Vérifier votre email', $verificationUrl)
//     //         ->line("Si vous n'avez pas créé de compte, aucune action n'est requise.")
//     //         ->salutation('Cordialement, L\'équipe Laravel');
//     // }

//     public function toMail($notifiable)
// {
//     $verificationUrl = $this->verificationUrl($notifiable);

//     return (new MailMessage)
//         ->view('emails.verify', ['url' => $verificationUrl]);
// }
// }


namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Personnalise l'email de vérification en utilisant une vue Blade.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('verify-email-web', ['token' => $notifiable->verification_token]);
    
        return (new MailMessage)
            ->subject('Vérifiez votre adresse e-mail')
            ->line('Cliquez sur le lien ci-dessous pour vérifier votre adresse e-mail.')
            ->action('Vérifier mon e-mail', $url)
            ->line('Si vous n\'avez pas créé de compte, aucune action supplémentaire n\'est requise.');
    }
    

    /**
     * Génère une URL signée pour la vérification d'email.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        
        return URL::temporarySignedRoute(
            'verification.verify', // Nom de la route de vérification
            now()->addMinutes(60), // URL valide pendant 60 minutes
            [
                'id' => $notifiable->getKey(), // ID de l'utilisateur
                'hash' => sha1($notifiable->getEmailForVerification()), // Hash de l'email
            ]
        );
    }
}

