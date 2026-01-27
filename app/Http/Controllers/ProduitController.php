<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::all();
        return response()->json([
            'status' => 200,
            'produits' => $produits    
        ],200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'img' => 'required|image|max:20480',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $imagePath = $request->file('img')->store('produits', 'public');

        $produit = Produit::create([
            'category_id' => $validatedData['category_id'],
            'img' => $imagePath,
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Produit created successfully',
            'produit' => $produit
        ], 201);
    }

    public function show(Produit $produit)
    {
        return response()->json([
            'status' => 200,
            'produit' => $produit
        ], 200);
    }

    public function update(Request $request, Produit $produit)
    {
        $validatedData = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'img' => 'sometimes|image|max:20480',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
        ]);

        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('produits', 'public');
            $produit->img = $imagePath;
        }

        if (isset($validatedData['category_id'])) {
            $produit->category_id = $validatedData['category_id'];
        }
        if (isset($validatedData['name'])) {
            $produit->name = $validatedData['name'];
        }
        if (isset($validatedData['description'])) {
            $produit->description = $validatedData['description'];
        }
        if (isset($validatedData['price'])) {
            $produit->price = $validatedData['price'];
        }

        $produit->save();

        return response()->json([
            'status' => 200,
            'message' => 'Produit updated successfully',
            'produit' => $produit
        ], 200);
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Produit deleted successfully'
        ], 200);
    }
}
