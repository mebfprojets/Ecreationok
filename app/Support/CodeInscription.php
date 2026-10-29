<?php

namespace App\Support;

use App\Mail\CodeVerificationInscription;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

/**
 * Code de vérification envoyé par e-mail avant la création d'un compte :
 * il prouve que l'adresse existe et appartient bien à la personne qui s'inscrit.
 *
 * Le code n'est jamais stocké en clair (empreinte HMAC), il expire après 10 minutes
 * et devient inutilisable après 5 essais erronés.
 */
class CodeInscription
{
    public const DUREE_MINUTES = 10;
    public const ESSAIS_MAX = 5;
    public const DELAI_RENVOI_SECONDES = 60;

    private static function cle(string $email): string
    {
        return 'inscription_code:'.sha1(mb_strtolower(trim($email)));
    }

    private static function empreinte(string $code): string
    {
        return hash_hmac('sha256', $code, (string) config('app.key'));
    }

    /** Secondes à attendre avant de pouvoir redemander un code (0 = possible tout de suite). */
    public static function attenteRestante(string $email): int
    {
        $jusqua = Cache::get(self::cle($email).':renvoi');

        return $jusqua ? max(0, $jusqua - time()) : 0;
    }

    /**
     * Génère et envoie un nouveau code. Lève une exception si l'e-mail n'a pas pu partir :
     * dans ce cas rien n'est enregistré et l'usager peut redemander un code immédiatement.
     */
    public static function envoyer(string $email): void
    {
        $email = mb_strtolower(trim($email));
        $code = (string) random_int(100000, 999999);
        $expiration = time() + self::DUREE_MINUTES * 60;

        Mail::to($email)->send(new CodeVerificationInscription($code, self::DUREE_MINUTES));

        Cache::put(self::cle($email), ['empreinte' => self::empreinte($code), 'essais' => 0, 'expiration' => $expiration],
            now()->addMinutes(self::DUREE_MINUTES));
        Cache::put(self::cle($email).':renvoi', time() + self::DELAI_RENVOI_SECONDES, now()->addSeconds(self::DELAI_RENVOI_SECONDES));
    }

    /** Vérifie le code saisi. Retourne null s'il est valide, sinon le message d'erreur à afficher. */
    public static function verifier(string $email, string $code): ?string
    {
        $cle = self::cle($email);
        $donnees = Cache::get($cle);

        if (! $donnees || $donnees['expiration'] < time()) {
            return 'Le code de vérification a expiré ou n’a pas été demandé pour cette adresse. Demandez un nouveau code.';
        }
        if ($donnees['essais'] >= self::ESSAIS_MAX) {
            Cache::forget($cle);

            return 'Trop de codes erronés. Demandez un nouveau code de vérification.';
        }
        if (! hash_equals($donnees['empreinte'], self::empreinte(trim($code)))) {
            $donnees['essais']++;
            Cache::put($cle, $donnees, max(1, $donnees['expiration'] - time()));
            $restants = self::ESSAIS_MAX - $donnees['essais'];

            return 'Le code de vérification est incorrect.'
                .($restants > 0 ? ' Il vous reste '.$restants.' essai'.($restants > 1 ? 's' : '').'.' : ' Demandez un nouveau code.');
        }

        return null;
    }

    /** Le code a servi : il ne peut plus être réutilisé. */
    public static function oublier(string $email): void
    {
        Cache::forget(self::cle($email));
    }
}
