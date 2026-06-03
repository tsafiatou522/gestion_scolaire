<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApeCotisation extends Model
{
    protected $table = 'ape_cotisations';

    protected $fillable = [
        'eleve_id', 'montant', 'date_paiement',
        'annee_scolaire', 'recu_pdf', 'observation'
    ];

    protected $casts = ['date_paiement' => 'date'];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }
}