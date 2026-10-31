<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * E-mail envoyé par l'application (ou dont l'envoi a échoué).
 * Affiché dans l'onglet « E-mails » de la rubrique « Activité du promoteur » (espace agents).
 */
class EnvoiMail extends Model
{
    protected $table = 'envois_mail';
    protected $dateFormat = 'd-m-Y H:i:s';   // même convention que les autres tables (SQL Server en français)
    protected $guarded = [];

    /** Libellé et icône de chaque type d'e-mail. */
    public const TYPES = [
        'validation' => ['Demande validée', 'fa-check-circle text-success'],
        'rejet' => ['Corrections demandées', 'fa-undo-alt text-danger'],
        'code_inscription' => ['Code de vérification (inscription)', 'fa-key text-secondary'],
        'mot_de_passe' => ['Réinitialisation du mot de passe', 'fa-unlock-alt text-secondary'],
    ];

    /** Enregistre un envoi ; ne bloque jamais l'envoi lui-même si l'écriture échoue. */
    public static function noter(string $type, ?string $destinataire, ?string $objet, ?\Throwable $erreur = null, ?Demande $demande = null, ?string $motifEchec = null): void
    {
        try {
            static::create([
                'type' => $type,
                'destinataire' => $destinataire ? mb_strtolower(trim($destinataire)) : null,
                'objet' => $objet ? Str::limit($objet, 250) : null,
                'statut' => ($erreur || $motifEchec) ? 'echec' : 'envoye',
                'erreur' => $motifEchec ?? ($erreur ? Str::limit($erreur->getMessage(), 480) : null),
                'demande_id' => $demande->id ?? null,
                'declencheur_id' => Auth::id(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function declencheur()
    {
        return $this->belongsTo(User::class, 'declencheur_id');
    }

    public function libelle(): string
    {
        return self::TYPES[$this->type][0] ?? ucfirst(str_replace('_', ' ', $this->type));
    }

    public function icone(): string
    {
        return self::TYPES[$this->type][1] ?? 'fa-envelope text-secondary';
    }

    public function estEnvoye(): bool
    {
        return $this->statut === 'envoye';
    }
}
