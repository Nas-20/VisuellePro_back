<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Laravel\Socialite\Facades\Socialite;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class GoogleController extends Controller
// {
//     // Redirige vers Google pour l'authentification
//     public function redirectToGoogle()
//     {
//         return Socialite::driver('google')->redirect();
//     }

//     // Gère le callback après l'authentification Google
//     public function handleGoogleCallback()
//     {
//         try {
//             $googleUser = Socialite::driver('google')->user();

//             // Rechercher l'utilisateur par email
//             $user = User::where('email', $googleUser->getEmail())->first();

//             if (!$user) {
//                 // Créer un utilisateur si aucun n'existe
//                 $user = User::create([
//                     'name' => $googleUser->getName(),
//                     'email' => $googleUser->getEmail(),
//                     'google_id' => $googleUser->getId(),
//                     'avatar' => $googleUser->getAvatar(),
//                     'password' => bcrypt(uniqid()), // Mot de passe aléatoire
//                 ]);
//             }

//             // Authentifier l'utilisateur et créer un token
//             Auth::login($user);
//             $token = $user->createToken('authToken')->plainTextToken;

//             return response()->json([
//                 'access_token' => $token,
//                 'user' => $user,
//             ]);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'error' => 'Erreur lors de l\'authentification Google',
//                 'message' => $e->getMessage(),
//             ], 500);
//         }
//     }

//     public function authenticateGoogleUser(Request $request)
//     {
//         $token = $request->input('token');
//         $googleUser = Socialite::driver('google')->userFromToken($token);

//         $user = User::where('email', $googleUser->getEmail())->first();

//         if (!$user) {
//             $user = User::create([
//                 'name' => $googleUser->getName(),
//                 'email' => $googleUser->getEmail(),
//                 'google_id' => $googleUser->getId(),
//                 'avatar' => $googleUser->getAvatar(),
//                 'password' => bcrypt(uniqid()),
//             ]);
//         }

//         $authToken = $user->createToken('authToken')->plainTextToken;

//         return response()->json([
//             'access_token' => $authToken,
//             'user' => $user,
//         ]);
//     }
// }


// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Google\Client as GoogleClient; // Import du client Google
// use App\Models\User;
// use Illuminate\Http\Request;
// use Laravel\Socialite\Facades\Socialite;
// use Illuminate\Support\Facades\Log;

// use Illuminate\Support\Facades\Auth;

// class GoogleController extends Controller
// {
//     // Redirige vers Google pour l'authentification (non utilisé en REST, mais laissé si besoin)
//     public function redirectToGoogle()
//     {
//         return response()->json([
//             'url' => Socialite::driver('google')->redirect()->getTargetUrl(),
//         ]);
//     }

//     // Gère le callback après l'authentification avec Google (pour les tests)
//     public function handleGoogleCallback()
//     {
//         try {
//             $googleUser = Socialite::driver('google')->user();

//             $user = $this->findOrCreateUser($googleUser);

//             // Créer un token pour l'utilisateur
//             $token = $user->createToken('authToken')->plainTextToken;

//             return response()->json([
//                 'access_token' => $token,
//                 'user' => $user,
//             ]);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'error' => 'Erreur lors de l\'authentification Google',
//                 'message' => $e->getMessage(),
//             ], 500);
//         }
//     }

//     public function authenticateGoogleUser(Request $request)
//     {
//         try {
//             $token = $request->input('token');

//             // Vérifiez si un token a été transmis
//             if (!$token) {
//                 return response()->json(['error' => 'Token manquant'], 400);
//             }
//             Log::info('Google Token reçu : ' . $token);
//             Log::info('Test de logging dans GoogleController');
//             // Instanciez le client Google avec votre client_id
//             $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);

//             // Vérifiez et décodez le token
//             $payload = $client->verifyIdToken($token);

//             // Si le token est invalide
//             if (!$payload) {
//                 return response()->json(['error' => 'Token Google invalide'], 401);
//             }

//             // Extraire les données utilisateur de Google
//             $googleUser = (object) [
//                 'id' => $payload['sub'],
//                 'name' => $payload['name'],
//                 'email' => $payload['email'],
//                 'avatar' => $payload['picture'] ?? null,
//             ];

//             // Vérifiez si l'utilisateur existe déjà
//             $user = User::where('email', $googleUser->email)->first();

