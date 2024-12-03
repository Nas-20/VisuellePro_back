<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

// // Route pour l'inscription
// // Route::post('/register', function (Request $request) {
// //     $user = User::create([
// //         'name' => $request->name,
// //         'email' => $request->email,
// //         'password' => Hash::make($request->password),
// //     ]);

// //     // Création du token personnel avec Laravel Sanctum ou Passport
// //     return $user->createToken('authToken')->plainTextToken;
// // });

// // // Route pour la connexion
// // Route::post('/login', function (Request $request) {
// //     $user = User::where('email', $request->email)->first();

// //     if (!$user || !Hash::check($request->password, $user->password)) {
// //         return response()->json([
// //             'error' => 'Invalid credentials'
// //         ], 401);
// //     }

// //     // Retourner un token personnel à l'utilisateur
// //     return response()->json([
// //         'token' => $user->createToken('authToken')->plainTextToken
// //     ]);
// // });

// // // Exemple de route protégée par le middleware d'authentification
// // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
// //     return $request->user();
// // });
// // routes/api.php

// // use App\Http\Controllers\ProductController;

// // Route::get('/products', [ProductController::class, 'index']);
// // Route::post('/products', [ProductController::class, 'store']);
// // Route::put('/products/{id}', [ProductController::class, 'update']);
// // Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// // Route pour l'inscription (register)

// use App\Http\Controllers\ProductController;

// /*
// |-----------------------------------------------------------------------
// | API Routes
// |-----------------------------------------------------------------------
// | Here is where you can register API routes for your application.
// | These routes are loaded by the RouteServiceProvider within a group
// | which is assigned the "api" middleware group. Enjoy building your API!
// |
// */


// // Routes CRUD pour les produits
// Route::get('/products', [ProductController::class, 'index']);
// Route::post('/products', [ProductController::class, 'store']);
// Route::put('/products/{id}', [ProductController::class, 'update']);
// Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// // routes CRUD pour les véhicules
// use App\Http\Controllers\VehicleController;

// Route::get('/vehicles', [VehicleController::class, 'index']);
// Route::post('/vehicles', [VehicleController::class, 'store']);
// Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
// Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
// Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);
// Route::post('/vehicles/{id}/upload', [VehicleController::class, 'uploadImage']);


// // routes CRUD pour les utilisateurs
// use App\Http\Controllers\UserController;

// Route::get('users', [UserController::class, 'index']);
// Route::post('users', [UserController::class, 'store']);
// Route::put('users/{id}', [UserController::class, 'update']);
// Route::delete('users/{id}', [UserController::class, 'destroy']);

// // routes CRUD pour les catégories
// use App\Http\Controllers\CategoryController;

// Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/categories', [CategoryController::class, 'store']);
// Route::get('/categories/{id}', [CategoryController::class, 'show']);
// Route::put('/categories/{id}', [CategoryController::class, 'update']);
// Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// // Routes pour l'authentification et l'inscription
// use App\Http\Controllers\AuthController;

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// // Routes pour la gestion de l'avatar


// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/user/avatar', [UserController::class, 'uploadOrUpdateAvatar']);
//     Route::get('/user', [UserController::class, 'getUser']);
//     Route::post('/user/{id}/avatar', [UserController::class, 'updateAvatarById']);
//     Route::delete('/user/avatar', [UserController::class, 'deleteAvatar']); // Nouvelle route pour la suppression de l'avatar
// });
// //routes pour google login
// use App\Http\Controllers\Auth\GoogleController;

// Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
// Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
// Route::post('/auth/google', [GoogleController::class, 'authenticateGoogleUser']);
// Route::get('/products/search', [ProductController::class, 'searchProducts']);

// use App\Http\Controllers\VerificationController;

// Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');






use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController; // Correction de l'import
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
|--------------------------------------------------------------------------
*/

// Routes CRUD pour les produits
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']); // Obtenir tous les produits
    Route::post('/', [ProductController::class, 'store']); // Ajouter un produit
    Route::put('/{id}', [ProductController::class, 'update']); // Modifier un produit
    Route::delete('/{id}', [ProductController::class, 'destroy']); // Supprimer un produit
    Route::get('/search', [ProductController::class, 'searchProducts']); // Recherche de produits
});

