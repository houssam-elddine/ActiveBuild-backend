<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\LigneDevis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DevisController extends Controller
{
    /**
     * Liste des devis
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste des devis récupérée avec succès',
            'data' => Devis::with(['client', 'lignes.produit'])->get()
        ], 200);
    }

    /**
     * Création d’un devis (creerDemandeDevis)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'lignes' => 'required|array|min:1',
            'lignes.*.produit_id' => 'required|exists:produits,id',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prixUnitaire' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        return DB::transaction(function () use ($request) {

            $devis = Devis::create([
                'numeroDevis' => 'DEV-' . time(),
                'dateCreation' => now(),
                'statut' => 'brouillon',
                'montantHT' => 0,
                'client_id' => $request->client_id,
            ]);

            $total = 0;

            foreach ($request->lignes as $ligne) {
                $ligneDevis = LigneDevis::create([
                    'devis_id' => $devis->id,
                    'produit_id' => $ligne['produit_id'],
                    'quantite' => $ligne['quantite'],
                    'prixUnitaire' => $ligne['prixUnitaire'],
                ]);

                $total += $ligneDevis->calculerSousTotal();
            }

            $devis->update(['montantHT' => $total]);

            return response()->json([
                'message' => 'Devis créé avec succès',
                'data' => $devis->load(['client', 'lignes.produit'])
            ], 201);
        });
    }

    /**
     * Afficher un devis
     */
    public function show($id)
    {
        $devis = Devis::with(['client', 'lignes.produit'])->find($id);

        if (!$devis) {
            return response()->json([
                'message' => 'Devis introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Devis récupéré avec succès',
            'data' => $devis
        ], 200);
    }
}
