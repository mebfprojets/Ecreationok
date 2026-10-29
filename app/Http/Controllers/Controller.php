<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Usager;
use App\Models\Demande;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public const REGLE_FICHIER = 'file|mimes:pdf,jpg,jpeg,png|max:10240'; // 10 Mo, comme le contrôle du navigateur

    /** Code d'organisation du siège : ses agents voient les demandes de tous les CEFORE. */
    public const ORGANISATION_SIEGE = '001000';

    protected function estAgent($user): bool
    {
        return $user && $user->isadmin != null;
    }

    protected function estAgentSiege($user): bool
    {
        return $this->estAgent($user) && (string) $user->organisation === self::ORGANISATION_SIEGE;
    }

    /**
     * Promoteur : uniquement ses propres données.
     * Agent : uniquement les promoteurs ayant une demande dans son CEFORE (le siège voit tout).
     */
    protected function autoriserUsager($usagerId): void
    {
        $user = Auth::user();

        if (!$user || $usagerId === null) {
            abort(403);
        }
        if ($this->estAgent($user)) {
            if ($this->estAgentSiege($user)
                || Demande::where('usager_id', $usagerId)->where('organisation_code', $user->organisation)->exists()) {
                return;
            }
            abort(403);
        }

        $usager = Usager::where('user_id', $user->id)->first();

        if (!$usager || (int) $usagerId !== (int) $usager->id) {
            abort(403);
        }
    }

    /** Promoteur : sa propre demande. Agent : une demande de son CEFORE (le siège voit tout). */
    protected function autoriserDemande(?Demande $demande): void
    {
        if (!$demande) {
            abort(404);
        }
        if ($this->estAgent(Auth::user())) {
            $this->autoriserAgentDemande($demande);
            return;
        }
        $this->autoriserUsager($demande->usager_id);
    }

    /** Pages de l'espace agents : la demande doit relever du CEFORE de l'agent (le siège voit tout). */
    protected function autoriserAgentDemande(?Demande $demande): void
    {
        if (!$demande) {
            abort(404);
        }
        $user = Auth::user();
        if (!$this->estAgent($user)) {
            abort(403);
        }
        if (!$this->estAgentSiege($user) && (string) $demande->organisation_code !== (string) $user->organisation) {
            abort(403, 'Cette demande relève d’un autre CEFORE.');
        }
    }

    /**
     * Paramètres envoyés par un tableau DataTables chargé page par page (serverSide) :
     * début, nombre de lignes (100 au plus), motif LIKE de la recherche (échappé pour SQL Server) ou null, colonne et sens du tri.
     */
    protected function parametresTableau(\Illuminate\Http\Request $request, array $colonnesTriables, string $triParDefaut): array
    {
        $recherche = trim((string) data_get($request->input('search'), 'value', ''));

        return [
            'debut' => max(0, (int) $request->input('start', 0)),
            'longueur' => max(1, min(100, (int) $request->input('length', 25))),
            'motif' => $recherche === '' ? null : '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $recherche).'%',
            'tri' => $colonnesTriables[(int) data_get($request->input('order'), '0.column', -1)] ?? $triParDefaut,
            'sens' => data_get($request->input('order'), '0.dir') === 'asc' ? 'asc' : 'desc',
        ];
    }

    /** Refus standard de l'espace agents (message flash puis retour à la page précédente). */
    protected function refuserAcces()
    {
        flash("Vous n'avez pas le droit d'accéder à cette ressource. Veuillez contacter l'administrateur.")->error();

        return redirect()->back();
    }

    /** Messages en français pour la règle REGLE_FICHIER (la langue de l'application est l'anglais). */
    protected function messagesFichier(string ...$champs): array
    {
        $messages = [];
        foreach ($champs as $champ) {
            $messages[$champ.'.required'] = 'Veuillez sélectionner le fichier à envoyer.';
            $messages[$champ.'.file'] = 'Le fichier n’a pas été reçu correctement. Sélectionnez-le de nouveau.';
            $messages[$champ.'.uploaded'] = 'Le fichier n’a pas pu être envoyé : il est probablement trop volumineux.';
            $messages[$champ.'.mimes'] = 'Le fichier doit être au format PDF, JPG ou PNG.';
            $messages[$champ.'.max'] = 'Le fichier ne doit pas dépasser 10 Mo.';
        }

        return $messages;
    }
}
