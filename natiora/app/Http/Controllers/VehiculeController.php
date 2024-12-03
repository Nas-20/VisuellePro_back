<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;

class VehiculeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'licensePlate' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $vehicule = Vehicule::create([
            'owner_id' => auth()->id(),
            'brand' => $request->brand,
            'model' => $request->model,
            'licensePlate' => $request->licensePlate,
            'description' => $request->description,
        ]);

        return response()->json($vehicule, 201);
    }
}
