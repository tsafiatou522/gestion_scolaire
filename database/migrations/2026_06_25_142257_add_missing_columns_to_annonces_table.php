<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->string('titre')->after('id');
            $table->text('contenu')->after('titre');
            $table->string('type')->default('general')->after('contenu');
            $table->date('date_annonce')->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn(['titre', 'contenu', 'type', 'date_annonce']);
        });
    }
};
