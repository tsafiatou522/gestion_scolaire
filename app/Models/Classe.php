<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // 1. On importe le bon type de relation

class Classe extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'nom',
        'niveau',
        'annee_scolaire'
    ];

    /**
     * Élèves de la classe
     */
    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
    }

    /**
     * Matières de la classe (Relation modifiée en Many-to-Many)
     */
    public function matieres(): BelongsToMany
    {
        // 2. On utilise belongsToMany en ciblant la table pivot 'classe_matiere'
        return $this->belongsToMany(Matiere::class, 'classe_matiere')
                    ->withPivot('coefficient') // Permet de récupérer le coefficient facilement
                    ->withTimestamps();
    }

    /**
     * Frais de scolarité
     */
    public function fraisScolarite(): HasOne
    {
        return $this->hasOne(FraisScolarite::class);
    }

    /**
     * Nombre d'élèves
     */
    public function getNbElevesAttribute(): int
    {
        if ($this->relationLoaded('eleves')) {
            return $this->eleves->count();
        }

        return $this->eleves()->count();
    }

    /**
     * Total attendu
     */
    public function getTotalAttenduAttribute(): float
    {
        $montant = $this->fraisScolarite?->montant ?? 0;

        return $montant * $this->nb_eleves;
    }
}