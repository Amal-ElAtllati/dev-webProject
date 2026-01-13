<?php
// ================================================
// MIGRATION CORRIGÉE
// Remplace le contenu de la migration créée
// ================================================

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
        Schema::table('reservations', function (Blueprint $table) {
            // Utiliser 'statut' au lieu de 'status'
            $table->text('justification_refus')->nullable()->after('statut');
            $table->text('notes_planification')->nullable()->after('justification_refus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['justification_refus', 'notes_planification']);
        });
    }
};
