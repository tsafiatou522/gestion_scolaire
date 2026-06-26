<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Eleve;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    /**
     * Verifie que l'eleve appartient bien au parent connecte
     */
    private function getEleveOuEchec(Request $request, int $eleveId): Eleve
    {
        $eleve = $request->user()->eleves()->where('eleves.id', $eleveId)->first();

        abort_if(!$eleve, 403, 'Cet eleve ne vous est pas rattache.');

        return $eleve;
    }

    /**
     * Liste des enfants du parent connecte
     */
    public function mesEnfants(Request $request)
    {
        $eleves = $request->user()->eleves()->with('classe')->get();

        return response()->json(
            $eleves->map(fn($eleve) => [
                'id' => $eleve->id,
                'nom_complet' => $eleve->nom_complet,
                'photo' => $eleve->photo,
                'classe' => $eleve->classe?->nom,
            ])
        );
    }

    /**
     * Tableau de bord d'un eleve : infos de base, moyenne generale, rang
     */
    public function dashboard(Request $request, int $eleveId)
    {
        $eleve = $this->getEleveOuEchec($request, $eleveId);
        $eleve->load('classe', 'notes.matiere');

        $moyenneGenerale = $this->calculerMoyenneGenerale($eleve);
        $rang = $this->calculerRang($eleve);

        $dernieresNotes = $eleve->notes()
            ->with('matiere')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($note) => [
                'matiere' => $note->matiere?->nom,
                'note' => $note->note,
                'note_max' => $note->getNoteMax(),
                'trimestre' => $note->trimestre,
            ]);

        return response()->json([
            'id' => $eleve->id,
            'nom' => $eleve->nom,
            'prenom' => $eleve->prenom,
            'photo' => $eleve->photo,
            'classe' => $eleve->classe?->nom,
            'moyenne_generale' => $moyenneGenerale,
            'rang' => $rang,
            'dernieres_notes' => $dernieresNotes,
        ]);
    }

    /**
     * Liste des notes par matiere avec moyennes trimestrielles
     */
    public function notes(Request $request, int $eleveId)
    {
        $eleve = $this->getEleveOuEchec($request, $eleveId);

        $notes = $eleve->notes()->with('matiere')->get();

        $parMatiere = $notes->groupBy(fn($note) => $note->matiere?->nom ?? 'Sans matiere');

        $resultat = $parMatiere->map(function ($notesMatiere, $matiere) {
            $parTrimestre = $notesMatiere->groupBy('trimestre')->map(function ($notesTrimestre) {
                return [
                    'notes' => $notesTrimestre->map(fn($n) => [
                        'note' => $n->note,
                        'note_max' => $n->getNoteMax(),
                    ]),
                    'moyenne' => round($notesTrimestre->avg('note'), 2),
                ];
            });

            return [
                'matiere' => $matiere,
                'trimestres' => $parTrimestre,
            ];
        })->values();

        return response()->json($resultat);
    }

    /**
     * Historique des paiements, montant total, reste a payer
     */
    public function paiements(Request $request, int $eleveId)
    {
        $eleve = $this->getEleveOuEchec($request, $eleveId);
        $eleve->load('paiements', 'classe.fraisScolarite');

        $historique = $eleve->paiements->map(fn($p) => [
            'id' => $p->id,
            'montant_verse' => $p->montant_verse,
            'date_paiement' => $p->date_paiement?->format('Y-m-d'),
            'recu_pdf' => $p->recu_pdf,
            'observation' => $p->observation,
        ]);

        return response()->json([
            'montant_total_du' => $eleve->montant_du,
            'montant_total_verse' => $eleve->total_verse,
            'reste_a_payer' => $eleve->reste_a_payer,
            'statut' => $eleve->statut_paiement,
            'historique' => $historique,
        ]);
    }

    /**
     * Liste des absences de l'eleve
     */
    public function absences(Request $request, int $eleveId)
    {
        $eleve = $this->getEleveOuEchec($request, $eleveId);

        $absences = $eleve->absences()
            ->orderByDesc('date_absence')
            ->get()
            ->map(fn($a) => [
                'date' => $a->date_absence?->format('Y-m-d'),
                'motif' => $a->motif,
                'justifiee' => $a->justifiee,
            ]);

        return response()->json($absences);
    }

    /**
     * Liste des annonces de l'ecole
     */
    public function annonces(Request $request)
    {
        $annonces = Annonce::orderByDesc('date_annonce')->get()->map(fn($a) => [
            'titre' => $a->titre,
            'contenu' => $a->contenu,
            'type' => $a->type,
            'date' => $a->date_annonce?->format('Y-m-d'),
        ]);

        return response()->json($annonces);
    }

    /**
     * Calcule la moyenne generale ponderee par coefficient de matiere
     */
    private function calculerMoyenneGenerale(Eleve $eleve): ?float
    {
        $notes = $eleve->notes;

        if ($notes->isEmpty()) {
            return null;
        }

        $totalPondere = 0;
        $totalCoefficients = 0;

        foreach ($notes as $note) {
            $coefficient = $note->matiere?->pivot?->coefficient ?? 1;
            $noteSur20 = ($note->note / $note->getNoteMax()) * 20;

            $totalPondere += $noteSur20 * $coefficient;
            $totalCoefficients += $coefficient;
        }

        return $totalCoefficients > 0 ? round($totalPondere / $totalCoefficients, 2) : null;
    }

    /**
     * Calcule le rang de l'eleve dans sa classe selon la moyenne generale
     */
    private function calculerRang(Eleve $eleve): ?int
    {
        if (!$eleve->classe_id) {
            return null;
        }

        $elevesClasse = Eleve::where('classe_id', $eleve->classe_id)
            ->with('notes.matiere')
            ->get();

        $moyennes = $elevesClasse->map(fn($e) => [
            'id' => $e->id,
            'moyenne' => $this->calculerMoyenneGenerale($e) ?? 0,
        ])->sortByDesc('moyenne')->values();

        $rang = $moyennes->search(fn($item) => $item['id'] === $eleve->id);

        return $rang !== false ? $rang + 1 : null;
    }
}
