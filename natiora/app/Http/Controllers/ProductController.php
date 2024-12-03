<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Product;
// use App\Models\Category; // Import du modèle Category

// class ProductController extends Controller
// {
//     // Récupérer tous les produits avec leur catégorie associée
//     public function index()
//     {
//         // Charger les produits avec leurs catégories associées
//         $products = Product::with('category')->get();
//         return response()->json($products);
//     }

//     // Ajouter un nouveau produit avec validation
//     public function store(Request $request)
//     {
//         // Validation des données entrantes
//         $validatedData = $request->validate([
//             'name' => 'required|string|max:255',
//             'price' => 'required|numeric',
//             'status' => 'required|string',
//             'description' => 'nullable|string',
//             'customization' => 'required|array',
//             'stock' => 'required|integer',
//             'category_id' => 'required|exists:categories,id', // Validation pour s'assurer que la catégorie existe
//         ]);

//         // Créer un nouveau produit
//         $product = new Product();
//         $product->name = $validatedData['name'];
//         $product->price = $validatedData['price'];
//         $product->status = $validatedData['status'];
//         $product->description = $validatedData['description'];
//         $product->customization = $validatedData['customization']; // Si le cast est utilisé
//         $product->stock = $validatedData['stock'];
//         $product->category_id = $validatedData['category_id']; // Associer la catégorie au produit
//         $product->save();

//         return response()->json($product, 201); // Code HTTP 201 pour la création réussie
//     }

//     // Modifier un produit existant avec validation
//     public function update(Request $request, $id)
//     {
//         // Validation des données modifiées
//         $validatedData = $request->validate([
//             'name' => 'required|string|max:255',
//             'price' => 'required|numeric',
//             'status' => 'required|string',
//             'description' => 'nullable|string',
//             'customization' => 'required|array',
//             'stock' => 'required|integer',
//             'category_id' => 'required|exists:categories,id', // Validation pour s'assurer que la catégorie existe
//         ]);

//         // Récupérer le produit à modifier
//         $product = Product::findOrFail($id);
//         $product->name = $validatedData['name'];
//         $product->price = $validatedData['price'];
//         $product->status = $validatedData['status'];
//         $product->description = $validatedData['description'];
//         $product->customization = $validatedData['customization']; // Si le cast est utilisé
//         $product->stock = $validatedData['stock'];
//         $product->category_id = $validatedData['category_id']; // Mettre à jour la catégorie associée
//         $product->save();

//         return response()->json($product);
//     }

//     // Supprimer un produit
//     public function destroy($id)
//     {
//         $product = Product::findOrFail($id);
//         $product->delete();

//         return response()->json(['message' => 'Produit supprimé avec succès']);
//     }
//     public function searchProducts(Request $request)
//     {
//         $query = $request->query('query'); // Mot-clé envoyé par le frontend

//         if (!$query) {
//             return response()->json([]);
//         }

//         $products = Product::where('name', 'LIKE', '%' . $query . '%')
//             ->limit(5) // Limiter le nombre de résultats pour les suggestions
//             ->get(['id', 'name']); // Sélectionnez uniquement les champs nécessaires

//         return response()->json($products);
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Récupérer tous les produits avec leur catégorie associée
    public function index()
    {
        // Charger les produits avec leurs catégories associées
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    // Ajouter un nouveau produit avec validation
    public function store(Request $request)
    {
        // Validation des données entrantes
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'customization' => 'required|array',
            'customization.sizes' => 'required|array',
            'customization.sizes.*.dimensions' => 'required|string',
            'customization.sizes.*.price_adjustment' => 'required|numeric',
            'customization.finish' => 'required|array',
            'customization.finish.*.description' => 'required|string',
            'customization.finish.*.price_adjustment' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        try {
            // Créer un nouveau produit
            $product = Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'status' => $validatedData['status'],
                'description' => $validatedData['description'],
                'customization' => $validatedData['customization'], // JSON structuré
                'stock' => $validatedData['stock'],
                'category_id' => $validatedData['category_id']
            ]);

            return response()->json($product, 201); // Code HTTP 201 pour la création réussie
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création du produit.'], 500);
        }
    }

    // Modifier un produit existant avec validation
    public function update(Request $request, $id)
    {
        // Validation des données modifiées
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'customization' => 'required|array',
            'customization.sizes' => 'required|array',
            'customization.sizes.*.dimensions' => 'required|string',
            'customization.sizes.*.price_adjustment' => 'required|numeric',
            'customization.finish' => 'required|array',
            'customization.finish.*.description' => 'required|string',
            'customization.finish.*.price_adjustment' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        try {
            // Récupérer le produit à modifier
            $product = Product::findOrFail($id);

            // Mettre à jour le produit avec les nouvelles données
            $product->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'status' => $validatedData['status'],
                'description' => $validatedData['description'],
                'customization' => $validatedData['customization'], // JSON structuré
                'stock' => $validatedData['stock'],
                'category_id' => $validatedData['category_id']
            ]);

            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour du produit.'], 500);
        }
    }

    // Supprimer un produit
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message' => 'Produit supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression du produit.'], 500);
        }
    }

    // Rechercher des produits par nom (pour les suggestions)
    public function searchProducts(Request $request)
    {
        $query = $request->query('query'); // Mot-clé envoyé par le frontend

        if (!$query) {
            return response()->json([]);
        }

        $products = Product::where('name', 'LIKE', '%' . $query . '%')
            ->limit(5) // Limiter le nombre de résultats pour les suggestions
            ->get(['id', 'name']); // Sélectionner uniquement les champs nécessaires

        return response()->json($products);
    }
}
