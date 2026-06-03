<?php

namespace App\Http\Controllers;

use App\Exports\ElevesExport;
use App\Exports\PaiementsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportEleves()
    {
        $classeId = request('classe_id');
        return Excel::download(
            new ElevesExport($classeId),
            'eleves_' . now()->format('d-m-Y') . '.xlsx'
        );
    }

    public function exportPaiements()
    {
        $eleveId = request('eleve_id');
        return Excel::download(
            new PaiementsExport($eleveId),
            'paiements_' . now()->format('d-m-Y') . '.xlsx'
        );
    }
}