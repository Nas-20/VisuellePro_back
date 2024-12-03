<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException;

// class AuthController extends Controller
// {
//     // Inscription
//     public function register(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//             'role' => 'required|string|in:client,gestionnaire,administrateur',
//             'phone' => 'required|string|max:15',
//             'address' => 'required|string|max:255',
//         ]);

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'role' => $request->role,
//             'phone' => $request->phone,
//             'address' => $request->address,
//         ]);

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'message' => 'Inscription réussie',
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//             'role' => $user->role
//         ]);
//     }

//     // Connexion
//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|string|email',
//             'password' => 'required|string',
//         ]);

//         $user = User::where('email', $request->email)->first();

//         if (!$user || !Hash::check($request->password, $user->password)) {
//             throw ValidationException::withMessages([
//                 'email' => ['Les informations d\'identification sont incorrectes.'],
//             ]);
//         }

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'message' => 'Connexion réussie',
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//             'role' => $user->role
//         ]);
//     }

//     // Déconnexion
//     public function logout(Request $request)
//     {
//         $request->user()->currentAccessToken()->delete();

//         return response()->json([
//             'message' => 'Déconnexion réussie'
//         ]);
//     }
// }


// use App\Notifications\VerifyEmail;
// class AuthController extends Controller
// {

// public function register(Request $request)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|string|email|max:255|unique:users',
//         'password' => 'required|string|min:8|confirmed',
//         'role' => 'required|string|in:client,gestionnaire,administrateur',
//         'phone' => 'required|string|max:15',
//         'address' => 'required|string|max:255',
//     ]);

//     $user = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'role' => $request->role,
//         'phone' => $request->phone,
//         'address' => $request->address,
//         'email_verified_at' => null, // Assurez-vous que l'email n'est pas encore vérifié
//     ]);

//     // Envoi de la notification de vérification d'email
//     $user->notify(new VerifyEmail());

//     return response()->json([
//         'message' => 'Inscription réussie. Veuillez vérifier votre email pour activer votre compte.',
//     ]);
// }
// public function login(Request $request)
// {
//     $request->validate([
//         'email' => 'required|string|email',
//         'password' => 'required|string',
//     ]);

//     $user = User::where('email', $request->email)->first();

//     if (!$user || !Hash::check($request->password, $user->password)) {
//         throw ValidationException::withMessages([
//             'email' => ['Les informations d\'identification sont incorrectes.'],
//         ]);
//     }

//     if (is_null($user->email_verified_at)) {
//         return response()->json([
//             'message' => 'Votre email n\'a pas encore été vérifié. Veuillez vérifier votre email pour activer votre compte.'
//         ], 403);
//     }

//     $token = $user->createToken('auth_token')->plainTextToken;

//     return response()->json([
//         'message' => 'Connexion réussie',
//         'access_token' => $token,
//         'token_type' => 'Bearer',
//         'role' => $user->role
//     ]);
// }

// }


// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException;
// use App\Notifications\VerifyEmail;

// class AuthController extends Controller
// {
//     // Inscription
//     public function register(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//             'role' => 'required|string|in:client,gestionnaire,administrateur',
//             'phone' => 'required|string|max:15',
//             'address' => 'required|string|max:255',
//         ]);

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'role' => $request->role,
//             'phone' => $request->phone,
//             'address' => $request->address,
//             'email_verified_at' => null, // L'email n'est pas encore vérifié
//         ]);

//         // Envoi de l'email de vérification
//         $user->notify(new VerifyEmail());

//         return response()->json([
//             'message' => 'Inscription réussie. Veuillez vérifier votre email pour activer votre compte.',
//         ]);
//     }

//     // Connexion
//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|string|email',
//             'password' => 'required|string',
//         ]);

//         $user = User::where('email', $request->email)->first();

//         if (!$user || !Hash::check($request->password, $user->password)) {
//             throw ValidationException::withMessages([
//                 'email' => ['Les informations d\'identification sont incorrectes.'],
//             ]);
//         }

//         if (is_null($user->email_verified_at)) {
//             return response()->json([
//                 'message' => 'Votre email n\'a pas encore été vérifié. Veuillez vérifier votre email pour activer votre compte.',
//             ], 403);
//         }

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'message' => 'Connexion réussie',
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//             'role' => $user->role,
//         ]);
//     }

//     // Déconnexion
//     public function logout(Request $request)
//     {
//         $request->user()->currentAccessToken()->delete();

//         return response()->json([
//             'message' => 'Déconnexion réussie.',
//         ]);
//     }
// }



// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;
// use App\Notifications\VerifyEmail;

