<?php

namespace App\Http\Controllers;

use App\Support\CodeInscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    /** Étape 1 de l'inscription : envoi d'un code de vérification à l'adresse e-mail saisie. */
    public function envoyerCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
        ], [
            'email.required' => 'Saisissez votre adresse e-mail.',
            'email.email' => 'Cette adresse e-mail n’est pas valide : vérifiez son orthographe (exemple : nom@gmail.com).',
            'email.max' => 'L’adresse e-mail est trop longue.',
            'email.unique' => 'Un compte existe déjà avec cette adresse e-mail.',
        ]);

        $email = mb_strtolower(trim($request->email));
        $attente = CodeInscription::attenteRestante($email);
        if ($attente > 0) {
            return response()->json([
                'message' => 'Un code vient d’être envoyé à cette adresse. Vous pourrez en demander un nouveau dans '.$attente.' secondes.',
                'attente' => $attente,
            ], 429);
        }

        try {
            CodeInscription::envoyer($email);
        } catch (\Throwable $e) {
            // L'e-mail n'est pas parti (adresse refusée, service d'envoi indisponible...) : on le signale
            // dans la fenêtre d'inscription. Rien n'est enregistré, l'usager peut renvoyer le code tout de suite.
            report($e);

            return response()->json([
                'message' => 'Le code de vérification n’a pas pu être envoyé à '.$email.'. '
                    .'Vérifiez que l’adresse est correcte, puis cliquez sur « Renvoyer le code ».',
                'non_envoye' => true,
            ], 500);
        }

        return response()->json([
            'message' => 'Un code de vérification a été envoyé à '.$email.'. Consultez votre boîte de réception (et vos courriers indésirables).',
            'attente' => CodeInscription::DELAI_RENVOI_SECONDES,
        ]);
    }
}
