<?php

namespace App\Services;

use App\Models\Eleve;

class PaiementService
{
    /**
     * Retourne le total versé par un élève.
     */
    public function totalVerse(Eleve $eleve): float
    {
        return (float) $eleve->paiements()->sum('montant_verse');
    }

    /**
     * Retourne le montant des frais de scolarité de l'élève.
     */
    public function montantDu(Eleve $eleve): float
    {
        return (float) ($eleve->classe?->fraisScolarite?->montant ?? 0);
    }

    /**
     * Retourne le reste à payer (jamais négatif).
     */
    public function resteAPayer(Eleve $eleve): float
    {
        return max(0, $this->montantDu($eleve) - $this->totalVerse($eleve));
    }

    /**
     * Vérifie si l'élève est en retard (reste > 0).
     */
    public function estImpaye(Eleve $eleve): bool
    {
        return $this->resteAPayer($eleve) > 0;
    }

    /**
     * Retourne la liste des élèves impayés d'une collection.
     */
    public function elevesImpayes(iterable $eleves): array
    {
        return collect($eleves)
            ->filter(fn($e) => $this->estImpaye($e))
            ->values()
            ->toArray();
    }
}
