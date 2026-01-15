<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Liste des clients
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste des clients récupérée avec succès',
            'data' => Client::all()
        ], 200);
    }

    /**
     * Création d’un client
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codeClient' => 'required|string|unique:clients,codeClient',
            'type'       => 'required|string',
            'nom'        => 'required|string',
            'adresse'    => 'required|string',
        ], [
            'codeClient.required' => 'Le code client est obligatoire.',
            'codeClient.unique'   => 'Ce code client existe déjà.',
            'type.required'       => 'Le type du client est obligatoire.',
            'nom.required'        => 'Le nom du client est obligatoire.',
            'adresse.required'    => 'L’adresse est obligatoire.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors'  => $validator->errors()
            ], 422);
        }

        $client = Client::create($request->all());

        return response()->json([
            'message' => 'Client créé avec succès',
            'data'    => $client
        ], 201);
    }

    /**
     * Afficher un client
     */
    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Client introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Client récupéré avec succès',
            'data'    => $client
        ], 200);
    }

    /**
     * Mise à jour d’un client
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Client introuvable'
            ], 404);
        }

        $client->update($request->all());

        return response()->json([
            'message' => 'Client mis à jour avec succès',
            'data'    => $client
        ], 200);
    }

    /**
     * Suppression d’un client
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Client introuvable'
            ], 404);
        }

        $client->delete();

        return response()->json([
            'message' => 'Client supprimé avec succès'
        ], 200);
    }
}
