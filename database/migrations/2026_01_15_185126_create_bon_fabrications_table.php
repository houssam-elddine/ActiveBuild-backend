<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bon_fabrications', function (Blueprint $table) {
            $table->id();
            $table->string('numeroBF')->unique();
            $table->date('dateFabrication');
            $table->string('etat'); // en attente, en fabrication, terminé
            $table->json('etapes');

            $table->foreignId('commande_id')
                  ->constrained('commandes')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bon_fabrications');
    }
};
