<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    /**
     * Crée une nouvelle instance avec le code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Sujet et contenu du mail
     */
    public function build()
    {
        return $this->subject('Code de vérification')
                    ->view('emails.verification')
                    ->with(['code' => $this->code]);
    }
}
