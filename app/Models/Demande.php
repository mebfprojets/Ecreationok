<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Situation de la demande telle qu'elle est présentée au promoteur.
     * etape : 1 dépôt, 2 paiement, 3 examen par le CEFORE, 4 validation et retrait.
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
            if ($this->statut == 3) {
                return ['etape' => 4, 'erreur' => false, 'couleur' => 'success', 'icone' => 'fa-box-open',
                    'libelle' => 'Documents prêts pour le retrait',
                    'consigne' => 'Vos documents signés sont disponibles : présentez-vous au CEFORE pour les retirer.'];
            }
            if ($this->statut == 2) {
                return ['etape' => 4, 'erreur' => false, 'couleur' => 'success', 'icone' => 'fa-file-signature',
                    'libelle' => 'RCCM signé — autres formalités en cours',
                    'consigne' => 'Votre RCCM est signé. Les autres formalités sont en cours auprès des administrations.'];
            }
            return ['etape' => 4, 'erreur' => false, 'couleur' => 'success', 'icone' => 'fa-check-circle',
                'libelle' => 'Demande validée',
                'consigne' => 'Votre demande est validée : déposez votre dossier physique au CEFORE pour la suite des formalités.'];
        }

        return ['etape' => 3, 'erreur' => false, 'couleur' => 'primary', 'icone' => 'fa-cogs',
            'libelle' => 'En traitement au CEFORE',
            'consigne' => 'Votre dossier est en cours d’examen par le CEFORE. Vous serez informé(e) de la décision.'];
    }
}