//             if (!$user) {
//                 // Créez l'utilisateur s'il n'existe pas
//                 $user = User::create([
//                     'name' => $googleUser->name,
//                     'email' => $googleUser->email,
//                     'google_id' => $googleUser->id,
//                     'avatar' => $googleUser->avatar,
//                     'password' => bcrypt(uniqid()),
//                     'role' => 'client',
//                 ]);
//             } else {
//                 // Mettez à jour les données Google si elles ont changé
//                 $user->update([
//                     'google_id' => $googleUser->id,
//                     'avatar' => $googleUser->avatar,
//                 ]);
//             }

//             // Créez un token d'accès pour cet utilisateur
//             $authToken = $user->createToken('authToken')->plainTextToken;

//             return response()->json([
//                 'access_token' => $authToken,
//                 'user' => $user,
//             ]);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'error' => 'Erreur lors de la connexion avec Google',
//                 'message' => $e->getMessage(),
//             ], 500);
//         }
//     }
// }


// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Google\Client as GoogleClient; // Utiliser le client Google
// use App\Models\User;
// use App\Models\UserToken; // Si vous utilisez une table pour les tokens
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;
// use Laravel\Socialite\Facades\Socialite;
// use Illuminate\Support\Facades\Auth;

// class GoogleController extends Controller
// {
//     /**
//      * Redirige vers Google pour l'authentification (utile dans une app web classique).
//      */
//     public function redirectToGoogle()
//     {
//         return response()->json([
//             'url' => Socialite::driver('google')->redirect()->getTargetUrl(),
//         ]);
//     }

//     /**
//      * Gère le callback après l'authentification Google (pour les applications Web classiques).
//      */
//     public function handleGoogleCallback()
//     {
//         try {
//             $googleUser = Socialite::driver('google')->user();

//             // Trouve ou crée l'utilisateur dans la base de données
//             $user = $this->findOrCreateUser($googleUser);

//             // Génère un token d'authentification pour cet utilisateur
//             $token = $user->createToken('authToken')->plainTextToken;

//             return response()->json([
//                 'access_token' => $token,
//                 'user' => $user,
//             ]);
//         } catch (\Exception $e) {
//             Log::error('Erreur lors de la connexion Google : ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Erreur lors de l\'authentification Google',
//                 'message' => $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Authentifie un utilisateur Google basé sur le token reçu du frontend.
//      */
//     public function authenticateGoogleUser(Request $request)
//     {
//         try {
//             // Récupère le token du frontend
//             $token = $request->input('token');

//             if (!$token) {
//                 return response()->json(['error' => 'Token manquant'], 400);
//             }

//             Log::info('Google Token reçu : ' . $token);

//             // Configure le client Google pour valider le token
//             $client = new GoogleClient(['client_id' => env('GOOGLE_CLIENT_ID')]);
//             $payload = $client->verifyIdToken($token);

//             // Si le token est invalide
//             if (!$payload) {
//                 return response()->json(['error' => 'Token Google invalide'], 401);
//             }

//             Log::info('Données utilisateur Google : ' . json_encode($payload));

//             // Extraire les informations utilisateur de Google
//             $googleUser = (object) [
//                 'id' => $payload['sub'],
//                 'name' => $payload['name'],
//                 'email' => $payload['email'],
//                 'avatar' => $payload['picture'] ?? null,
//             ];

//             // Trouver ou créer un utilisateur
//             $user = User::updateOrCreate(
//                 ['email' => $googleUser->email],
//                 [
//                     'name' => $googleUser->name,
//                     'google_id' => $googleUser->id,
//                     'avatar' => $googleUser->avatar,
//                     'password' => bcrypt(uniqid()), // Génère un mot de passe aléatoire
//                     'role' => 'client', // Attribue un rôle par défaut
//                 ]
//             );

//             // Enregistrer le token Google dans une table dédiée (optionnel)
//             UserToken::updateOrCreate(
//                 ['user_id' => $user->id, 'provider' => 'google'],
//                 [
//                     'token' => $token,
//                     'expires_at' => now()->addDays(7), // Exemple de durée d'expiration
//                 ]
//             );

//             // Génère un token d'accès pour l'utilisateur
//             $authToken = $user->createToken('authToken')->plainTextToken;

//             return response()->json([
//                 'access_token' => $authToken,
//                 'user' => $user,
//             ]);
//         } catch (\Exception $e) {
//             Log::error('Erreur lors de la connexion Google : ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Erreur lors de la connexion avec Google',
//                 'message' => $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Trouve ou crée un utilisateur dans la base de données.
//      */
//     private function findOrCreateUser($googleUser)
//     {
//         return User::updateOrCreate(
//             ['email' => $googleUser->getEmail()],
//             [
//                 'name' => $googleUser->getName(),
//                 'google_id' => $googleUser->getId(),
//                 'avatar' => $googleUser->getAvatar(),
//                 'password' => bcrypt(uniqid()), // Génère un mot de passe aléatoire
//                 'role' => 'client', // Rôle par défaut
//             ]
//         );
//     }
// }


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Laravel\Socialite\Facades\Socialite;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Str;

