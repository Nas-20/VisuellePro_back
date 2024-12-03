<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Valider les fichiers envoyés
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Types et taille max
        ]);

        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Stocker l'image
                $path = $image->store('uploads', 'public');

                $uploadedImages[] = [
                    'filename' => $image->getClientOriginalName(),
                    'path' => $path,
                    'url' => Storage::url($path),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully',
            'images' => $uploadedImages,
        ]);
    }
    public function list()
    {
        // Lister tous les fichiers dans le dossier "uploads" du disque public
        $files = Storage::disk('public')->files('uploads');

        // Construire les URLs publiques pour chaque fichier
        $fileUrls = array_map(function ($file) {
            return [
                'url' => Storage::url($file), // Génère l'URL publique
                'filename' => basename($file), // Nom du fichier
            ];
        }, $files);

        return response()->json($fileUrls); // Retourner un tableau JSON des fichiers
    }
    public function delete(Request $request)
{
    // Valider que le nom de fichier est fourni
    $request->validate([
        'filename' => 'required|string',
    ]);

    $filename = $request->input('filename');
    $filePath = 'uploads/' . $filename;

    // Vérifiez si le fichier existe
    if (Storage::disk('public')->exists($filePath)) {
        // Supprimez le fichier
        Storage::disk('public')->delete($filePath);

        return response()->json([
            'success' => true,
            'message' => 'Image supprimée avec succès.',
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Fichier introuvable.',
        ], 404);
    }
}

}
