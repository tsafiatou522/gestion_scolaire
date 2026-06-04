<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classe;
use App\Models\FraisScolarite;
use App\Models\Matiere;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
                $matiere = Matiere::firstOrCreate(
                    ['nom' => $nomMatiere]
                );

                $classe->matieres()->syncWithoutDetaching([
                    $matiere->id => [
                        'coefficient' => 1
                    ]
                ]);
            }
        }

        // ==========================================
        //  NOUVEAU : CRÉATION DE QUELQUES ÉLÈVES
        // ==========================================
        if (DB::table('eleves')->count() == 0) {
            DB::table('eleves')->insert([
                ['id' => 1, 'nom' => 'TRAORE', 'prenom' => 'Ahmed', 'date_naissance' => '2016-03-12', 'classe_id' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'nom' => 'OUEDRAOGO', 'prenom' => 'Fatoumata', 'date_naissance' => '2016-07-22', 'classe_id' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'nom' => 'KABORE', 'prenom' => 'Pierre', 'date_naissance' => '2016-01-05', 'classe_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // ==========================================
        //  GENERATION DES DONNÉES APE
        // ==========================================
        
        // 1. Membres du bureau de l'APE
        if (DB::table('ape_membres')->count() == 0) {
            DB::table('ape_membres')->insert([
                [
                    'nom' => 'SAWADOGO',
                    'prenom' => 'Jean-Baptiste',
                    'telephone' => '70000001',
                    'email' => 'jean@ape.bf',
                    'fonction' => 'president',
                    'eleve_id' => null,
                    'annee_scolaire' => $anneeScolaire,
                    'created_at' => now(), 'updated_at' => now()
                ],
                [
                    'nom' => 'OUEDRAOGO',
                    'prenom' => 'Aline',
                    'telephone' => '76000002',
                    'email' => 'aline@ape.bf',
                    'fonction' => 'tresorier',
                    'eleve_id' => null,
                    'annee_scolaire' => $anneeScolaire,
                    'created_at' => now(), 'updated_at' => now()
                ],
                [
                    'nom' => 'SANOU',
                    'prenom' => 'Karim',
                    'telephone' => '72000003',
                    'email' => 'karim@ape.bf',
                    'fonction' => 'secretaire',
                    'eleve_id' => null,
                    'annee_scolaire' => $anneeScolaire,
                    'created_at' => now(), 'updated_at' => now()
                ],
            ]);
        }

        // 2. Cotisations APE 
        if (DB::table('ape_cotisations')->count() == 0) {
            DB::table('ape_cotisations')->insert([
                [
                    'eleve_id' => 1, 
                    'montant' => 5000,
                    'date_paiement' => now()->format('Y-m-d'),
                    'annee_scolaire' => $anneeScolaire,
                    'observation' => 'Paiement intégral reçu',
                    'recu_pdf' => null,
                    'created_at' => now(), 'updated_at' => now()
                ],
                [
                    'eleve_id' => 2, 
                    'montant' => 5000,
                    'date_paiement' => now()->format('Y-m-d'),
                    'annee_scolaire' => $anneeScolaire,
                    'observation' => 'Payé par Chèque',
                    'recu_pdf' => null,
                    'created_at' => now(), 'updated_at' => now()
                ],
                [
                    'eleve_id' => 3, 
                    'montant' => 5000,
                    'date_paiement' => now()->subDays(2)->format('Y-m-d'),
                    'annee_scolaire' => $anneeScolaire,
                    'observation' => 'Avance sur cotisation',
                    'recu_pdf' => null,
                    'created_at' => now(), 'updated_at' => now()
                ],
            ]);
        }

        $this->command->info('Seeder terminé. Admin : admin@ecole.bf / password (et données APE générées !)');
    }
}