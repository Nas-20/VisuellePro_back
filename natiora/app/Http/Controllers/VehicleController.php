<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    // Récupérer tous les véhicules
    public function index()
    {
        return response()->json(Vehicle::all());
    }

    // Ajouter un nouveau véhicule
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'status' => 'required|string',
            'type' => 'required|string',
            'availability' => 'required|string',
            'license_plate' => 'required|string|max:50',
            'capacity' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'location' => 'required|array',  // Valider que location est un tableau
        ]);

        // Si la validation échoue
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Création du véhicule après validation
        $vehicle = Vehicle::create($request->all());

        return response()->json($vehicle, 201);
    }

    // Récupérer un véhicule spécifique
    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }
        return response()->json($vehicle);
    }

    // Mettre à jour un véhicule
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }

        // Validation des données pour la mise à jour
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'status' => 'required|string',
            'type' => 'required|string',
            'availability' => 'required|string',
            'license_plate' => 'required|string|max:50',
            'capacity' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'location' => 'required|array',  // Valider que location est un tableau
        ]);

        // Si la validation échoue
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Mise à jour du véhicule
        $vehicle->update($request->all());

        return response()->json($vehicle);
    }

    // Supprimer un véhicule
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }
        $vehicle->delete();
        return response()->json(['message' => 'Véhicule supprimé avec succès']);
    }

    // Upload d'image pour le véhicule
    public function uploadImage(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }

        // Vérifier si le fichier image est bien présent dans la requête
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Vérification des extensions autorisées
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = $file->getClientOriginalExtension();

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json(['message' => 'Extension de fichier non autorisée'], 400);
            }

            // Générer un nom de fichier unique et enregistrer l'image
            $filename = time() . '.' . $extension;
            $file->move(public_path('images/vehicles'), $filename);

            // Mettre à jour le véhicule avec le nom de l'image
            $vehicle->image = $filename;
            $vehicle->save();

            return response()->json(['message' => 'Image uploadée avec succès', 'image' => $filename]);
        }

        return response()->json(['message' => 'Aucun fichier trouvé'], 400);
    }
}

