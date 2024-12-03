<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Définit la longueur par défaut des chaînes de caractères pour éviter certains problèmes avec MySQL
        Schema::defaultStringLength(191);



        // Définir l'expiration des tokens d'accès (15 jours ici)
        Passport::tokensExpireIn(now()->addDays(15));

        // Définir l'expiration des tokens d'actualisation (30 jours ici)
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
