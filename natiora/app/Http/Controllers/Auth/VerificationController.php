<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;

// class VerificationController extends Controller
// {
//     /**
//      * Redirige vers une page personnalisée après la vérification de l'email.
//      *
//      * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
//      * @return \Illuminate\Http\RedirectResponse
//      */
//     public function verify(EmailVerificationRequest $request)
//     {
//         // Vérifie et marque l'email comme vérifié
//         $request->fulfill();
//         session()->flash('message', 'Votre email a été vérifié avec succès.');

//         // Redirige vers une page personnalisée
//         return redirect('/email-verified');
//     }
// }
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    /**
     * Vérifie l'email de l'utilisateur.
     */
    public function verify(EmailVerificationRequest $request)
    {
        // Vérifie et marque l'email comme vérifié
        $request->fulfill();

        // Retourne une réponse JSON
        return response()->json(['message' => 'Email vérifié avec succès.']);
    }


public function sendVerificationEmail(Request $request)
{
    $user = auth()->user(); // Assurez-vous que l'utilisateur est authentifié

    // Générer un token unique
    $token = Str::random(64);

    // Sauvegarder le token dans la base de données (par ex. dans un champ verification_token)
    $user->verification_token = $token;
    $user->save();

    // Envoyer l'e-mail
    Mail::to($user->email)->send(new VerificationEmail($token));

    return response()->json(['message' => 'E-mail de vérification envoyé !']);
}

}

