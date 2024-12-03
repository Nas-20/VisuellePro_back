<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'owner', 'status', 'type', 'availability', 'license_plate', 'capacity', 'color', 'location_lat', 'location_lng', 'image'
    ];
}


