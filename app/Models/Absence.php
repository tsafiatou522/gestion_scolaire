<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    protected $fillable = [
        'eleve_id',
        'date_absence',
        'motif',
        'justifiee',
    ];

    protected $casts = [
        'date_absence' => 'date',
        'justifiee' => 'boolean',
    ];

    /**
     * Eleve concerne par l'absence
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }
}
