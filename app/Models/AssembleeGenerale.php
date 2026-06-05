<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssembleeGenerale extends Model
{
    protected $table = "assemblee_generale";
    protected $fillable = ["nom", "prenom", "role", "telephone", "email", "categorie"];
}
