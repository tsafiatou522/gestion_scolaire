<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * Matières de la classe
     */
    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class);
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