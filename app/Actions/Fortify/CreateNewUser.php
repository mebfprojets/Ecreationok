<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Support\CodeInscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * Le compte n'est créé que si le code de vérification envoyé à l'adresse e-mail est correct :
     * l'adresse existe donc et appartient bien à la personne qui s'inscrit.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $validateur = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'code_verification' => ['required', 'digits:6'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'name.required'      => 'Le nom complet est obligatoire.',
            'email.required'     => "L'adresse e-mail est obligatoire.",
            'email.email'        => "Cette adresse e-mail n'est pas valide : vérifiez son orthographe (exemple : nom@gmail.com).",
            'email.unique'       => 'Un compte existe déjà avec cette adresse e-mail.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
            'code_verification.required' => 'Saisissez le code de vérification reçu par e-mail. Sans ce code, le compte ne peut pas être créé.',
            'code_verification.digits'   => 'Le code de vérification comporte 6 chiffres.',
        ]);

        // Le code n'est contrôlé que si le reste du formulaire est correct (évite de consommer un essai pour rien)
        $validateur->after(function ($validateur) use ($input) {
            if ($validateur->errors()->isNotEmpty()) {
                return;
            }
            $erreur = CodeInscription::verifier($input['email'], (string) $input['code_verification']);
            if ($erreur !== null) {
                $validateur->errors()->add('code_verification', $erreur);
            }
        });

        $validateur->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => trim($input['email']),
            'password' => Hash::make($input['password']),
        ]);

        // L'adresse a été prouvée par le code : elle est marquée comme vérifiée, et le code ne peut plus resservir
        $user->forceFill(['email_verified_at' => now()])->save();
        CodeInscription::oublier($input['email']);

        return $user;
    }
}
