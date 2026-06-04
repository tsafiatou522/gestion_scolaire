<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Affiche la liste des activités enregistrées
     */
    public function index()
    {
        // On récupère les activités avec l'utilisateur associé
        $activities = Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // On envoie les données à la vue
        return view('activities.index', compact('activities'));
    }
}
