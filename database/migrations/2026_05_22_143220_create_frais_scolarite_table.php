<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('frais_scolarite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->string('annee_scolaire'); // ex: 2025-2026
            $table->timestamps();

            $table->unique(['classe_id', 'annee_scolaire']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frais_scolarite');
    }
};
