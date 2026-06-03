<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ape_membres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->enum('fonction', ['president', 'vice_president', 'secretaire', 'tresorier', 'membre'])->default('membre');
            $table->foreignId('eleve_id')->nullable()->constrained('eleves')->onDelete('set null');
            $table->string('annee_scolaire');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ape_membres');
    }
};
