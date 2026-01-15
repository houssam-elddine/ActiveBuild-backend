<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Liste des catégories
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste des catégories récupérée avec succès',
            'data' => Category::with('produits')->get()
        ], 200);
    }

    /**
     * Création d’une catégorie
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nom' => 'required|string|unique:categories,nom'
            ],
            [
                'nom.required' => 'Le nom de la catégorie est obligatoire.',
                'nom.unique' => 'Cette catégorie existe déjà.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::create([
            'nom' => $request->nom
        ]);

        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'data' => $category
        ], 201);
    }

    /**
     * Afficher une catégorie
     */
    public function show(Category $category)
    {
        return response()->json([
            'message' => 'Catégorie récupérée avec succès',
            'data' => $category->load('produits')
        ], 200);
    }

    /**
     * Mise à jour d’une catégorie
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nom' => 'required|string|unique:categories,nom,' . $category->id
            ],
            [
                'nom.required' => 'Le nom de la catégorie est obligatoire.',
                'nom.unique' => 'Ce nom de catégorie existe déjà.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $category->update([
            'nom' => $request->nom
        ]);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'data' => $category
        ], 200);
    }

    /**
     * Suppression d’une catégorie
     */
    public function destroy(Category $category)
    {
        if ($category->produits()->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer cette catégorie car elle contient des produits'
            ], 409);
        }

        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ], 200);
    }
}
