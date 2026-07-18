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
        Schema::table('lits', function (Blueprint $table) {
            $table->timestamp('dernier_heartbeat')->nullable()->after('derniere_maj');
        });
    }

    public function down(): void
    {
        Schema::table('lits', function (Blueprint $table) {
            $table->dropColumn('dernier_heartbeat');
        });
    }
};
