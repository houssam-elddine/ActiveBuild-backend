<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('reference')->unique();
            $table->string('type'); 
            $table->string('designation');
            $table->float('prixUnitaire');
            $table->integer('stockDisponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
