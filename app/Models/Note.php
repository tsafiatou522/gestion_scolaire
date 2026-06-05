<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = ['eleve_id', 'matiere_id', 'note', 'trimestre', 'annee_scolaire'];

    protected $casts = [
        'note' => 'float',
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    /**
     * Retourne le maximum de la note selon le niveau de la classe de l'élève.
     * CP1 à CE2 : 10
     * CM1 à CM2 : 20
     */
    public function getNoteMax(): int
    {
        $niveau = $this->eleve?->classe?->niveau;
        return in_array($niveau, ['CP1', 'CP2', 'CE1', 'CE2']) ? 10 : 20;
    }

    /**
     * Validation : la note ne doit pas dépasser le max du niveau.
     */
    public function isValidNote(): bool
    {
        return $this->note >= 0 && $this->note <= $this->getNoteMax();
    }
}
