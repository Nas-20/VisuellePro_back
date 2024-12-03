<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Méthode pour uploader ou mettre à jour l'avatar de l'utilisateur authentifié
    public function uploadOrUpdateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return response()->json([
            'message' => 'Avatar téléchargé ou mis à jour avec succès',
            'avatar_url' => Storage::url($path),
        ]);
    }

    // Méthode pour récupérer les informations de l'utilisateur avec l'URL de l'avatar
    public function getUser()
    {
        $user = auth()->user();
        $user->avatar_url = $user->avatar ? Storage::url($user->avatar) : null;

        return response()->json($user);
    }

    // Méthode pour mettre à jour l'avatar d'un utilisateur spécifique par son ID
    public function updateAvatarById(Request $request, $id)
    {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return response()->json([
            'message' => 'Avatar mis à jour avec succès',
            'avatar_url' => Storage::url($path),
        ]);
    }

    // Méthode pour supprimer l'avatar de l'utilisateur
    public function deleteAvatar()
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();

            return response()->json([
                'message' => 'Avatar supprimé avec succès'
            ]);
        }

        return response()->json([
            'message' => 'Aucun avatar à supprimer'
        ], 404);
    }
}

