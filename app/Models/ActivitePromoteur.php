<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Activité d'un compte : connexions et modifications faites par le promoteur sur son dossier.
 * Affichée dans la rubrique « Activité du promoteur » de la page de traitement (espace agents).
 */
class ActivitePromoteur extends Model
{
    protected $table = 'activites_promoteur';
    protected $dateFormat = 'd-m-Y H:i:s';   // même convention que les autres tables (SQL Server en français)
    protected $guarded = [];

    public const CONNEXIONS = ['connexion', 'connexion_echouee', 'deconnexion'];

    /** Libellé et icône de chaque action. */
    public const TYPES = [
        'connexion' => ['Connexion au compte', 'fa-sign-in-alt text-success'],
        'connexion_echouee' => ['Tentative de connexion échouée (mot de passe incorrect)', 'fa-exclamation-triangle text-danger'],
        'deconnexion' => ['Déconnexion', 'fa-sign-out-alt text-secondary'],
        'demande_modifiee' => ['Informations de l’entreprise modifiées', 'fa-building text-primary'],
        'dirigeant_modifie' => ['Informations du dirigeant modifiées', 'fa-user-edit text-primary'],
        'piece_remplacee' => ['Pièce jointe remplacée', 'fa-file-upload text-primary'],
    ];

    /** Enregistre une action ; ne bloque jamais l'action elle-même si l'écriture échoue. */
    public static function noter(string $action, ?Demande $demande = null, ?string $detail = null, $user = null): void
    {
        $user = $user ?? Auth::user();
        try {
            $requete = request();
            static::create([
                'user_id' => $user->id ?? null,
                'demande_id' => $demande->id ?? null,
                'action' => $action,
                'detail' => $detail,
                'ip' => $requete ? $requete->ip() : null,
                'navigateur' => $requete ? mb_substr((string) $requete->userAgent(), 0, 255) : null,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function libelle(): string
    {
        return self::TYPES[$this->action][0] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    public function icone(): string
    {
        return self::TYPES[$this->action][1] ?? 'fa-circle text-secondary';
    }

    /** Navigateur et système lisibles, à partir de l'en-tête User-Agent (ex. « Chrome · Windows »). */
    public static function navigateurLisible(?string $agent): string
    {
        $agent = (string) $agent;
        if ($agent === '') {
            return '—';
        }
        $navigateur = collect(['Edg' => 'Edge', 'OPR' => 'Opera', 'Firefox' => 'Firefox', 'Chrome' => 'Chrome', 'Safari' => 'Safari'])
            ->first(fn ($nom, $cle) => str_contains($agent, $cle)) ?? 'Navigateur inconnu';
        $systeme = collect(['Android' => 'Android', 'iPhone' => 'iPhone', 'iPad' => 'iPad', 'Windows' => 'Windows', 'Mac OS' => 'macOS', 'Linux' => 'Linux'])
            ->first(fn ($nom, $cle) => str_contains($agent, $cle)) ?? '';

        return trim($navigateur.($systeme ? ' · '.$systeme : ''));
    }
}
