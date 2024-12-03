<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Récupérer toutes les catégories
    public function index()
    {
        return response()->json(Category::all());
    }

    // Créer une nouvelle catégorie
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category, 201);
    }

    // Récupérer une catégorie spécifique
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    // Mettre à jour une catégorie
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json($category);
    }

    // Supprimer une catégorie
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}
