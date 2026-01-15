<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\BonFabricationController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('devis/{devisId}/commande', [CommandeController::class, 'store']);
Route::post('commande/{commandeId}/bon-fabrication', [BonFabricationController::class, 'store']);
Route::apiResource('clients', ClientController::class);

Route::apiResource('devis', DevisController::class)->only([
    'index', 'store', 'show'
]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('produits', ProduitController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});
