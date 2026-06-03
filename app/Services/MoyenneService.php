<?php

namespace App\Services;

use App\Models\Eleve;
use App\Models\Classe;

class MoyenneService
{
    /**
     * Calcule la moyenne trimestrielle d'un élève (pondérée par coefficient).
     */
    public function calculerMoyenne(Eleve $eleve, int $trimestre, string $anneeScolaire): ?float
    {
        $notes = $eleve->notes()
            ->with('matiere')
            ->where('trimestre', $trimestre)
            ->where('annee_scolaire', $anneeScolaire)
            ->get();

        if ($notes->isEmpty()) {
            return null;
        }

        $totalPoints       = 0;
        $totalCoefficients = 0;

        foreach ($notes as $note) {
            $coef               = $note->matiere->coefficient ?? 1;
            $totalPoints       += $note->note * $coef;
            $totalCoefficients += $coef;
        }

        return $totalCoefficients > 0
            ? round($totalPoints / $totalCoefficients, 2)
            : null;
    }

    /**
     * Retourne le classement des élèves d'une classe pour un trimestre donné.
     * Retourne un tableau trié : [['eleve' => ..., 'moyenne' => ...], ...]
     */
    public function classementClasse(Classe $classe, int $trimestre, string $anneeScolaire): array
    {
        $resultats = [];

        foreach ($classe->eleves as $eleve) {
            $moyenne = $this->calculerMoyenne($eleve, $trimestre, $anneeScolaire);
            $resultats[] = [
                'eleve'   => $eleve,
                'moyenne' => $moyenne ?? 0,
            ];
        }

        // Tri décroissant par moyenne
        usort($resultats, fn($a, $b) => $b['moyenne'] <=> $a['moyenne']);

        // Ajout du rang
        foreach ($resultats as $rang => &$item) {
            $item['rang'] = $rang + 1;
        }

        return $resultats;
    }

    /**
     * Calcule la moyenne générale annuelle d'un élève (moyenne des 3 trimestres).
     */
    public function moyenneAnnuelle(Eleve $eleve, string $anneeScolaire): ?float
    {
        $moyennes = [];
        for ($t = 1; $t <= 3; $t++) {
            $m = $this->calculerMoyenne($eleve, $t, $anneeScolaire);
            if ($m !== null) {
                $moyennes[] = $m;
            }
        }

        return count($moyennes) > 0
            ? round(array_sum($moyennes) / count($moyennes), 2)
            : null;
    }
}
