<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointe extends Model
{
    use HasFactory;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $guarded=[];

    /** Libellés lisibles des pièces (type_piece enregistré en base -> libellé affiché), communs aux deux espaces. */
    public const LIBELLES = [
        'declaration' => 'Déclaration sur l’honneur / casier judiciaire', 'casier_judiciaire' => 'Casier judiciaire',
        'cnib' => 'CNIB', 'passport' => 'Passeport', 'piece_didentite' => 'Pièce d’identité',
        'titre_propriete' => 'Titre de propriété / bail', 'titre_de_propriete' => 'Titre de propriété / bail',
        'formulaire_dem_cpc' => 'Formulaire de demande de CPC', 'formulaire_cpc_es' => 'Formulaire CPC',
        'certificat_residence' => 'Certificat de résidence', 'certificat_de_residence' => 'Certificat de résidence',
        'photo_didentite' => 'Photo d’identité', 'signature' => 'Signature', 'statut' => 'Statuts',
        'formulaire_rccm' => 'Formulaire RCCM', 'acte_de_depot' => 'Acte de dépôt',
        'acte_mariage' => 'Acte de mariage', 'autorisation_de_commerce' => 'Autorisation d’exercer le commerce',
    ];

    public static function libelleType($type): string
    {
        $cle = mb_strtolower(trim((string) $type));

        return self::LIBELLES[$cle] ?? ucfirst(str_replace('_', ' ', $cle));
    }

    public function libelle(): string
    {
        return self::libelleType($this->type_piece);
    }

    public function demande(){
        return $this->belongsTo(Demande::class,'demande_id');
     }
}

