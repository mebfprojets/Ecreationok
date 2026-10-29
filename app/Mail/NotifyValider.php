<?php

namespace App\Mail;

/** E-mail au promoteur : sa demande a été validée par le CEFORE. */
class NotifyValider extends NotificationDemande
{
    public function build()
    {
        $donnees = $this->donnees();

        return $this->subject('Votre demande « '.$donnees['entreprise'].' » a été validée')
            ->view('emails.demande_validee')
            ->text('emails.texte.demande_validee')
            ->with($donnees);
    }
}