// class AuthController extends Controller
// {
//     // Inscription avec envoi d'email de vérification
//     public function register(Request $request)
//     {
//         // Validation des champs
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users', // Vérifie l'unicité de l'email
//             'password' => 'required|string|min:8|confirmed', // Confirme que les mots de passe correspondent
//             'role' => 'required|string|in:client,proprietaire,agence,administrateur',
//             'phone' => 'required|string|max:15',
//             'address' => 'required|string|max:255',
//         ]);
    
//         // Création de l'utilisateur
//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'role' => $request->role,
//             'phone' => $request->phone,
//             'address' => $request->address,
//             'email_verified_at' => null, // L'email n'est pas encore vérifié
//         ]);
    
//         // Envoi d'un email de vérification
//         $user->sendEmailVerificationNotification();
    
//         return response()->json([
//             'message' => 'Inscription réussie. Veuillez vérifier votre email pour activer votre compte.',
//         ], 201);
//     }
    
    
// }

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;
// use App\Notifications\CustomVerifyEmail; // Notification personnalisée

// class AuthController extends Controller
// {
//     // Inscription avec envoi d'email de vérification
//     public function register(Request $request)
//     {
//         // Validation des champs
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users', // Vérifie l'unicité de l'email
//             'password' => 'required|string|min:8|confirmed', // Confirme que les mots de passe correspondent
//             'role' => 'required|string|in:client,proprietaire,agence,administrateur',
//             'phone' => 'required|string|max:15',
//             'address' => 'required|string|max:255',
//         ]);
    
//         // Création de l'utilisateur
//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'role' => $request->role,
//             'phone' => $request->phone,
//             'address' => $request->address,
//             'email_verified_at' => null, // L'email n'est pas encore vérifié
//         ]);
    
//         // Envoi d'un email de vérification
//         $user->sendEmailVerificationNotification();
    
//         return response()->json([
//             'message' => 'Inscription réussie. Veuillez vérifier votre email pour activer votre compte.',
//         ], 201);
//     }

//     // Connexion
//     public function login(Request $request)
//     {
//         // Validation des champs
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);

//         // Vérifie si les identifiants sont corrects
//         if (!Auth::attempt($request->only('email', 'password'))) {
//             throw ValidationException::withMessages([
//                 'email' => ['Ces identifiants ne correspondent pas.'],
//             ]);
//         }

//         // Vérifie si l'email a été vérifié
//         $user = Auth::user();
//         if (!$user->hasVerifiedEmail()) {
//             return response()->json([
//                 'message' => 'Veuillez vérifier votre email avant de vous connecter.',
//             ], 403);
//         }

//         // Crée un jeton pour l'utilisateur connecté
//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'message' => 'Connexion réussie.',
//             'token' => $token,
//             'user' => $user,
//         ]);
//     }

//     // Déconnexion
//     public function logout(Request $request)
//     {
//         $request->user()->tokens()->delete();

//         return response()->json([
//             'message' => 'Déconnexion réussie.',
//         ]);
//     }
// }
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;

class AuthController extends Controller
{
    // Inscription avec envoi d'e-mail de vérification
    public function register(Request $request)
    {
        // Validation des champs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:client,proprietaire,agence,administrateur',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);
    
        // Création de l'utilisateur avec un token
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'verification_token' => Str::random(64), // Génération du token
            'email_verified_at' => null, // Assure que ce champ est null
        ]);
    
        // Envoi de l'email de vérification
        Mail::to($user->email)->send(new VerificationEmail($user->verification_token));
    
        return response()->json([
            'message' => 'Inscription réussie. Veuillez vérifier votre email pour activer votre compte.',
        ], 201);
    }
    

    // Connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Identifiants invalides.'], 401);
        }
    
        $user = Auth::user();
    
        if (!$user->email_verified_at) {
            return response()->json(['message' => 'Veuillez vérifier votre email.'], 403);
        }
    
        // Créer un token d'accès
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Connexion réussie.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
    

    // Déconnexion
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }

    // Vérification de l'e-mail
    public function verifyEmail(Request $request)
    {
        $token = $request->query('token');
    
        // Rechercher l'utilisateur avec le token
        $user = User::where('verification_token', $token)->first();
    
        if (!$user) {
            return response()->json(['message' => 'Token invalide ou expiré.'], 400);
        }
    
        // Vérifier si l'email est déjà vérifié
        if ($user->email_verified_at) {
            return response()->json(['message' => 'Adresse email déjà vérifiée.'], 200);
        }
    
        // Marquer l'email comme vérifié
        $user->email_verified_at = now();
        $user->verification_token = null; // Supprimer le token
        $user->save();
    
        return response()->json(['message' => 'Email vérifié avec succès !']);
    }
    
}
