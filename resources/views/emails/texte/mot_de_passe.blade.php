Bonjour{!! !empty($nom) ? ' '.$nom : '' !!},

@if (!empty($parAdministrateur))
Un administrateur de la plateforme e-Création a lancé la réinitialisation de votre compte.
Pour choisir votre nouveau mot de passe, ouvrez ce lien (valable {!! $dureeMinutes !!} minutes, utilisable une seule fois) :
@else
Vous avez demandé à changer le mot de passe de votre compte sur la plateforme e-Création.
Pour en choisir un nouveau, ouvrez ce lien (valable {!! $dureeMinutes !!} minutes, utilisable une seule fois) :
@endif

{!! route('reset.password.get', $token) !!}

@if (!empty($parAdministrateur))
Votre mot de passe actuel reste valable tant que vous n'en avez pas choisi un nouveau. Si vous n'attendiez pas ce message, contactez l'administrateur de la plateforme.
@else
Vous n'êtes pas à l'origine de cette demande ? Ignorez ce message : votre mot de passe reste inchangé.
@endif

Message automatique de la plateforme e-Création - Maison de l'Entreprise du Burkina Faso.
