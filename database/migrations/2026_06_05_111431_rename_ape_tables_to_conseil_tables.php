<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename("ape_membres", "bureau_executif");
        Schema::rename("ape_cotisations", "cotisations_conseil");

        Schema::create("assemblee_generale", function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("prenom");
            $table->string("role")->default("membre");
            $table->string("telephone")->nullable();
            $table->string("email")->nullable();
            $table->string("categorie")->default("parent");
            $table->timestamps();
        });

        Schema::create("comite_controle", function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("prenom");
            $table->string("fonction");
            $table->string("telephone")->nullable();
            $table->date("date_debut")->nullable();
            $table->date("date_fin")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::rename("bureau_executif", "ape_membres");
        Schema::rename("cotisations_conseil", "ape_cotisations");
        Schema::dropIfExists("assemblee_generale");
        Schema::dropIfExists("comite_controle");
    }
};
