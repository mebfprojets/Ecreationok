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

    /** Formats acceptés à l'écran de dépôt : PDF pour les documents, image pour la photo d'identité. */
    public const FORMAT_PDF = ['.pdf', 'PDF'];
    public const FORMAT_IMAGE = ['image/jpeg,image/png', 'JPG ou PNG'];

    /**
     * Pièces à déposer avant le formulaire de demande, par type d'entreprise (ei, es, gie) :
     * catégorie => [libellé, précision, format (FORMAT_*), taille maximale en Mo].
     * Source unique pour la page de choix du type et la page de dépôt (contrôle des pièces manquantes compris).
     */
    public static function piecesADeposer(string $type): array
    {
        $communes = [
            'declaration' => ['Déclaration sur l’honneur, casier judiciaire et attestation de réservation', 'Les trois documents réunis dans un seul fichier', self::FORMAT_PDF, 3],
        ];
        $identite = [
            'piece_didentite' => ['Pièce d’identité du promoteur', 'CNIB ou passeport, recto et verso', self::FORMAT_PDF, 1],
            'titre_de_propriete' => ['Titre de propriété ou de jouissance et fiche de visite des impôts', 'Justificatif du local de l’entreprise', self::FORMAT_PDF, 4],
        ];

        return $type === 'ei'
            ? $communes + [
                'certificat_de_residence' => ['Certificat de résidence', null, self::FORMAT_PDF, 1],
                'formulaire_dem_cpc' => ['Formulaire de demande de CPC', 'Carte professionnelle de commerçant', self::FORMAT_PDF, 1],
                'photo_didentite' => ['Photo d’identité', 'Photo récente, de face', self::FORMAT_IMAGE, 1],
            ] + $identite
            : $communes + [
                'acte_de_depot' => ['Acte de dépôt', null, self::FORMAT_PDF, 2],
                'statut' => ['Statuts, procès-verbal et autres documents', 'Réunis dans un seul fichier', self::FORMAT_PDF, 10],
                'formulaire_rccm' => ['Formulaire RCCM', null, self::FORMAT_PDF, 1],
            ] + $identite;
    }

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

