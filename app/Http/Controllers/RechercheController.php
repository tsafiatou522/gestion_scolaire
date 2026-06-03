<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Paiement;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $eleves = collect();
        $paiements = collect();

        if ($query && strlen($query) >= 2) {
            $eleves = Eleve::with('classe')
                ->where('nom', 'like', "%{$query}%")
                ->orWhere('prenom', 'like', "%{$query}%")
                ->orWhere('nom_parent', 'like', "%{$query}%")
                ->orderBy('nom')
                ->take(20)
                ->get();

            $paiements = Paiement::with('eleve.classe')
                ->whereHas('eleve', function ($q) use ($query) {
                    $q->where('nom', 'like', "%{$query}%")
                      ->orWhere('prenom', 'like', "%{$query}%");
                })
                ->orderByDesc('date_paiement')
                ->take(10)
                ->get();
        }

        return view('recherche.index', compact('query', 'eleves', 'paiements'));
    }
}