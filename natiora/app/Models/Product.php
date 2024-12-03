<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Les champs modifiables
    protected $fillable = [
        'name', 'price', 'status', 'description', 'customization', 'stock','category_id'
    ];

    // Décode automatiquement le JSON lors de la récupération des données
    protected $casts = [
        'customization' => 'array', // Cast le champ 'customization' en tableau automatiquement
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