// class GoogleController extends Controller
// {
//     /**
//      * Redirige l'utilisateur vers la page d'authentification Google.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function redirectToGoogle()
//     {
//         return Socialite::driver('google') ->scopes(['openid', 'profile', 'email'])->redirect();
//     }

//     /**
//      * Gère le callback après l'authentification Google.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function handleGoogleCallback()
//     {
//         try {
//             // Récupère les informations de l'utilisateur depuis Google
//             $googleUser = Socialite::driver('google')->stateless()->user();
    
//             // Exemple d'accès aux informations :
//             $name = $googleUser->name;
//             $email = $googleUser->email;
//             $avatar = $googleUser->avatar;
    
//             // Ici, vous pouvez connecter l'utilisateur ou le créer dans la base de données
//             $user = User::firstOrCreate(
//                 ['email' => $email],
//                 [
//                     'name' => $name,
//                     'google_id' => $googleUser->id,
//                     'avatar' => $avatar,
//                     'password' => bcrypt(Str::random(16)),
//                 ]
//             );
    
//             // Connecter l'utilisateur
//             Auth::login($user);
    
//             // Redirigez l'utilisateur vers le tableau de bord ou autre page
//             return redirect(env('FRONTEND_URL') . '/admin/dashboard');

//         } catch (\Exception $e) {
//             return redirect('/')->with('error', 'Erreur lors de l\'authentification Google.');
//         }
//     }
    

//     /**
//      * Déconnecter l'utilisateur.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function logout()
//     {
//         Auth::logout();

//         return redirect('/')->with('success', 'Vous êtes déconnecté.');
//     }

//     /**
//      * Obtenir les informations de l'utilisateur actuellement connecté.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function currentUser()
//     {
//         if (Auth::check()) {
//             return response()->json([
//                 'user' => Auth::user(),
//             ]);
//         }

//         return response()->json(['error' => 'Non authentifié.'], 401);
//     }
//     public function authenticateGoogleUser(Request $request)
// {
//     try {
//         // Récupérer le token envoyé depuis React
//         $credential = $request->input('credential');
        
//         // Récupérer les informations de l'utilisateur à partir du token JWT
//         $googleUser = Socialite::driver('google')->stateless()->userFromToken($credential);

//         // Vérifiez si l'utilisateur existe déjà dans la base de données
//         $user = User::firstOrCreate(
//             ['email' => $googleUser->email],
//             [
//                 'name' => $googleUser->name,
//                 'google_id' => $googleUser->id,
//                 'avatar' => $googleUser->avatar,
//                 'password' => bcrypt(Str::random(16)), // Génération d'un mot de passe sécurisé
//             ]
//         );

//         // Connecter l'utilisateur
//         Auth::login($user);

//         return response()->json([
//             'success' => true,
//             'message' => 'Connexion réussie',
//             'redirect' => 'http://localhost:3000/admin/dashboard',
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Erreur lors de l\'authentification Google',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }

// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirige l'utilisateur vers la page d'authentification Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email']) // Scopes requis pour récupérer les données utilisateur
            ->redirect();
    }

    /**
     * Gère le callback après l'authentification Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            // Récupérer les informations de l'utilisateur depuis Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Vérifier si l'utilisateur existe dans la base de données ou en créer un
            $user = User::firstOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(Str::random(16)), // Génération d'un mot de passe aléatoire
                    'role' => 'client', // Assigner un rôle par défaut
                ]
            );

            // Connecter l'utilisateur
            Auth::login($user);

            // Rediriger vers le tableau de bord ou une autre page
            return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/clients');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la connexion Google : ' . $e->getMessage());
            return redirect('/')->with('error', 'Erreur lors de l\'authentification Google.');
        }
    }
    public function currentUser(Request $request)
    {
        try {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();

            // Vérifiez si l'utilisateur existe
            if (!$user) {
                return response()->json(['message' => 'Utilisateur introuvable'], 404);
            }

            // Retournez les données de l'utilisateur
            return response()->json($user);
        } catch (\Exception $e) {
            // En cas d'erreur, retournez un message d'erreur
            return response()->json([
                'message' => 'Erreur lors de la récupération des données utilisateur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
