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
        Schema::create('lits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hopital_id')                 // à quel hôpital il appartient
                ->constrained()
                ->onDelete('cascade');
            $table->string('service')->nullable();                      // urgences, maternité, réanimation...
            $table->string('numero');                       // identifiant du lit (ex: "Lit 12")
            $table->string('etat')->default('libre');                      // état actuel du lit
            $table->timestamp('derniere_maj')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lits');
    }
};
