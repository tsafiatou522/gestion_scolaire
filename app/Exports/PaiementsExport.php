<?php

namespace App\Exports;

use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaiementsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $eleveId;

    public function __construct($eleveId = null)
    {
        $this->eleveId = $eleveId;
    }

    public function collection()
    {
        $query = Paiement::with('eleve.classe')->orderByDesc('date_paiement');

        if ($this->eleveId) {
            $query->where('eleve_id', $this->eleveId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'N° Reçu',
            'Élève',
            'Classe',
            'Date',
            'Montant versé (FCFA)',
            'Observation',
        ];
    }

    public function map($paiement): array
    {
        return [
            str_pad($paiement->id, 5, '0', STR_PAD_LEFT),
            $paiement->eleve->nom_complet,
            $paiement->eleve->classe->nom,
            $paiement->date_paiement->format('d/m/Y'),
            $paiement->montant_verse,
            $paiement->observation ?? '—',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1e3a5f']],
            ],
        ];
    }
}