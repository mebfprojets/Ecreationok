<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Demande extends Model
{
    protected $dateFormat = 'd-m-Y H:i:s';
    use HasFactory;
    protected $guarded=[];
    public function usager(){
        return $this->belongsTo(Usager::class,'usager_id');
     }

    /** Rejets (avec motif) et renvois pour traitement, du plus récent au plus ancien. */
    public function historiques()
    {
        return $this->hasMany(Historique::class, 'id_demande')->orderBy('id', 'desc');
    }

    /** Demande payée puis rejetée par le CEFORE : le promoteur doit la corriger puis la renvoyer. */
    public function estRejetee(): bool
    {
        return $this->paye == 1 && $this->etat == 2;
    }

    /**
     * Numéros de formalités attendus pour cette demande (le CPC seulement s'il a été demandé),
     * avec le numéro attribué (ou null) et sa date d'attribution.
     */
    public function numerosFormalites(): array
    {
        $vide = fn ($v) => trim((string) $v) === '';
        $numeros = [
            'RCCM' => ['numero' => $vide($this->RCCM) ? null : $this->RCCM, 'date' => $this->DateRCCM],
            'IFU' => ['numero' => $vide($this->IFU) ? null : $this->IFU, 'date' => $this->DateIFU],
            'CNSS' => ['numero' => $vide($this->CNSS) ? null : $this->CNSS, 'date' => $this->DateCNSS],
        ];
        if ((int) $this->avecCPC === 1) {
            $numeros['CPC'] = ['numero' => $vide($this->CPC) ? null : $this->CPC, 'date' => $this->DateCPC];
        }

        return $numeros;
    }

    /**
     * Date à partir de laquelle les documents peuvent être retirés : 24 h après l'attribution du dernier numéro,
     * c'est-à-dire le lendemain (les dates d'attribution n'ont pas d'heure). null si un numéro manque encore.
     */
    public function retraitPossibleLe(): ?Carbon
    {
        $numeros = $this->numerosFormalites();
        if (collect($numeros)->contains(fn ($n) => $n['numero'] === null)) {
            return null;
        }
        $dates = collect($numeros)->pluck('date')->filter()->map(fn ($d) => Carbon::parse($d));
        $derniere = $dates->isEmpty() ? Carbon::parse($this->updated_at ?? now()) : $dates->max();

        return $derniere->copy()->startOfDay()->addDay();
    }

    /**
     * Situation de la demande telle qu'elle est présentée au promoteur.
     * etape : 1 dépôt, 2 paiement, 3 examen par le CEFORE, 4 traitement (formalités RCCM, IFU, CNSS, CPC),
     * 5 retrait (24 h après l'attribution du dernier numéro, soit à partir du lendemain : les dates n'ont pas d'heure).
     */
    public function suivi(): array
    {
        if ($this->paye == 0) {
            return ['etape' => 2, 'erreur' => false, 'couleur' => 'warning', 'icone' => 'fa-wallet',
                'libelle' => 'En attente de paiement',
                'consigne' => 'Réglez les frais de la demande pour qu’elle soit transmise au CEFORE.'];
        }
        if ($this->paye == 2) {
            return ['etape' => 2, 'erreur' => false, 'couleur' => 'info', 'icone' => 'fa-hourglass-half',
                'libelle' => 'Paiement en cours de vérification',
                'consigne' => 'Votre paiement est en cours de confirmation. Aucune action n’est nécessaire de votre part.'];
        }
        if ($this->etat == 2) {
            return ['etape' => 3, 'erreur' => true, 'couleur' => 'danger', 'icone' => 'fa-exclamation-circle',
                'libelle' => 'Rejetée — corrections attendues',
                'consigne' => 'Le CEFORE a relevé des points à corriger. Consultez le motif, corrigez votre dossier puis renvoyez-le pour traitement.'];
        }
        if ($this->etat == 1) {
            $numeros = $this->numerosFormalites();
            $obtenus = array_keys(array_filter($numeros, fn ($n) => $n['numero'] !== null));
            $attendus = array_keys(array_filter($numeros, fn ($n) => $n['numero'] === null));

            if (empty($obtenus)) {
                return ['etape' => 4, 'erreur' => false, 'couleur' => 'primary', 'icone' => 'fa-cogs',
                    'libelle' => 'Validée — traitement en cours',
                    'consigne' => 'Votre demande est validée : déposez votre dossier physique au CEFORE. Vos numéros ('
                        .implode(', ', array_keys($numeros)).') vous seront attribués au fur et à mesure.'];
            }
            if (!empty($attendus)) {
                return ['etape' => 4, 'erreur' => false, 'couleur' => 'primary', 'icone' => 'fa-cogs',
                    'libelle' => 'Traitement en cours',
                    'consigne' => 'Déjà attribué : '.implode(', ', $obtenus).'. En cours : '.implode(', ', $attendus).'.'];
            }
            $retrait = $this->retraitPossibleLe();
            if ($retrait && $retrait->isFuture()) {
                return ['etape' => 4, 'erreur' => false, 'couleur' => 'primary', 'icone' => 'fa-hourglass-half',
                    'libelle' => 'Numéros attribués — retrait bientôt possible',
                    'consigne' => 'Tous vos numéros ('.implode(', ', $obtenus).') sont attribués. Vos documents pourront être retirés au CEFORE à partir du '
                        .$retrait->format('d/m/Y').'.'];
            }

            return ['etape' => 5, 'erreur' => false, 'couleur' => 'success', 'icone' => 'fa-box-open',
                'libelle' => 'Documents prêts pour le retrait',
                'consigne' => 'Vos formalités sont terminées ('.implode(', ', $obtenus).'). Présentez-vous au CEFORE pour retirer vos documents.'];
        }

        return ['etape' => 3, 'erreur' => false, 'couleur' => 'primary', 'icone' => 'fa-cogs',
            'libelle' => 'En traitement au CEFORE',
            'consigne' => 'Votre dossier est en cours d’examen par le CEFORE. Vous serez informé(e) de la décision.'];
    }
}
