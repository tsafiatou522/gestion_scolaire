<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // 1. On importe BelongsToMany

class Matiere extends Model
{
    // 2. On nettoie $fillable : 'classe_id' et 'coefficient' n'appartiennent plus directement à la matière
    protected $fillable = [
        'nom',
        'code'
    ];

    /**
     * Les classes qui possèdent cette matière (Relation modifiée en Many-to-Many)
     */
    public function classes(): BelongsToMany
    {
        // 3. On remplace l'ancienne méthode classe() par classes() au pluriel
        return $this->belongsToMany(Classe::class, 'classe_matiere')
                    ->withPivot('coefficient')
                    ->withTimestamps();
    }

    /**
     * Les notes associées à cette matière
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}