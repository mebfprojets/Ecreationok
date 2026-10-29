<?php

namespace App\Mail;

use App\Models\Demande;
use App\Models\Usager;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/** Base des e-mails envoyés au promoteur quand un agent du CEFORE traite sa demande. */
abstract class NotificationDemande extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $usager;

    public function __construct(Demande $demande, Usager $usager)
    {
        $this->demande = $demande;
        $this->usager = $usager;
    }

    /** Données communes aux gabarits HTML et texte. */
    protected function donnees(): array
    {
        $ville = DB::table('organisations')->where('CodeOrganisation', $this->demande->organisation_code)->value('Ville');

        return [
            'nomComplet' => trim(mb_convert_case(trim($this->usager->Prenom.' '.$this->usager->NomRaisonSociale), MB_CASE_TITLE)) ?: 'Madame, Monsieur',
            'entreprise' => $this->demande->commercial_name ?: ($this->demande->denomination_social ?: 'votre entreprise'),
            'numero' => $this->demande->numero_demande,
            'cefore' => self::nomCefore($ville),
            'date' => now()->format('d/m/Y à H:i'),
            'lien' => route('demande.detail', $this->demande->id),
        ];
    }

    /** « CEFORE OUAGADOUGOU » -> « CEFORE de Ouagadougou ». */
    public static function nomCefore(?string $ville): string
    {
        $lieu = trim(preg_replace('/^CEFORE\s*/iu', '', (string) $ville));

        return $lieu === '' ? 'CEFORE' : 'CEFORE de '.mb_convert_case(mb_strtolower($lieu), MB_CASE_TITLE);
    }
}
