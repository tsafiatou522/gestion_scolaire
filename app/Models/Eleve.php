<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eleve extends Model
{
    protected $fillable = [
        'nom', 'prenom', 'date_naissance', 'sexe',
        'photo', 'nom_parent', 'telephone_parent', 'classe_id'
    ];

    protected $casts = ['date_naissance' => 'date'];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    // Nom complet
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // Total versé par cet élève
    public function getTotalVerseAttribute(): float
    {
        return $this->paiements()->sum('montant_verse');
    }

    // Reste à payer
    public function getResteAPayer(): float
    {
        $frais = $this->classe?->fraisScolarite?->montant ?? 0;
        return max(0, $frais - $this->total_verse);
    }
}
