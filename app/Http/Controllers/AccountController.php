<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\EnvoiMail;
use App\Models\ResetPassword;
use App\Models\User;

/**
 * Mot de passe oublié : envoi d'un lien de réinitialisation puis saisie du nouveau mot de passe.
 * Le jeton n'est conservé en base que sous forme d'empreinte (SHA-256) et expire au bout de DUREE_MINUTES.
 */
class AccountController extends Controller
{
    public const DUREE_MINUTES = 60;
    private const DELAI_RENVOI_SECONDES = 60;

    public function showResetPasswordForm($token) {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function showForgetPasswordForm($token){
        return view('auth.reset-password', ['token' => $token]);
    }

    public function validatePasswordRequest(Request $request){
        $request->validate(['email' => 'required|email|max:255'], [
            'email.required' => 'Saisissez l’adresse e-mail de votre compte.',
            'email.email' => 'Cette adresse e-mail n’est pas valide.',
            'email.max' => 'L’adresse e-mail est trop longue.',
        ]);
        $email = mb_strtolower(trim($request->email));
        // Même message que le compte existe ou non : on ne révèle pas quelles adresses ont un compte
        // (fonction : with() enregistre le message en session dès l'appel)
        $reponse = fn () => back()->with('success', 'Si un compte existe avec l’adresse '.$email.', un lien de réinitialisation vient d’y être envoyé. '
            .'Il est valable '.self::DUREE_MINUTES.' minutes. Pensez à regarder dans les courriers indésirables.');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return $reponse();
        }

        // Un seul envoi par minute et par adresse
        $dernier = DB::table('password_resets')->where('email', $email)->max('created_at');
        if ($dernier && Carbon::parse($dernier)->addSeconds(self::DELAI_RENVOI_SECONDES)->isFuture()) {
            return $reponse();
        }

        $token = Str::random(64);
        DB::table('password_resets')->where('email', $email)->delete();
        ResetPassword::create([
            'email' => $email,
            'token' => hash('sha256', $token),
            'created_at' => date('d-m-Y H:i:s'),
        ]);

        $objet = 'Réinitialisation de votre mot de passe e-Création';
        try {
            Mail::send(['html' => 'auth.forgetPassword', 'text' => 'emails.texte.mot_de_passe'], ['token' => $token, 'dureeMinutes' => self::DUREE_MINUTES], function ($message) use ($email, $objet) {
                $message->to($email)->subject($objet);
            });
        } catch (\Throwable $e) {
            report($e);
            EnvoiMail::noter('mot_de_passe', $email, $objet, $e);
            DB::table('password_resets')->where('email', $email)->delete();
            return back()->with('error', 'L’e-mail de réinitialisation n’a pas pu être envoyé. Réessayez dans quelques minutes.');
        }
        EnvoiMail::noter('mot_de_passe', $email, $objet);

        return $reponse();
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'token.required' => 'Le lien de réinitialisation est incomplet. Utilisez le lien reçu par e-mail.',
            'email.required' => 'Saisissez l’adresse e-mail de votre compte.',
            'email.email' => 'Cette adresse e-mail n’est pas valide.',
            'password.required' => 'Saisissez le nouveau mot de passe.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les deux mots de passe ne sont pas identiques.',
        ]);
        $email = mb_strtolower(trim($request->email));
        $invalide = fn () => back()->withInput($request->only('email'))
            ->with('error', 'Ce lien de réinitialisation n’est pas valide ou a expiré (il est valable '.self::DUREE_MINUTES.' minutes). '
                .'Faites une nouvelle demande depuis « Mot de passe oublié ? ».');

        $demande = DB::table('password_resets')->where('email', $email)->orderBy('created_at', 'desc')->first();
        if (!$demande || !hash_equals((string) $demande->token, hash('sha256', $request->token))) {
            return $invalide();
        }
        if (Carbon::parse($demande->created_at)->addMinutes(self::DUREE_MINUTES)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            return $invalide();
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return $invalide();
        }
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect()->route('index')->with('success', 'Votre mot de passe a été modifié. Vous pouvez maintenant vous connecter.');
    }

    public function getlogin(){
        return redirect()->route('index');
    }
}
