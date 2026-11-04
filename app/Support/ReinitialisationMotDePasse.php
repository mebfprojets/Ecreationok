<?php

namespace App\Support;

use App\Models\EnvoiMail;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Lien de réinitialisation du mot de passe envoyé par e-mail : demandé par l'utilisateur (« Mot de passe oublié ? »)
 * ou par un administrateur depuis la liste des agents.
 *
 * Le jeton n'est conservé en base que sous forme d'empreinte (SHA-256), expire au bout de DUREE_MINUTES
 * et un seul envoi est possible par minute et par adresse.
 */
class ReinitialisationMotDePasse
{
    public const DUREE_MINUTES = 60;
    public const DELAI_RENVOI_SECONDES = 60;

    public const ENVOYE = 'envoye';
    public const TROP_RECENT = 'trop_recent';
    public const ECHEC = 'echec';

    /** Envoie le lien ; $administrateur : compte qui l'a déclenché depuis l'espace agents (null : l'utilisateur lui-même). */
    public static function envoyer(User $user, ?User $administrateur = null): string
    {
        $email = mb_strtolower(trim((string) $user->email));

        $dernier = DB::table('password_resets')->where('email', $email)->max('created_at');
        if ($dernier && Carbon::parse($dernier)->addSeconds(self::DELAI_RENVOI_SECONDES)->isFuture()) {
            return self::TROP_RECENT;
        }

        $token = Str::random(64);
        DB::table('password_resets')->where('email', $email)->delete();
        ResetPassword::create([
            'email' => $email,
            'token' => hash('sha256', $token),
            'created_at' => date('d-m-Y H:i:s'),
        ]);

        $objet = $administrateur ? 'Réinitialisation de votre compte e-Création' : 'Réinitialisation de votre mot de passe e-Création';
        $donnees = [
            'token' => $token,
            'dureeMinutes' => self::DUREE_MINUTES,
            'parAdministrateur' => (bool) $administrateur,
            'nom' => trim(($user->prenom ?? '').' '.$user->name),
        ];
        try {
            Mail::send(['html' => 'auth.forgetPassword', 'text' => 'emails.texte.mot_de_passe'], $donnees, function ($message) use ($email, $objet) {
                $message->to($email)->subject($objet);
            });
        } catch (\Throwable $e) {
            report($e);
            EnvoiMail::noter('mot_de_passe', $email, $objet, $e);
            DB::table('password_resets')->where('email', $email)->delete();
            return self::ECHEC;
        }
        EnvoiMail::noter('mot_de_passe', $email, $objet);

        return self::ENVOYE;
    }
}
