<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Eleve;
use App\Services\PaiementService;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;


class PaiementController extends Controller
{
    public function __construct(
        private PaiementService $paiementService,
        private PdfService $pdfService
    ) {}

    public function index(Request $request)
    {
        $eleveId = $request->get('eleve_id');
        $query   = Paiement::with('eleve.classe')->orderByDesc('date_paiement');

        if ($eleveId) {
            $query->where('eleve_id', $eleveId);
        }

        $paiements = $query->paginate(20);
        $eleves    = Eleve::orderBy('nom')->get();

        return view('paiements.index', compact('paiements', 'eleves', 'eleveId'));
    }

    public function create(Request $request)
    {
        $eleves = Eleve::with('classe')->orderBy('nom')->get();
        $eleveId = $request->get('eleve_id');
        return view('paiements.create', compact('eleves', 'eleveId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'eleve_id'       => 'required|exists:eleves,id',
            'montant_verse'  => 'required|numeric|min:1',
            'date_paiement'  => 'required|date',
            'observation'    => 'nullable|string|max:255',
        ]);

        $paiement = Paiement::create($data);

        // Génération automatique du reçu PDF
        $cheminPdf = $this->pdfService->genererRecuPaiement($paiement);
        $paiement->update(['recu_pdf' => $cheminPdf]);
        
Activity::create([
    'action'  => 'Paiement enregistré',
    'details' => "Élève: {$paiement->eleve->nom}, Montant: {$paiement->montant_verse}",
    'user_id' => auth()->id(),
]);

        return redirect()
            ->route('paiements.show', $paiement)
            ->with('success', 'Paiement enregistré. Reçu généré.');
    }

    public function show(Paiement $paiement)
    {
        $paiement->load('eleve.classe.fraisScolarite');
        $eleve       = $paiement->eleve;
        $totalVerse  = $this->paiementService->totalVerse($eleve);
        $resteAPayer = $this->paiementService->resteAPayer($eleve);

        return view('paiements.show', compact('paiement', 'totalVerse', 'resteAPayer'));
    }

    public function telechargerRecu(Paiement $paiement)
    {
        if (!$paiement->recu_pdf || !Storage::disk('public')->exists($paiement->recu_pdf)) {
            // Régénérer si le fichier est manquant
            $cheminPdf = $this->pdfService->genererRecuPaiement($paiement);
            $paiement->update(['recu_pdf' => $cheminPdf]);
        }

        return Storage::disk('public')->download($paiement->recu_pdf);
    }

    public function destroy(Paiement $paiement)
    {
        if ($paiement->recu_pdf) {
            Storage::disk('public')->delete($paiement->recu_pdf);
        }
        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé.');
    }
    
}
