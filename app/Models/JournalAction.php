<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/** Une action d'un agent sur une demande, affichée dans « Dernières actions » du tableau de bord. */
class JournalAction extends Model
{
    protected $table = 'journal_actions';
    protected $dateFormat = 'd-m-Y H:i:s';   // même convention que les autres tables (SQL Server en français)
    protected $guarded = [];
    protected $casts = ['vu_promoteur_le' => 'datetime'];

    /** Libellé présenté au promoteur dans ses notifications, et icône. */
    public const MESSAGES_PROMOTEUR = [
        'validation' => ['Votre demande a été validée', 'fa-check-circle text-success'],
        'rejet' => ['Le CEFORE demande une correction', 'fa-exclamation-circle text-danger'],
        'piece_modifiee' => ['Une pièce a été mise à jour par le CEFORE', 'fa-file-alt text-primary'],
        'demande_corrigee' => ['Les informations de l’entreprise ont été corrigées', 'fa-building text-primary'],
        'dirigeant_corrige' => ['Les informations du dirigeant ont été corrigées', 'fa-user-edit text-primary'],
    ];

    /** Notifications non lues, mémorisées le temps de la requête (en-tête et liste les affichent tous deux). */
    private static $nonLues = [];

    /** Actions d'agents sur les dossiers du promoteur qu'il n'a pas encore vues, de la plus récente à la plus ancienne. */
    public static function nonLuesDuPromoteur(?User $user)
    {
        if (!$user || $user->isadmin != null) {
            return collect();
        }
        if (!isset(self::$nonLues[$user->id])) {
            $usagers = Usager::where('user_id', $user->id)->select('id');
            self::$nonLues[$user->id] = static::with('demande:id,commercial_name,denomination_social')
                ->whereNull('vu_promoteur_le')
                ->whereIn('demande_id', Demande::whereIn('usager_id', $usagers)->select('id'))
                ->orderBy('created_at', 'desc')->orderBy('id', 'desc')
                ->get();
        }

        return self::$nonLues[$user->id];
    }

    /** Le promoteur a ouvert son dossier : les actions sur cette demande sont vues. */
    public static function marquerVuesPourDemande(Demande $demande): void
    {
        static::where('demande_id', $demande->id)->whereNull('vu_promoteur_le')
            ->update(['vu_promoteur_le' => now()->format((new static)->getDateFormat())]);
        self::$nonLues = [];
    }

    public function messagePromoteur(): string
    {
        return self::MESSAGES_PROMOTEUR[$this->action][0] ?? 'Votre dossier a été mis à jour';
    }

    public function iconePromoteur(): string
    {
        return self::MESSAGES_PROMOTEUR[$this->action][1] ?? 'fa-bell text-primary';
    }

    /** Libellé, couleur du badge et icône de chaque type d'action. */
    public const TYPES = [
        'validation' => ['Validation', 'success', 'fa-check-circle'],
        'rejet' => ['Rejet', 'danger', 'fa-times-circle'],
        'piece_modifiee' => ['Pièce modifiée', 'primary', 'fa-file-alt'],
        'demande_corrigee' => ['Entreprise corrigée', 'info', 'fa-building'],
        'dirigeant_corrige' => ['Dirigeant corrigé', 'info', 'fa-user-edit'],
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'demande_id');
    }

    /** Enregistre une action de l'agent connecté. Ne bloque jamais l'action elle-même si l'écriture échoue. */
    public static function noter(string $action, ?Demande $demande = null, ?string $detail = null): void
    {
        $agent = Auth::user();
        if (!$agent || $agent->isadmin == null) {
            return;
        }
        try {
            static::create([
                'user_id' => $agent->id,
                'organisation' => $agent->organisation,
                'action' => $action,
                'demande_id' => $demande->id ?? null,
                'detail' => $detail,
            ]);
            self::$nonLues = [];
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function libelle(): string
    {
        return self::TYPES[$this->action][0] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    public function couleur(): string
    {
        return self::TYPES[$this->action][1] ?? 'secondary';
    }

    public function icone(): string
    {
        return self::TYPES[$this->action][2] ?? 'fa-circle';
    }
}
