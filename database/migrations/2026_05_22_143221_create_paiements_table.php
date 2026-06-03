<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');
            $table->decimal('montant_verse', 10, 2); // On garde montant_verse si tes contrôleurs l'utilisent
            $table->date('date_paiement');
            $table->string('mode')->nullable(); // Espèces, Mobile Money, etc.
            $table->string('recu_pdf')->nullable(); 
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};