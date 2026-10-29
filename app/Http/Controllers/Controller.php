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

    protected function autoriserUsager($usagerId): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }
        if ($user->isadmin != null) {
            return;
        }

        $usager = Usager::where('user_id', $user->id)->first();

        if (!$usager || $usagerId === null || (int) $usagerId !== (int) $usager->id) {
            abort(403);
        }
    }

    protected function autoriserDemande(?Demande $demande): void
    {
        if (!$demande) {
            abort(404);
        }
        $this->autoriserUsager($demande->usager_id);
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
