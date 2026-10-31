<?php

namespace App\Mail;

/** E-mail au promoteur : sa demande a été validée par le CEFORE. */
class NotifyValider extends NotificationDemande
{
    public const TYPE_ENVOI = 'validation';   // historique des e-mails (EnvoiMail)

    public function objet(): string
    {
        return 'Votre demande « '.$this->nomEntreprise().' » a été validée';
    }

    public function build()
    {
        $donnees = $this->donnees();

        return $this->subject($this->objet())
            ->view('emails.demande_validee')
            ->text('emails.texte.demande_validee')
            ->with($donnees);
    }
}
