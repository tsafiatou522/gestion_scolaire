<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use App\Services\PaiementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;
use Barryvdh\DomPDF\Facade\Pdf;

class EleveController extends Controller
{
    public function __construct(private PaiementService $paiementService) {}

    public function index(Request $request)
    {
        $classeId = $request->get('classe_id');
        $query    = Eleve::with('classe')->orderBy('nom');

        if ($classeId) {
            $query->where('classe_id', $classeId);
        }

        $eleves  = $query->paginate(20);
        $classes = Classe::all();

        return view('eleves.index', compact('eleves', 'classes', 'classeId'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('eleves.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'              => 'required|string|max:100',
            'prenom'           => 'required|string|max:100',
            'date_naissance'   => 'required|date',
            'sexe'             => 'required|in:M,F',
            'classe_id'        => 'required|exists:classes,id',
            'nom_parent'       => 'nullable|string|max:100',
            'telephone_parent' => 'nullable|string|max:20',
            'photo'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $eleve = Eleve::create($data);

        

        Activity::create([
            'action'  => 'Élève inscrit',
            'details' => "Nom: {$eleve->nom}, Classe: {$eleve->classe->nom}",
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('eleves.index')
                         ->with('success', 'Élève inscrit avec succès.');
    }

    public function show(Eleve $eleve)
    {
        $eleve->load('classe', 'paiements', 'notes.matiere');
        $resteAPayer = $this->paiementService->resteAPayer($eleve);
        $totalVerse  = $this->paiementService->totalVerse($eleve);
        $montantDu   = $this->paiementService->montantDu($eleve);

        return view('eleves.show', compact('eleve', 'resteAPayer', 'totalVerse', 'montantDu'));
    }

    public function edit(Eleve $eleve)
    {
        $classes = Classe::all();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    public function update(Request $request, Eleve $eleve)
    {
        $data = $request->validate([
            'nom'              => 'required|string|max:100',
            'prenom'           => 'required|string|max:100',
            'date_naissance'   => 'required|date',
            'sexe'             => 'required|in:M,F',
            'classe_id'        => 'required|exists:classes,id',
            'nom_parent'       => 'nullable|string|max:100',
            'telephone_parent' => 'nullable|string|max:20',
            'photo'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($eleve->photo) {
                Storage::disk('public')->delete($eleve->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $eleve->update($data);

        Activity::create([
            'action'  => 'Élève modifié',
            'details' => "Nom: {$eleve->nom}, Classe: {$eleve->classe->nom}",
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('eleves.index')->with('success', 'Élève mis à jour.');
    }

    public function destroy(Eleve $eleve)
    {
        $eleve->load('classe');

        Activity::create([
            'action'  => 'Élève supprimé',
            'details' => "Nom: {$eleve->nom}, Classe: " . ($eleve->classe?->nom ?? 'Non attribuée'),
            'user_id' => auth()->id(),
        ]);

        $eleve->delete();

        return redirect()->route('eleves.index')
                         ->with('success', 'Élève supprimé avec succès.');
    }
    public function carte(Eleve $eleve)
{
    $eleve->load('classe');

    return view('eleves.carte', compact('eleve'));
}


public function imprimerCarte(Eleve $eleve)
{
    $eleve->load('classe');

    $pdf = Pdf::loadView('eleves.carte', compact('eleve'));

    return $pdf->download('carte-scolaire-'.$eleve->id.'.pdf');
}
}

