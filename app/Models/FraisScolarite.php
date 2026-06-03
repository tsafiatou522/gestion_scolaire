<?php
// app/Models/FraisScolarite.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FraisScolarite extends Model
{
    protected $table = 'frais_scolarite';

    protected $fillable = ['classe_id', 'montant', 'annee_scolaire'];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }
}
