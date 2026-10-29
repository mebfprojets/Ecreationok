<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeVerificationInscription extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $dureeMinutes;

    public function __construct(string $code, int $dureeMinutes)
    {
        $this->code = $code;
        $this->dureeMinutes = $dureeMinutes;
    }

    public function build()
    {
        return $this->subject('Votre code de vérification e-Création : '.$this->code)
            ->view('emails.code_inscription');
    }
}
