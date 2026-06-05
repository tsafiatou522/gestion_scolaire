<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Matiere;
use App\Services\MoyenneService;
use App\Services\PdfService;
use Illuminate\Http\Request;
use App\Models\Activity;

class NoteController extends Controller
{
    public function __construct(
        private MoyenneService $moyenneService,
        private PdfService $pdfService
    ) {}

    /**
     * Retourne le maximum des notes selon le niveau de classe.
     * CP1 à CE2 : 10
     * CM1 à CM2 : 20
     */
    private function getNoteMax(string $niveau): int
    {
        return in_array($niveau, ['CP1', 'CP2', 'CE1', 'CE2']) ? 10 : 20;
    }

    /**
     * Affiche la grille de saisie des notes par classe et trimestre.
     */
    public function grilleSaisie(Request $request)
    {
        $classes       = Classe::all();
        $classeId      = $request->get('classe_id') ? (int) $request->get('classe_id') : null;
        $trimestre     = (int) $request->get('trimestre', 1);
        $anneeScolaire = $request->get('annee_scolaire', date('Y') . '-' . (date('Y') + 1));

        $eleves   = collect();
        $matieres = collect();
        $notes    = [];
        $noteMax  = null;
        $niveau   = null;

        if ($classeId) {
            $classe   = Classe::with(['eleves', 'matieres'])->findOrFail($classeId);
            $eleves   = $classe->eleves;
            $matieres = $classe->matieres;
            $niveau   = $classe->niveau;
            $noteMax  = $this->getNoteMax($classe->niveau);

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
            'eleves', 'matieres', 'notes', 'noteMax', 'niveau'
        ));
    }

    /**
     * Enregistre toute la grille de notes d'un coup.
     */
    public function enregistrerGrille(Request $request)
    {
        $classe = Classe::findOrFail($request->classe_id);
        $noteMax = $this->getNoteMax($classe->niveau);

        $request->validate([
            'classe_id'      => 'required|exists:classes,id',
            'trimestre'      => 'required|in:1,2,3',
            'annee_scolaire' => 'required|string',
            'notes'          => 'required|array',
            'notes.*.*'      => "nullable|numeric|min:0|max:{$noteMax}",
        ], [
            'notes.*.*' => "La note doit être entre 0 et {$noteMax}.",
        ]);

        $trimestre     = (int) $request->trimestre;
        $anneeScolaire = $request->annee_scolaire;

        foreach ($request->notes as $eleveId => $matieres) {
            foreach ($matieres as $matiereId => $valeur) {
                if ($valeur === null || $valeur === '') continue;

                Note::updateOrCreate(
                    [
                        'eleve_id'       => (int) $eleveId,
                        'matiere_id'     => (int) $matiereId,
                        'trimestre'      => $trimestre,
                        'annee_scolaire' => $anneeScolaire,
                    ],
                    ['note' => $valeur]
                );

                // Journalisation
                $eleve   = Eleve::find((int) $eleveId);
                $matiere = Matiere::find((int) $matiereId);

                if ($eleve && $matiere) {
                    Activity::create([
                        'action'  => 'Note enregistrée',
                        'details' => "Élève: {$eleve->nom}, Matière: {$matiere->nom}, Note: {$valeur}, Trimestre: {$trimestre}, Année: {$anneeScolaire}",
                        'user_id' => auth()->id(),
                    ]);
                }
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
        $classeId      = $request->get('classe_id') ? (int) $request->get('classe_id') : null;
        $trimestre     = (int) $request->get('trimestre', 1);
        $anneeScolaire = $request->get('annee_scolaire', date('Y') . '-' . (date('Y') + 1));

        if (!$classeId) {
            return redirect()->route('notes.grille')
                ->with('error', 'Veuillez sélectionner une classe.');
        }

        $classe     = Classe::with('eleves')->findOrFail($classeId);
        $classement = $this->moyenneService->classementClasse($classe, $trimestre, $anneeScolaire);

        return view('notes.classement', compact('classe', 'classement', 'trimestre', 'anneeScolaire'));
    }

    /**
     * Génère et télécharge le bulletin d'un élève.
     */
    public function bulletin(Eleve $eleve, int $trimestre, string $anneeScolaire)
    {
        $chemin = $this->pdfService->genererBulletin($eleve, $trimestre, $anneeScolaire);

        Activity::create([
            'action'  => 'Bulletin généré',
            'details' => "Élève: {$eleve->nom}, Trimestre: {$trimestre}, Année: {$anneeScolaire}",
            'user_id' => auth()->id(),
        ]);

        return \Storage::disk('public')->download($chemin);
    }
}