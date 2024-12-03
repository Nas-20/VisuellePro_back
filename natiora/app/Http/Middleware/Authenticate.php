<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }
//     protected function redirectTo(Request $request): ?string
// {
//     // Ne pas rediriger pour des routes API ou spécifiques
//     if ($request->is('api/verify-email')) {
//         return null;
//     }

//     // Pour les API, retourne null pour éviter les redirections
//     if ($request->expectsJson() || $request->is('api/*')) {
//         return null;
//     }

//     // Rediriger vers la page de connexion pour les autres cas
//     return route('login');
// }
protected function redirectTo(Request $request): ?string
{
    // Retourne null pour les requêtes JSON, sinon redirige vers une page personnalisée
    if ($request->expectsJson()) {
        return null;
    }

    // Si la requête ne nécessite pas de connexion, redirige vers une page appropriée
    return route('/verify-email'); // Change cette route si besoin
}


}
