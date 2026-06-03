<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApeMembre extends Model
{
    protected $table = 'ape_membres';

    protected $fillable = [
        'nom', 'prenom', 'telephone', 'email',
        'fonction', 'eleve_id', 'annee_scolaire'
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getFonctionLabelAttribute(): string
    {
        return match($this->fonction) {
            'president'      => 'Président(e)',
            'vice_president' => 'Vice-Président(e)',
            'secretaire'     => 'Secrétaire',
            'tresorier'      => 'Trésorier(ère)',
            default          => 'Membre',
        };
    }
}