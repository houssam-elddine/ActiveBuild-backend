<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Commande;
use App\Models\BonFabrication;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DevisController extends Controller
{
    public function index()
    {
        $devis = Devis::latest()->get();

        return response()->json([
            'status' => 200,
            'devis' => $devis
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'hauteur'  => 'required|string|max:50',
            'largeur'  => 'required|string|max:50',
            'quantite' => 'required|integer|min:1',
            'type'     => 'required|string|max:100',
        ]);

        $devis = Devis::create([
            'name'     => $validated['name'],
            'phone'    => $validated['phone'],
            'hauteur'  => $validated['hauteur'],
            'largeur'  => $validated['largeur'],
            'quantite' => $validated['quantite'],
            'type'     => $validated['type'],
            'status'   => 'en attente',
        ]);

        return response()->json([
            'status'  => 201,
            'message' => 'Demande de devis envoyée avec succès',
            'devis'   => $devis
        ], 201);
    }

    public function show(Devis $devis)
    {
        return response()->json([
            'status' => 200,
            'devis'  => $devis
        ]);
    }

    public function update(Request $request, Devis $devis)
    {
        $validated = $request->validate([
            'status' => 'required|in:annuler,confirmer',
        ]);

        $devis->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'status'  => 200,
            'message' => 'Statut du devis mis à jour',
            'devis'   => $devis
        ]);
    }

    public function destroy(Devis $devis)
    {
        $devis->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Devis supprimé avec succès'
        ]);
    }

    public function genererPdf(Devis $devis)
    {
        $pdf = Pdf::loadView('pdf.devis', [
            'devis' => $devis
        ]);

        return $pdf->download('devis_'.$devis->id.'.pdf');
    }

    public function confirmer(Devis $devis)
    {
        if ($devis->status !== 'en attente') {
            return response()->json([
                'message' => 'Devis déjà traité'
            ], 400);
        }

        $devis->update([
            'status' => 'confirmer'
        ]);

        $commande = Commande::create([
            'devis_id' => $devis->id,
            'status' => 'en fabrication'
        ]);

        BonFabrication::create([
            'commande_id' => $commande->id,
            'etat' => 'en cours',
            'etapes' => 'Découpe, Assemblage, Vitrage'
        ]);

        return response()->json([
            'message' => 'Commande et bon de fabrication créés',
            'commande' => $commande
        ]);
    }
}
