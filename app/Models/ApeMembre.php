<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApeMembre extends Model
{
    protected $table = 'ape_membres';

    protected $fillable = [
        'nom',
        'prenom',
        'fonction',
        'telephone',
        'email',
        'eleve_id',
        'annee_scolaire',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    public function getFonctionLabelAttribute()
    {
        return match($this->fonction) {
            'president'      => 'Président',
            'vice_president' => 'Vice-Président',
            'secretaire'     => 'Secrétaire',
            'tresorier'      => 'Trésorier',
            'membre'         => 'Membre',
            default          => ucfirst($this->fonction),
        };
    }
}
