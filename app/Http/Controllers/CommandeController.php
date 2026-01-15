<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Devis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * transformerEnCommande()
     */
    public function store($devisId)
    {
        $devis = Devis::with('lignes')->find($devisId);

        if (!$devis) {
            return response()->json([
                'message' => 'Devis introuvable'
            ], 404);
        }

        if ($devis->statut === 'transformé') {
            return response()->json([
                'message' => 'Ce devis est déjà transformé en commande'
            ], 400);
        }

        return DB::transaction(function () use ($devis) {

            $commande = Commande::create([
                'numeroCommande' => 'CMD-' . time(),
                'dateCommande' => now(),
                'statut' => 'en cours',
                'devis_id' => $devis->id,
            ]);

            $devis->update(['statut' => 'transformé']);

            return response()->json([
                'message' => 'Commande créée avec succès',
                'data' => $commande->load('devis.lignes.produit')
            ], 201);
        });
    }
}
