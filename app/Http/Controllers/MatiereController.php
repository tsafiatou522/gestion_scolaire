<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index(Request $request)
    {
        $classeId = $request->get('classe_id');
        $classes  = Classe::all();
        $matieres = collect();

        if ($classeId) {
            $matieres = Matiere::where('classe_id', $classeId)
                ->orderBy('nom')
                ->get();
        }

        return view('matieres.index', compact('classes', 'matieres', 'classeId'));
    }

    public function create(Request $request)
    {
        $classes  = Classe::all();
        $classeId = $request->get('classe_id');
        return view('matieres.create', compact('classes', 'classeId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:100',
            'classe_id'   => 'required|exists:classes,id',
            'coefficient' => 'required|numeric|min:0.5|max:10',
        ]);

        Matiere::create($data);

        return redirect()
            ->route('matieres.index', ['classe_id' => $data['classe_id']])
            ->with('success', 'Matière ajoutée avec succès.');
    }

    public function edit(Matiere $matiere)
    {
        $classes = Classe::all();
        return view('matieres.edit', compact('matiere', 'classes'));
    }

    public function update(Request $request, Matiere $matiere)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:100',
            'coefficient' => 'required|numeric|min:0.5|max:10',
        ]);

        $matiere->update($data);

        return redirect()
            ->route('matieres.index', ['classe_id' => $matiere->classe_id])
            ->with('success', 'Matière mise à jour.');
    }

    public function destroy(Matiere $matiere)
    {
        $classeId = $matiere->classe_id;
        $matiere->delete();

        return redirect()
            ->route('matieres.index', ['classe_id' => $classeId])
            ->with('success', 'Matière supprimée.');
    }
}