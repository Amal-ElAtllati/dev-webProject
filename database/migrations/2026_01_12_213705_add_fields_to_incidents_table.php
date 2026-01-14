<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Ajouter les nouvelles colonnes
            $table->foreignId('resource_id')->after('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->after('resource_id')->constrained()->onDelete('set null');
            
            $table->enum('type', ['panne', 'dysfonctionnement', 'dommage', 'autre'])->default('autre')->after('reservation_id');
            $table->enum('priorite', ['basse', 'moyenne', 'haute', 'urgente'])->default('moyenne')->after('type');
            $table->string('titre')->nullable()->after('priorite');
            $table->json('fichiers')->nullable()->after('description');
            
            $table->enum('statut', ['ouvert', 'en_cours', 'resolu', 'ferme'])->default('ouvert')->after('fichiers');
            $table->text('reponse_admin')->nullable()->after('statut');
            $table->timestamp('date_signalement')->useCurrent()->after('reponse_admin');
            $table->timestamp('date_resolution')->nullable()->after('date_signalement');
        });
        
        // Copier les données de 'title' vers 'titre' si des incidents existent
        if (Schema::hasColumn('incidents', 'title')) {
            DB::statement('UPDATE incidents SET titre = title WHERE titre IS NULL');
            
            // Supprimer l'ancienne colonne 'title'
            Schema::table('incidents', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Recréer 'title'
            $table->string('title')->nullable();
        });
        
        // Copier les données de 'titre' vers 'title'
        DB::statement('UPDATE incidents SET title = titre WHERE title IS NULL');
        
        Schema::table('incidents', function (Blueprint $table) {
            // Supprimer les foreign keys
            $table->dropForeign(['resource_id']);
            $table->dropForeign(['reservation_id']);
            
            // Supprimer les colonnes
            $table->dropColumn([
                'resource_id',
                'reservation_id',
                'type',
                'priorite',
                'titre',
                'fichiers',
                'statut',
                'reponse_admin',
                'date_signalement',
                'date_resolution'
            ]);
        });
    }
};