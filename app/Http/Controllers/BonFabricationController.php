<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\BonFabrication;

class BonFabricationController extends Controller
{
    /**
     * genererBonFabrication()
     */
    public function store($commandeId)
    {
        $commande = Commande::with('devis.lignes.produit')->find($commandeId);

        if (!$commande) {
            return response()->json([
                'message' => 'Commande introuvable'
            ], 404);
        }

        if ($commande->bonFabrication) {
            return response()->json([
                'message' => 'Bon de fabrication déjà généré'
            ], 400);
        }

        $bonFabrication = BonFabrication::create([
            'numeroBF' => 'BF-' . time(),
            'dateFabrication' => now(),
            'etat' => 'en attente',
            'etapes' => [
                'Découpe',
                'Assemblage',
                'Finition',
                'Contrôle qualité'
            ],
            'commande_id' => $commande->id,
        ]);

        return response()->json([
            'message' => 'Bon de fabrication généré avec succès',
            'data' => [
                'bonFabrication' => $bonFabrication,
                'nomenclature' => $bonFabrication->genererNomenclature()
            ]
        ], 201);
    }
}
