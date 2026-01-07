<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->integer('cpu');
            $table->integer('ram');
            $table->integer('capacite');
            $table->string('os');
            $table->string('etat')->default('disponible');
            $table->string('emplacement')->nullable();
            $table->foreignId('categorie_id')->constrained('resource_categories')->onDelete('cascade');
            $table->foreignId('responsable_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('resources');
    }
};
