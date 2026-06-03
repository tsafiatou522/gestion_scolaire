<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eleve extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'photo',
        'nom_parent',
        'telephone_parent',
        'classe_id'
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    /**
     * Classe de l'élève
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Paiements de l'élève
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Notes de l'élève
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Nom complet
     */
    public function getNomCompletAttribute(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    /**
     * Total versé
     */
    public function getTotalVerseAttribute(): float
    {
        if ($this->relationLoaded('paiements')) {
            return (float) $this->paiements->sum('montant_verse');
        }

        return (float) $this->paiements()->sum('montant_verse');
    }

    /**
     * Montant des frais scolaires
     */
    public function getMontantDuAttribute(): float
    {
        return (float) ($this->classe?->fraisScolarite?->montant ?? 0);
    }

    /**
     * Reste à payer
     */
    public function getResteAPayerAttribute(): float
    {
        return max(0, $this->montant_du - $this->total_verse);
    }

    /**
     * Statut de paiement
     */
    public function getStatutPaiementAttribute(): string
    {
        if ($this->total_verse >= $this->montant_du) {
            return 'Payé';
        }

        if ($this->total_verse > 0) {
            return 'Partiel';
        }

        return 'Impayé';
    }
}