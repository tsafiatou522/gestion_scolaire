<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ComiteControle extends Model
{
    protected $table = "comite_controle";
    protected $fillable = ["nom", "prenom", "fonction", "telephone", "date_debut", "date_fin"];
}
