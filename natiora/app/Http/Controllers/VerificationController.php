<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\URL;
// use Illuminate\Support\Facades\Hash;

// class VerificationController extends Controller
// {
//     public function verify(Request $request, $id)
//     {
//         $user = User::findOrFail($id);

//         // Vérifie si l'URL signée est valide
//         if (!URL::hasValidSignature($request)) {
//             return response()->json(['message' => 'Lien de vérification invalide ou expiré.'], 403);
//         }

//         // Vérifie si l'utilisateur a déjà activé son email
//         if ($user->email_verified_at) {
//             return response()->json(['message' => 'Votre email est déjà vérifié.'], 200);
//         }

//         // Met à jour le champ `email_verified_at`
//         $user->email_verified_at = now();
//         $user->save();

//         return response()->json(['message' => 'Votre email a été vérifié avec succès !'], 200);
//     }
// }

// namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use Illuminate\Http\Request;

// class VerificationController extends Controller
// {
//     public function verify(EmailVerificationRequest $request)
//     {
//         $request->fulfill(); // Vérifie l'email

//         return response()->json(['message' => 'Email vérifié avec succès.'], 200);
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;


class VerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Lien de vérification invalide.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/email/already-verified'); // Redirige si déjà vérifié
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect('/email/verified'); // Redirige après vérification
    }
}

