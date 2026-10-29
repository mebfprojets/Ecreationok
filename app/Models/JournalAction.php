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
