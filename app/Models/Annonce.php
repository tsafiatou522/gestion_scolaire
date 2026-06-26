<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = [
        'titre',
        'contenu',
        'type',
        'date_annonce',
    ];

    protected $casts = [
        'date_annonce' => 'date',
    ];
}
