<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\FraisScolarite;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount('eleves')->with('fraisScolarite')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'           => 'required|string|max:50',
            'niveau'        => 'required|in:CP1,CP2,CE1,CE2,CM1,CM2',
            'annee_scolaire'=> 'required|string|max:10',
            'montant_frais' => 'required|numeric|min:0',
        ]);

        $classe = Classe::create([
            'nom'            => $data['nom'],
            'niveau'         => $data['niveau'],
            'annee_scolaire' => $data['annee_scolaire'],
        ]);

        FraisScolarite::create([
            'classe_id'      => $classe->id,
            'montant'        => $data['montant_frais'],
            'annee_scolaire' => $data['annee_scolaire'],
        ]);

        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
    }

    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    public function update(Request $request, Classe $classe)
    {
        $data = $request->validate([
            'nom'           => 'required|string|max:50',
            'montant_frais' => 'required|numeric|min:0',
        ]);

        $classe->update(['nom' => $data['nom']]);

        $classe->fraisScolarite()->updateOrCreate(
            ['annee_scolaire' => $classe->annee_scolaire],
            ['montant' => $data['montant_frais']]
        );

        return redirect()->route('classes.index')->with('success', 'Classe mise à jour.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée.');
    }
}
