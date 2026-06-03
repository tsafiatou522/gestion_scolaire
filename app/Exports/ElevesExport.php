<?php

namespace App\Exports;

use App\Models\Eleve;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ElevesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $classeId;

    public function __construct($classeId = null)
    {
        $this->classeId = $classeId;
    }

    public function collection()
    {
        $query = Eleve::with('classe')->orderBy('nom');

        if ($this->classeId) {
            $query->where('classe_id', $this->classeId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'N°',
            'Nom',
            'Prénom',
            'Date de naissance',
            'Sexe',
            'Classe',
            'Nom du parent',
            'Téléphone',
        ];
    }

    public function map($eleve): array
    {
        static $i = 0;
        $i++;
        return [
            $i,
            $eleve->nom,
            $eleve->prenom,
            $eleve->date_naissance->format('d/m/Y'),
            $eleve->sexe == 'M' ? 'Masculin' : 'Féminin',
            $eleve->classe->nom,
            $eleve->nom_parent ?? '—',
            $eleve->telephone_parent ?? '—',
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