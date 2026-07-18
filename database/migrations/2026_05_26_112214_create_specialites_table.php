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
        Schema::create('specialites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hopital_id')                 // à quel hôpital elle appartient
              ->constrained()
              ->onDelete('cascade');
            $table->string('nom');                          // ex: "Cardiologie", "Maternité", "Chirurgie"
            $table->boolean('disponible')->default(true);   // ce département fonctionne-t-il actuellement ?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialites');
    }
};