// Routes CRUD pour les véhicules
Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']); // Obtenir tous les véhicules
    Route::post('/', [VehicleController::class, 'store']); // Ajouter un véhicule
    Route::get('/{id}', [VehicleController::class, 'show']); // Obtenir un véhicule spécifique
    Route::put('/{id}', [VehicleController::class, 'update']); // Modifier un véhicule
    Route::delete('/{id}', [VehicleController::class, 'destroy']); // Supprimer un véhicule
    Route::post('/{id}/upload', [VehicleController::class, 'uploadImage']); // Télécharger une image pour un véhicule
});

// Routes CRUD pour les utilisateurs
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']); // Obtenir tous les utilisateurs
    Route::post('/', [UserController::class, 'store']); // Ajouter un utilisateur
    Route::put('/{id}', [UserController::class, 'update']); // Modifier un utilisateur
    Route::delete('/{id}', [UserController::class, 'destroy']); // Supprimer un utilisateur
});

// Routes CRUD pour les catégories
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']); // Obtenir toutes les catégories
    Route::post('/', [CategoryController::class, 'store']); // Ajouter une catégorie
    Route::get('/{id}', [CategoryController::class, 'show']); // Obtenir une catégorie spécifique
    Route::put('/{id}', [CategoryController::class, 'update']); // Modifier une catégorie
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // Supprimer une catégorie
});

// Routes pour l'authentification et l'inscription
Route::group(['middleware' => 'api'], function () {
    Route::post('/register', [AuthController::class, 'register']); // Inscription
    Route::post('/login', [AuthController::class, 'login']); // Connexion
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Déconnexion

});

// Route de test pour vérifier si l'API fonctionne
Route::get('/test', function () {
    return response()->json(['message' => 'API working'], 200);
});

// Routes pour la gestion des avatars des utilisateurs
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::post('/avatar', [UserController::class, 'uploadOrUpdateAvatar']); // Ajouter ou modifier un avatar
    Route::get('/', [UserController::class, 'getUser']); // Obtenir les informations d'utilisateur
    Route::post('/{id}/avatar', [UserController::class, 'updateAvatarById']); // Modifier un avatar via un ID utilisateur
    Route::delete('/avatar', [UserController::class, 'deleteAvatar']); // Supprimer un avatar
});

// Routes pour l'authentification via Google
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleController::class, 'redirectToGoogle']); // Redirection vers Google
    Route::get('/callback', [GoogleController::class, 'handleGoogleCallback']); // Gestion du callback Google
    Route::middleware('auth:sanctum')->get('/user', [GoogleController::class, 'currentUser'])->name('current.user');


});

// // Routes pour la vérification de l'email
// Route::prefix('email')->group(function () {
//     Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])
//         ->middleware(['signed', 'throttle:6,1']) // Middleware de signature et de limitation de requêtes
//         ->name('verification.verify'); // Route de vérification d'email

//     Route::post('/resend', function (Request $request) {
//         $request->user()->sendEmailVerificationNotification(); // Renvoyer un email de vérification
//         return response()->json(['message' => 'Email de vérification renvoyé.']);
//     })->middleware('auth:sanctum'); // Middleware de protection par Sanctum
// });



// // Routes protégées pour les utilisateurs connectés et vérifiés
// Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
//     Route::get('/', function () {
//         return response()->json([
//             'message' => 'Bienvenue sur votre tableau de bord, votre email a été vérifié !'
//         ]);
//     });
// });


// Route pour gérer la vérification d'email
// Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
//     ->middleware(['signed', 'throttle:6,1']) // Middleware pour limiter les requêtes
//     ->name('verification.verify');

// // Route pour renvoyer un lien de vérification d'email
// Route::post('/email/resend', function (\Illuminate\Http\Request $request) {
//     $user = $request->user();

//     if ($user->hasVerifiedEmail()) {
//         return response()->json(['message' => 'Email déjà vérifié.'], 400);
//     }

//     $user->sendEmailVerificationNotification();

//     return response()->json(['message' => 'Lien de vérification envoyé.']);
// })->middleware('auth:sanctum')->name('verification.resend');

// // Route pour afficher un message après vérification
// Route::get('/email-verified', function () {
//     return response()->json(['message' => 'Votre email a été vérifié avec succès.']);
// })->name('email.verified');

// Route pour déconnexion
Route::get('/logout', [GoogleController::class, 'logout'])->name('logout');

// Route pour obtenir l'utilisateur connecté
Route::get('/user', [GoogleController::class, 'currentUser'])->name('current.user');
Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email');

Route::post('/upload-image', [ImageUploadController::class, 'upload']);
Route::get('/list-images', [ImageUploadController::class, 'list']);
Route::delete('/delete-image', [ImageUploadController::class, 'delete']);

