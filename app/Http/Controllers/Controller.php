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
    public const REGLE_FICHIER = 'file|mimes:pdf,jpg,jpeg,png';

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
}
