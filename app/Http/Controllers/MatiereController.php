<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Models\Activity;

class MatiereController extends Controller
{
    public function index(Request $request)
    {
        $classeId = $request->get('classe_id') ? (int) $request->get('classe_id') : null;
        $classes  = Classe::all();
        $matieres = collect();

        if ($classeId) {
            $classe   = Classe::findOrFail($classeId);
            $matieres = $classe->matieres()->orderBy('nom')->get();
        } else {
            $matieres = Matiere::orderBy('nom')->get();
        }

        return view('matieres.index', compact('classes', 'matieres', 'classeId'));
    }

    public function create(Request $request)
    {
        $classes  = Classe::all();
        $classeId = $request->get('classe_id') ? (int) $request->get('classe_id') : null;
        return view('matieres.create', compact('classes', 'classeId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:100',
            'code'        => 'nullable|string|max:10',
            'classe_id'   => 'required|exists:classes,id',
            'coefficient' => 'required|numeric|min:0.5|max:10',
        ]);

        $classeId    = (int) $data['classe_id'];
        $coefficient = $data['coefficient'];

        // Créer ou retrouver la matière globale
        $matiere = Matiere::firstOrCreate(
            ['nom' => $data['nom']],
            ['code' => $data['code'] ?? null]
        );

        // Attacher à la classe via le pivot (si pas déjà attachée)
        $classe = Classe::findOrFail($classeId);
        if (!$classe->matieres()->where('matiere_id', $matiere->id)->exists()) {
            $classe->matieres()->attach($matiere->id, ['coefficient' => $coefficient]);
        } else {
            // Mettre à jour le coefficient si déjà attachée
            $classe->matieres()->updateExistingPivot($matiere->id, ['coefficient' => $coefficient]);
        }

        Activity::create([
            'action'  => 'Matière créée',
            'details' => "Nom: {$matiere->nom}, Classe ID: {$classeId}, Coefficient: {$coefficient}",
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('matieres.index', ['classe_id' => $classeId])
            ->with('success', 'Matière ajoutée avec succès.');
    }

    public function edit(Matiere $matiere, Request $request)
    {
        $classes  = Classe::all();
        $classeId = $request->get('classe_id') ? (int) $request->get('classe_id') : null;

        // Récupérer le coefficient depuis le pivot
        $coefficient = null;
        if ($classeId) {
            $pivot = $matiere->classes()->where('classe_id', $classeId)->first();
            $coefficient = $pivot ? $pivot->pivot->coefficient : null;
        }

        return view('matieres.edit', compact('matiere', 'classes', 'classeId', 'coefficient'));
    }

    public function update(Request $request, Matiere $matiere)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:100',
            'code'        => 'nullable|string|max:10',
            'classe_id'   => 'required|exists:classes,id',
            'coefficient' => 'required|numeric|min:0.5|max:10',
        ]);

        $classeId    = (int) $data['classe_id'];
        $coefficient = $data['coefficient'];

        // Mettre à jour la matière globale
        $matiere->update([
            'nom'  => $data['nom'],
            'code' => $data['code'] ?? null,
        ]);

        // Mettre à jour le coefficient dans le pivot
        $classe = Classe::findOrFail($classeId);
        $classe->matieres()->updateExistingPivot($matiere->id, ['coefficient' => $coefficient]);

        Activity::create([
            'action'  => 'Matière modifiée',
            'details' => "Nom: {$matiere->nom}, Classe ID: {$classeId}, Coefficient: {$coefficient}",
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('matieres.index', ['classe_id' => $classeId])
            ->with('success', 'Matière mise à jour.');
    }

    public function destroy(Matiere $matiere, Request $request)
    {
        $classeId = $request->get('classe_id') ? (int) $request->get('classe_id') : null;

        Activity::create([
            'action'  => 'Matière supprimée',
            'details' => "Nom: {$matiere->nom}, Classe ID: {$classeId}",
            'user_id' => auth()->id(),
        ]);

        if ($classeId) {
            // Détacher uniquement de cette classe
            $classe = Classe::findOrFail($classeId);
            $classe->matieres()->detach($matiere->id);

            // Supprimer la matière globalement si plus rattachée à aucune classe
            if ($matiere->classes()->count() === 0) {
                $matiere->delete();
            }
        } else {
            // Supprimer complètement
            $matiere->classes()->detach();
            $matiere->delete();
        }

        return redirect()
            ->route('matieres.index', ['classe_id' => $classeId])
            ->with('success', 'Matière supprimée.');
    }
}