<?php

// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\GoogleController; // Importez le contrôleur Google
// use Illuminate\Foundation\Application;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use App\Http\Controllers\AuthController;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Http\Request;

// use Inertia\Inertia;
// use App\Http\Controllers\Auth\VerificationController;
// use Illuminate\Support\Facades\DB;

// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | contains the "web" middleware group. Now create something great!
// |
// */

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// // // Routes pour l'authentification via Google
// // Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
// // Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
// // Redirection vers Google
// Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);



// // Callback après connexion avec Google
// Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// // Déconnexion
// Route::post('/logout', [GoogleController::class, 'logout']);


// // Route::get('/email-verified', function () {
// //     return view('email-verified'); // Vue personnalisée pour informer de la vérification réussie
// // })->middleware('auth');



// // Route pour gérer la vérification d'email
// // Route::get('/verify-email/{id}/{hash}', [\App\Http\Controllers\Auth\VerificationController::class, 'verify'])
// //     ->middleware(['signed'])
// //     ->name('verification.verify');
// // Route::get('/email-verified', function () {
// //     return view('email-verified'); // Affiche la vue après vérification
// // })->name('email.verified'); // Middleware 'auth' retiré


// // // Route pour afficher la page demandant la vérification de l'email
// // Route::get('/email/verify', function () {
// //     return view('auth.verify-email'); // Vue à créer
// // })->middleware('auth')->name('verification.notice');

// // // Route pour gérer la vérification de l'email
// // Route::get('/verify-email/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
// //     ->middleware(['signed'])
// //     ->name('verification.verify');

// // // Route pour afficher la page après vérification
// // Route::get('/email-verified', function () {
// //     return view('email-verified');
// // })->name('email.verified');


// Route::get('/verify-email', function (Request $request) {
//     $token = $request->query('token');

//     // Vérifier si le token est valide
//     $user = DB::table('users')->where('verification_token', $token)->first();

//     if ($user) {
//         // Marquer l'utilisateur comme vérifié
//         DB::table('users')->where('id', $user->id)->update(['email_verified_at' => now(), 'verification_token' => null]);

//         return 'Adresse e-mail vérifiée avec succès !';
//     }

//     return 'Token invalide ou expiré.';
// });


// Route::post('/send-verification-email', [VerificationController::class, 'sendVerificationEmail'])->middleware('auth');
// Route::get('/verify-email', [AuthController::class, 'verifyEmail']);



// // // Route pour afficher la page après vérification
// // Route::get('/email-verified', function () {
// //     return view('email-verified'); // Affiche la vue après vérification
// // })->middleware('auth');


// // Routes protégées pour l'utilisateur connecté
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// require __DIR__.'/auth.php';

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



// Routes pour l'authentification via Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('/logout', [GoogleController::class, 'logout']);

// Route pour vérifier l'email (publique)
Route::get('/verify-email-web', [AuthController::class, 'verifyEmail'])->name('verify-email-web');


// Route pour envoyer un email de vérification (protégée)
Route::post('/send-verification-email', [VerificationController::class, 'sendVerificationEmail'])->middleware('auth');

// Routes protégées pour l'utilisateur connecté
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentification de Laravel Breeze (ou Jetstream)
require __DIR__.'/auth.php';

