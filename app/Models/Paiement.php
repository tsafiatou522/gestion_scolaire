<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = [
        'eleve_id',
        'montant_verse',
        'date_paiement',
        'recu_pdf',
        'observation'
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant_verse' => 'float',
    ];

    /**
     * Élève concerné par le paiement
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }
}