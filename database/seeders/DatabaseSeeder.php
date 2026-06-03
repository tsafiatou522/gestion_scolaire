<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classe;
use App\Models\FraisScolarite;
use App\Models\Matiere;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin par défaut
        User::firstOrCreate(
            ['email' => 'admin@ecole.bf'],
            [
                'name'     => 'Administrateur',
                'password' => Hash::make('password'),
                'role'     => 'directeur',
            ]
        );

        $anneeScolaire = '2025-2026';

        // Matières différentes par niveau
        $matiereParNiveau = [
            'CP1' => ['Lecture', 'Écriture', 'Calcul', 'Éveil'],
            'CP2' => ['Lecture', 'Écriture', 'Calcul', 'Éveil'],
            'CE1' => ['Français', 'Mathématiques', 'Sciences', 'Histoire-Géographie', 'Éducation Civique'],
            'CE2' => ['Français', 'Mathématiques', 'Sciences', 'Histoire-Géographie', 'Éducation Civique'],
            'CM1' => ['Français', 'Mathématiques', 'Sciences', 'Histoire-Géographie', 'Éducation Civique', 'Anglais'],
            'CM2' => ['Français', 'Mathématiques', 'Sciences', 'Histoire-Géographie', 'Éducation Civique', 'Anglais'],
        ];

        $niveaux = [
            ['nom' => 'CP1', 'niveau' => 'CP1', 'frais' => 25000],
            ['nom' => 'CP2', 'niveau' => 'CP2', 'frais' => 25000],
            ['nom' => 'CE1', 'niveau' => 'CE1', 'frais' => 30000],
            ['nom' => 'CE2', 'niveau' => 'CE2', 'frais' => 30000],
            ['nom' => 'CM1', 'niveau' => 'CM1', 'frais' => 35000],
            ['nom' => 'CM2', 'niveau' => 'CM2', 'frais' => 35000],
        ];

        foreach ($niveaux as $n) {
            $classe = Classe::firstOrCreate(
                ['nom' => $n['nom'], 'annee_scolaire' => $anneeScolaire],
                ['niveau' => $n['niveau'], 'annee_scolaire' => $anneeScolaire]
            );

            FraisScolarite::firstOrCreate(
                ['classe_id' => $classe->id, 'annee_scolaire' => $anneeScolaire],
                ['montant' => $n['frais']]
            );

            foreach ($matiereParNiveau[$n['niveau']] as $nomMatiere) {
                Matiere::firstOrCreate(
                    ['nom' => $nomMatiere, 'classe_id' => $classe->id],
                    ['coefficient' => 1]
                );
            }
        }

        $this->command->info('Seeder terminé. Admin : admin@ecole.bf / password');
    }
}