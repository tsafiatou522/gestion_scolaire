<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApeCotisation extends Model
{
    // Colonnes autorisées à l'insertion/mise à jour
    protected $fillable = [
        'eleve_id',
        'montant',
        'date_paiement',
        'annee_scolaire',
        'observation',
        'recu_pdf',
    ];

    // Relation : une cotisation appartient à un élève
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}
