<?php

namespace App\Mail;

/** E-mail au promoteur : sa demande est rejetée et doit être corrigée (motif saisi par l'agent). */
class NotifyRejet extends NotificationDemande
{
    public function build()
    {
        $donnees = $this->donnees();
        $donnees['motif'] = (string) $this->demande->motif;
        $donnees['lien'] .= '#correction';

        return $this->subject('Votre demande « '.$donnees['entreprise'].' » doit être corrigée')
            ->view('emails.demande_rejetee')
            ->text('emails.texte.demande_rejetee')
            ->with($donnees);
    }
}
