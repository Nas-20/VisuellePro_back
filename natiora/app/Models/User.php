<?php

// namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // Inclure le trait Sanctum
// use Illuminate\Database\Eloquent\Factories\HasFactory;

// class User extends Authenticatable implements MustVerifyEmail
// {
//     use Notifiable, HasFactory, HasApiTokens;

//     // Les colonnes qui peuvent être remplies via des formulaires
//     protected $fillable = [
//         'name', 'email', 'password', 'role', 'phone', 'address','avatar'
//     ];

//     // Les colonnes cachées (comme le mot de passe et le token de session)
//     protected $hidden = [
//         'password', 'remember_token',
//     ];

//     // Cast pour convertir certains champs en d'autres types
//     protected $casts = [
//         'email_verified_at' => 'datetime',
//     ];

//     // Méthodes supplémentaires pour gérer les rôles et permissions
// }
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    // Les champs modifiables
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'google_id',
        'avatar',
        'verification_token', // Ajouté pour permettre la modification
    ];

    // Champs cachés
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Convertit les champs en types natifs
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Utiliser la notification personnalisée pour la vérification d'email
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }
}


