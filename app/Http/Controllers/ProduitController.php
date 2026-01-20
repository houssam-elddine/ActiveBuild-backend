<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Profile;
use App\Models\Accessoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    /**
     * Liste des produits
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste des produits récupérée avec succès',
            'data' => Produit::with(['profile', 'accessoire', 'categorie'])->get()
        ], 200);
    }

    /**
     * Création d’un produit (Profilé ou Accessoire)
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'img' => 'required|image : jpg,png,jpeg,gif,svg|max:80480',
                'categorie_id' => 'required|exists:categories,id',
                'nom' => 'required|string',
                'description' => 'nullable|string',
                'reference' => 'required|string|unique:produits,reference',
                'type' => 'required|in:Profilé,Accessoire',
                'designation' => 'required|string',
                'prixUnitaire' => 'required|numeric|min:0',
                'stockDisponible' => 'required|integer|min:0',

                // Profilé
                'materiaux' => 'required_if:type,Profilé|string',
                'dimensions' => 'required_if:type,Profilé|string',
                'couleur' => 'required_if:type,Profilé|string',
                'finition' => 'required_if:type,Profilé|string',

                // Accessoire
                'categorie' => 'required_if:type,Accessoire|string',
                'compatibilite' => 'required_if:type,Accessoire|string',
            ],
            [
                'img.required' => 'L\'image du produit est obligatoire.',
                'img.image' => 'Le fichier doit être une image valide.',
                'img.max' => 'L\'image ne doit pas dépasser 80480 Ko.',
                'categorie_id.required' => 'La catégorie est obligatoire.',
                'categorie_id.exists' => 'La catégorie sélectionnée est invalide.',
                'nom.required' => 'Le nom du produit est obligatoire.',
                'reference.required' => 'La référence du produit est obligatoire.',
                'reference.unique' => 'Cette référence existe déjà.',
                'type.required' => 'Le type du produit est obligatoire.',
                'type.in' => 'Le type doit être Profilé ou Accessoire.',
                'designation.required' => 'La désignation est obligatoire.',
                'prixUnitaire.required' => 'Le prix unitaire est obligatoire.',
                'stockDisponible.required' => 'Le stock disponible est obligatoire.',
                'materiaux.required_if' => 'Le matériau est obligatoire pour un profilé.',
                'dimensions.required_if' => 'Les dimensions sont obligatoires pour un profilé.',
                'couleur.required_if' => 'La couleur est obligatoire pour un profilé.',
                'finition.required_if' => 'La finition est obligatoire pour un profilé.',
                'categorie.required_if' => 'La catégorie est obligatoire pour un accessoire.',
                'compatibilite.required_if' => 'La compatibilité est obligatoire pour un accessoire.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $img = $validator['img'];
        $imgName = time().'.'.$img->getClientOriginalExtension();
        $img->move(public_path('images/produits'), $imgName);

        $imagePath = 'images/produits/' . $imgName;

        return DB::transaction(function () use ($request, $imagePath) {

            $produit = Produit::create([
                'categorie_id' => $request->categorie_id,
                'nom' => $request->nom,
                'description' => $request->description,
                'reference' => $request->reference,
                'type' => $request->type,
                'designation' => $request->designation,
                'prixUnitaire' => $request->prixUnitaire,
                'stockDisponible' => $request->stockDisponible,
                'img' => $imagePath,
            ]);

            if ($request->type === 'Profilé') {
                Profile::create([
                    'materiaux' => $request->materiaux,
                    'dimensions' => $request->dimensions,
                    'couleur' => $request->couleur,
                    'finition' => $request->finition,
                    'produit_id' => $produit->id
                ]);
            }

            if ($request->type === 'Accessoire') {
                Accessoire::create([
                    'categorie' => $request->categorie,
                    'compatibilite' => $request->compatibilite,
                    'produit_id' => $produit->id
                ]);
            }

            return response()->json([
                'message' => 'Produit créé avec succès',
                'data' => $produit->load(['profile', 'accessoire', 'categorie'])
            ], 201);
        });
    }

    /**
     * Afficher un produit
     */
    public function show($id)
    {
        $produit = Produit::with(['profile', 'accessoire', 'categorie'])->find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Produit récupéré avec succès',
            'data' => $produit
        ], 200);
    }

    /**
     * Suppression d’un produit
     */
    public function destroy($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable'
            ], 404);
        }

        $produit->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès'
        ], 200);
    }
}
