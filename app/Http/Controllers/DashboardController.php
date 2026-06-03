<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Paiement;
use App\Models\Note;
use App\Models\User;
use App\Services\PaiementService;
use App\Services\MoyenneService;
use Carbon\Carbon;
use App\Models\ApeCotisation;
use App\Models\ApeMembre;


class DashboardController extends Controller
{
    public function __construct(
        private PaiementService $paiementService,
        private MoyenneService $moyenneService
    ) {}

    public function index()
    {
        $user    = auth()->user();
$classes = Classe::with([
    'eleves.paiements',
    'fraisScolarite'
])->get();
        $totalEleves   = Eleve::count();
        $totalAttendu  = 0;
        $totalCollecte = 0;
        $elevesImpayes = [];

        foreach ($classes as $classe) {
            $frais = $classe->fraisScolarite?->montant ?? 0;
            $totalAttendu += $frais * $classe->eleves->count();

            foreach ($classe->eleves as $eleve) {
                $totalCollecte += $this->paiementService->totalVerse($eleve);
                if ($this->paiementService->estImpaye($eleve)) {
                    $elevesImpayes[] = [
                        'eleve'  => $eleve,
                        'reste'  => $this->paiementService->resteAPayer($eleve),
                        'classe' => $classe->nom,
                    ];
                }
            }
        }

        $tauxRecouvrement = $totalAttendu > 0
            ? round(($totalCollecte / $totalAttendu) * 100, 1)
            : 0;

        $statsClasses = $classes->map(function ($classe) {
            $frais    = $classe->fraisScolarite?->montant ?? 0;
            $attendu  = $frais * $classe->eleves->count();
            $collecte = $classe->eleves->sum(
                fn($e) => $this->paiementService->totalVerse($e)
            );
            return [
                'nom'        => $classe->nom,
                'effectif'   => $classe->eleves->count(),
                'attendu'    => $attendu,
                'collecte'   => $collecte,
                'reste'      => max(0, $attendu - $collecte),
                'nb_impayes' => $classe->eleves->filter(
                    fn($e) => $this->paiementService->estImpaye($e)
                )->count(),
            ];
        });

        // Paiements du jour
        $paiementsAujourdhui = Paiement::with('eleve.classe')
            ->whereDate('date_paiement', Carbon::today())
            ->orderByDesc('created_at')
            ->get();

        $totalAujourdhui = $paiementsAujourdhui->sum('montant_verse');

        // Dernières saisies de notes
        $dernieresNotes = Note::with(['eleve.classe', 'matiere'])
            ->orderByDesc('updated_at')
            ->take(8)
            ->get();

        // Résumé par classe avec moyennes
        $anneeScolaire = '2025-2026';
        $resumeClasses = $classes->map(function ($classe) use ($anneeScolaire) {
            $moyennes = [];
            foreach ($classe->eleves as $eleve) {
                for ($t = 1; $t <= 3; $t++) {
                    $m = $this->moyenneService->calculerMoyenne($eleve, $t, $anneeScolaire);
                    if ($m !== null) $moyennes[] = $m;
                }
            }
            return [
                'nom'            => $classe->nom,
                'effectif'       => $classe->eleves->count(),
                'moyenne_classe' => count($moyennes) > 0
                    ? round(array_sum($moyennes) / count($moyennes), 2)
                    : null,
            ];
        });

        // Activité des enseignants
        $activiteEnseignants = User::where('role', 'enseignant')
            ->get()
            ->map(function ($enseignant) {
                $derniereNote = Note::orderByDesc('updated_at')->first();
                return [
                    'nom'          => $enseignant->name,
                    'email'        => $enseignant->email,
                    'derniere_note'=> $derniereNote?->updated_at,
                ];
            });

        // Données graphique paiements 6 derniers mois
        $moisLabels = [];
        $moisData   = [];

        for ($i = 5; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $moisLabels[] = $mois->format('m/Y');
            /** @var \Carbon\Carbon $mois */
            $moisData[]   = Paiement::whereYear('date_paiement', $mois->year)
                ->whereMonth('date_paiement', $mois->month)
                ->sum('montant_verse');
        }

        // === Ajout APE et Carte scolaire ===
        $totalCotisationsAPE = ApeCotisation::sum('montant');
        $cotisationsRecentes = ApeCotisation::with('eleve')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $totalMembresAPE = ApeMembre::count();
       $totalClasses = $classes->count();
       $totalElevesCarte = $totalEleves;
        return view('dashboard.index', compact(
            'user', 'totalEleves', 'totalAttendu', 'totalCollecte',
            'tauxRecouvrement', 'elevesImpayes', 'statsClasses',
            'paiementsAujourdhui', 'totalAujourdhui',
            'dernieresNotes', 'resumeClasses',
            'activiteEnseignants', 'moisLabels', 'moisData',
            'totalCotisationsAPE', 'cotisationsRecentes', 'totalMembresAPE',
            'totalClasses', 'totalElevesCarte'
        ));
    }
}
