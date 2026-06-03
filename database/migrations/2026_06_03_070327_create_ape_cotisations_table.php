<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ape_cotisations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('eleve_id')->constrained()->onDelete('cascade');
    $table->integer('montant');
    $table->date('date_paiement');
    $table->string('annee_scolaire');
    $table->string('observation')->nullable();
    $table->string('recu_pdf')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('ape_cotisations');
    }
};