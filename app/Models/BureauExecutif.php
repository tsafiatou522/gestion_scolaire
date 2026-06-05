<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BureauExecutif extends Model
{
    protected $table = "bureau_executif";
    protected $fillable = ["nom", "prenom", "fonction", "telephone", "email", "date_adhesion"];
}
