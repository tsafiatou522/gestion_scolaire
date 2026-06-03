<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Matiere;
use App\Services\MoyenneService;
use App\Services\PdfService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct(
        private MoyenneService $moyenneService,
        private PdfService $pdfService
    ) {}

    /**
     * Affiche la grille de saisie des notes par classe et trimestre.
     */
    public function grilleSaisie(Request $request)
    {
        $classes = Classe::all();
        $classeId    = $request->get('classe_id');
        $trimestre   = $request->get('trimestre', 1);
        $anneeScolaire = $request->get('annee_scolaire', date('Y') . '-' . (date('Y') + 1));

        $eleves   = [];
        $matieres = [];
        $notes    = [];

        if ($classeId) {
            $classe   = Classe::with(['eleves', 'matieres'])->findOrFail($classeId);
            $eleves   = $classe->eleves;
            $matieres = $classe->matieres;

            // Récupérer toutes les notes existantes indexées par [eleve_id][matiere_id]
            $notesExistantes = Note::where('trimestre', $trimestre)
                ->where('annee_scolaire', $anneeScolaire)
                ->whereIn('eleve_id', $eleves->pluck('id'))
                ->get();

            foreach ($notesExistantes as $note) {
                $notes[$note->eleve_id][$note->matiere_id] = $note->note;
            }
        }

        return view('notes.grille', compact(
            'classes', 'classeId', 'trimestre', 'anneeScolaire',
            'eleves', 'matieres', 'notes'
        ));
    }

    /**
     * Enregistre toute la grille de notes d'un coup.
     */
    public function enregistrerGrille(Request $request)
    {
        $request->validate([
            'classe_id'      => 'required|exists:classes,id',
            'trimestre'      => 'required|in:1,2,3',
            'annee_scolaire' => 'required|string',
            'notes'          => 'required|array',
            'notes.*.*'      => 'nullable|numeric|min:0|max:20',
        ]);

        $trimestre     = $request->trimestre;
        $anneeScolaire = $request->annee_scolaire;

        foreach ($request->notes as $eleveId => $matieres) {
            foreach ($matieres as $matiereId => $valeur) {
                if ($valeur === null || $valeur === '') continue;

                Note::updateOrCreate(
                    [
                        'eleve_id'       => $eleveId,
                        'matiere_id'     => $matiereId,
                        'trimestre'      => $trimestre,
                        'annee_scolaire' => $anneeScolaire,
                    ],
                    ['note' => $valeur]
                );
            }
        }

        return redirect()
            ->route('notes.classement', [
                'classe_id'      => $request->classe_id,
                'trimestre'      => $trimestre,
                'annee_scolaire' => $anneeScolaire,
            ])
            ->with('success', 'Notes enregistrées avec succès.');
    }

    /**
     * Affiche le classement d'une classe pour un trimestre.
     */
    public function classement(Request $request)
    {
        $classeId      = $request->get('classe_id');
        $trimestre     = $request->get('trimestre', 1);
        $anneeScolaire = $request->get('annee_scolaire', date('Y') . '-' . (date('Y') + 1));

        $classe      = Classe::with('eleves')->findOrFail($classeId);
        $classement  = $this->moyenneService->classementClasse($classe, $trimestre, $anneeScolaire);

        return view('notes.classement', compact('classe', 'classement', 'trimestre', 'anneeScolaire'));
    }

    /**
     * Génère et télécharge le bulletin d'un élève.
     */
    public function bulletin(Eleve $eleve, int $trimestre, string $anneeScolaire)
    {
        $chemin = $this->pdfService->genererBulletin($eleve, $trimestre, $anneeScolaire);
        return \Storage::disk('public')->download($chemin);
    }
}
