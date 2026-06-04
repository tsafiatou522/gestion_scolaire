<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EnseignantConnexionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $enseignant;

    public function __construct(User $enseignant)
    {
        $this->enseignant = $enseignant;
    }

    public function build()
    {
        return $this->subject('Connexion enseignant détectée')
                    ->view('emails.enseignant_connexion')
                    ->with(['enseignant' => $this->enseignant]);
    }
}
