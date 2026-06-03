<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Classe extends Model
{
    protected $table = 'classes';

    protected $fillable = ['nom', 'niveau', 'annee_scolaire'];

    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
    }

    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class);
    }

    public function fraisScolarite(): HasOne
    {
        return $this->hasOne(FraisScolarite::class);
    }

    // Nombre d'élèves inscrits
    public function getNbElevesAttribute(): int
    {
        return $this->eleves()->count();
    }

    // Total des frais attendus pour cette classe
    public function getTotalAttenduAttribute(): float
    {
        $frais = $this->fraisScolarite;
        return $frais ? $frais->montant * $this->nb_eleves : 0;
    }
}
