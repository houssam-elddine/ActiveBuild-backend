<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BonFabricationController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/produits', [ProduitController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/devis', [DevisController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/admin/devis', [DevisController::class, 'index']);
    Route::get('/admin/devis/{devis}', [DevisController::class, 'show']);
    Route::put('/admin/devis/{devis}', [DevisController::class, 'update']);
    Route::delete('/admin/devis/{devis}', [DevisController::class, 'destroy']);
    Route::get('/admin/devis/{devis}/pdf', [DevisController::class, 'genererPdf']);
    Route::post('/admin/devis/{devis}/confirmer', [DevisController::class, 'confirmer']);

    Route::get(
        '/admin/bon-fabrication/{bon}/pdf',
        [BonFabricationController::class, 'pdf']
    );

    Route::apiResource('admin/categories', CategoryController::class);
    Route::apiResource('admin/produits', ProduitController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
