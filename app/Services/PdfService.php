<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\Eleve;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Génère le reçu PDF d'un paiement et retourne le chemin du fichier.
     */
    public function genererRecuPaiement(Paiement $paiement): string
    {
        $eleve           = $paiement->eleve->load('classe.fraisScolarite');
        $paiementService = app(PaiementService::class);

        $data = [
            'paiement'    => $paiement,
            'eleve'       => $eleve,
            'total_verse' => $paiementService->totalVerse($eleve),
            'montant_du'  => $paiementService->montantDu($eleve),
            'reste'       => $paiementService->resteAPayer($eleve),
        ];

        $pdf      = Pdf::loadView('pdf.recu_paiement', $data);
        $filename = 'recus/recu_paiement_' . $paiement->id . '_' . now()->format('Ymd') . '.pdf';

        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Génère le bulletin de notes d'un élève pour un trimestre.
     */
    public function genererBulletin(Eleve $eleve, int $trimestre, string $anneeScolaire): string
    {
        $moyenneService = app(MoyenneService::class);

        // Récupérer les matières de la classe avec coefficient pivot
        $matieresClasse = $eleve->classe->matieres()->get()->keyBy('id');

        $notes = $eleve->notes()
                    ->with('matiere')
                    ->where('trimestre', $trimestre)
                    ->where('annee_scolaire', $anneeScolaire)
                    ->get()
                    ->map(function ($note) use ($matieresClasse) {
                        $note->coefficient = $matieresClasse->get($note->matiere_id)?->pivot->coefficient ?? 1;
                        return $note;
                    });

        $classement = $moyenneService->classementClasse(
            $eleve->classe, $trimestre, $anneeScolaire
        );
        $rang = collect($classement)->firstWhere('eleve.id', $eleve->id)['rang'] ?? '-';

        $data = [
            'eleve'          => $eleve->load('classe'),
            'notes'          => $notes,
            'trimestre'      => $trimestre,
            'annee_scolaire' => $anneeScolaire,
            'moyenne'        => $moyenneService->calculerMoyenne($eleve, $trimestre, $anneeScolaire),
            'rang'           => $rang,
            'effectif'       => $eleve->classe->eleves()->count(),
        ];

        $pdf      = Pdf::loadView('pdf.bulletin', $data);
        $filename = 'bulletins/bulletin_' . $eleve->id . '_T' . $trimestre . '_' . $anneeScolaire . '.pdf';

        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }
}