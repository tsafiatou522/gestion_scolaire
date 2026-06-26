<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('directeur', 'enseignant', 'gestionnaire', 'parent') NOT NULL DEFAULT 'enseignant'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('directeur', 'enseignant', 'gestionnaire') NOT NULL DEFAULT 'enseignant'");
    }
};
