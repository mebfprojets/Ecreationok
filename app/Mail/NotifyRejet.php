<?php

namespace App\Mail;

/** E-mail au promoteur : sa demande est rejetée et doit être corrigée (motif saisi par l'agent). */
class NotifyRejet extends NotificationDemande
{
    public const TYPE_ENVOI = 'rejet';   // historique des e-mails (EnvoiMail)

    public function objet(): string
    {
        return 'Votre demande « '.$this->nomEntreprise().' » doit être corrigée';
    }

    public function build()
    {
        $donnees = $this->donnees();
        $donnees['motif'] = (string) $this->demande->motif;
        $donnees['lien'] .= '#correction';

        return $this->subject($this->objet())
            ->view('emails.demande_rejetee')
            ->text('emails.texte.demande_rejetee')
            ->with($donnees);
    }
}
