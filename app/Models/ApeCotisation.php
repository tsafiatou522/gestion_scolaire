<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApeCotisation extends Model
{
    protected $casts = [
        'date_paiement' => 'date',
    ];

    protected $fillable = [
        'eleve_id',
        'montant',
        'date_paiement',
        'annee_scolaire',
        'observation',
        'recu_pdf',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}
