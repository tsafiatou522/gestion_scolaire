<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. On crée la table 'matieres' (SANS classe_id)
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        // 2. On crée la table pivot 'classe_matiere' juste en dessous
        Schema::create('classe_matiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
            $table->integer('coefficient')->default(1); // Le coefficient va ici, car il dépend du couple classe/matière
            $table->unique(['classe_id', 'matiere_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // On supprime d'abord la table pivot, puis la table principale
        Schema::dropIfExists('classe_matiere');
        Schema::dropIfExists('matieres');
    }
};