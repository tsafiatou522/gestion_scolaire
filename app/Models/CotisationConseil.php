<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CotisationConseil extends Model
{
    protected $table = "cotisations_conseil";
    protected $fillable = ["membre_id", "montant", "date_paiement", "annee_scolaire", "motif"];
}
