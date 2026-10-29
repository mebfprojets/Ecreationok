@extends('emails.layout')

@section('titre', 'Réinitialisation du mot de passe')
@section('apercu', 'Choisissez un nouveau mot de passe pour votre compte e-Création (lien valable '.$dureeMinutes.' minutes).')

@section('contenu')
    <p style="margin:0 0 14px;">Bonjour,</p>
    <p style="margin:0 0 22px;">
        Vous avez demandé à changer le mot de passe de votre compte sur la plateforme <strong>e-Création</strong>.
        Cliquez sur le bouton ci-dessous pour en choisir un nouveau.
    </p>

    @include('emails.partials.bouton', ['lien' => route('reset.password.get', $token), 'libelle' => 'Choisir un nouveau mot de passe'])

    <p style="margin:22px 0 0;">Ce lien est valable <strong>{{ $dureeMinutes }} minutes</strong> et ne peut servir qu’une fois.</p>
    <p style="margin:12px 0 0; font-size:13px; color:#6b7570;">
        Vous n’êtes pas à l’origine de cette demande ? Ignorez ce message : votre mot de passe reste inchangé.
    </p>
@endsection
