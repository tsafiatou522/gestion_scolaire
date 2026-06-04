<?php

namespace App\Http\Controllers;

use App\Models\ApeMembre;
use App\Models\ApeCotisation;
use App\Models\Eleve;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ApeController extends Controller
{
    public function __construct(private PdfService $pdfService) {}

    // ===== MEMBRES =====

    public function indexMembres(Request $request)
    {
        $anneeScolaire = $request->get('annee_scolaire', '2025-2026');
        $membres = ApeMembre::with('eleve.classe')
            ->where('annee_scolaire', $anneeScolaire)
            ->orderByRaw("FIELD(fonction, 'president','vice_president','secretaire','tresorier','membre')")
            ->get();

        return view('ape.membres.index', compact('membres', 'anneeScolaire'));
    }

    public function createMembre()
    {
        $eleves = Eleve::with('classe')->orderBy('nom')->get();
        return view('ape.membres.create', compact('eleves'));
    }

    public function storeMembre(Request $request)
    {
        $data = $request->validate([
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'telephone'      => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100',
            'fonction'       => 'required|in:president,vice_president,secretaire,tresorier,membre',
            'eleve_id'       => 'nullable|exists:eleves,id',
            'annee_scolaire' => 'required|string',
        ]);

        ApeMembre::create($data);

        return redirect()->route('membres.index')
            ->with('success', 'Membre APE ajouté avec succès.');
    }

    public function editMembre(ApeMembre $membre)
    {
        $eleves = Eleve::with('classe')->orderBy('nom')->get();
        return view('ape.membres.edit', compact('membre', 'eleves'));
    }

    public function updateMembre(Request $request, ApeMembre $membre)
    {
        $data = $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
            'fonction'  => 'required|in:president,vice_president,secretaire,tresorier,membre',
            'eleve_id'  => 'nullable|exists:eleves,id',
        ]);

        $membre->update($data);

        return redirect()->route('membres.index')
            ->with('success', 'Membre APE mis à jour.');
    }

    public function destroyMembre(ApeMembre $membre)
    {
        $membre->delete();
        return redirect()->route('membres.index')
            ->with('success', 'Membre supprimé.');
    }

    // ===== COTISATIONS =====

    public function indexCotisations(Request $request)
    {
        $anneeScolaire = $request->get('annee_scolaire', '2025-2026');
        $eleveId = $request->get('eleve_id');

        $query = ApeCotisation::with('eleve.classe')
            ->where('annee_scolaire', $anneeScolaire)
            ->orderByDesc('date_paiement');

        if ($eleveId) {
            $query->where('eleve_id', $eleveId);
        }

        $cotisations   = $query->paginate(20);
        $eleves        = Eleve::orderBy('nom')->get();
        $totalCollecte = ApeCotisation::where('annee_scolaire', $anneeScolaire)->sum('montant');

        return view('ape.cotisations.index', compact(
            'cotisations', 'eleves', 'eleveId', 'anneeScolaire', 'totalCollecte'
        ));
    }

    public function createCotisation(Request $request)
    {
        $eleves  = Eleve::with('classe')->orderBy('nom')->get();
        $eleveId = $request->get('eleve_id');
        return view('ape.cotisations.create', compact('eleves', 'eleveId'));
    }

    public function storeCotisation(Request $request)
    {
        $data = $request->validate([
            'eleve_id'       => 'required|exists:eleves,id',
            'montant'        => 'required|numeric|min:1',
            'date_paiement'  => 'required|date',
            'annee_scolaire' => 'required|string',
            'observation'    => 'nullable|string|max:255',
        ]);

        $cotisation = ApeCotisation::create($data);

        // Générer le reçu PDF
        $chemin = $this->genererRecuApePdf($cotisation);
        $cotisation->update(['recu_pdf' => $chemin]);

        return redirect()->route('ape.cotisations.index')
            ->with('success', 'Cotisation APE enregistrée. Reçu généré.');
    }

    public function destroyCotisation(ApeCotisation $cotisation)
    {
        if ($cotisation->recu_pdf) {
            Storage::disk('public')->delete($cotisation->recu_pdf);
        }
        $cotisation->delete();
        return redirect()->route('ape.cotisations.index')
            ->with('success', 'Cotisation supprimée.');
    }

    public function telechargerRecuCotisation(ApeCotisation $cotisation)
    {
        if (!$cotisation->recu_pdf || !Storage::disk('public')->exists($cotisation->recu_pdf)) {
            $chemin = $this->genererRecuApePdf($cotisation);
            $cotisation->update(['recu_pdf' => $chemin]);
        }
        return Storage::disk('public')->download($cotisation->recu_pdf);
    }

    private function genererRecuApePdf(ApeCotisation $cotisation): string
    {
        $cotisation->load('eleve.classe');
        $pdf      = Pdf::loadView('pdf.recu_ape', compact('cotisation'));
        $filename = 'recus_ape/recu_ape_' . $cotisation->id . '_' . now()->format('Ymd') . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());
        return $filename;
    }
}