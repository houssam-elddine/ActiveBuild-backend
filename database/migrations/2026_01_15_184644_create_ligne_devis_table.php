<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ligne_devis', function (Blueprint $table) {
            $table->id();
            $table->integer('quantite');
            $table->float('prixUnitaire');

            $table->foreignId('devis_id')
                  ->constrained('devis')
                  ->onDelete('cascade');

            $table->foreignId('produit_id')
                  ->constrained('produits');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ligne_devis');
    }
};
