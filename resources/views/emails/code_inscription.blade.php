@extends('emails.layout')

@section('titre', 'Code de vérification')
@section('apercu', 'Votre code de vérification e-Création : '.$code.' (valable '.$dureeMinutes.' minutes).')

@section('contenu')
    <p style="margin:0 0 14px;">Bonjour,</p>
    <p style="margin:0 0 18px;">
        Vous créez un compte sur la plateforme <strong>e-Création</strong>.
        Pour confirmer votre adresse e-mail, saisissez ce code dans le formulaire d’inscription :
    </p>

    <table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 auto 18px;">
        <tr>
            <td style="background:#f3f9f5; border:2px dashed #1b6b3a; border-radius:8px; padding:14px 26px; font-size:32px; font-weight:bold; letter-spacing:8px; color:#1b6b3a; font-family:'Courier New', Courier, monospace;">{{ $code }}</td>
        </tr>
    </table>

    <p style="margin:0 0 8px; text-align:center;">Ce code est valable <strong>{{ $dureeMinutes }} minutes</strong>.</p>
    <p style="margin:18px 0 0; font-size:13px; color:#6b7570;">
        Vous n’êtes pas à l’origine de cette demande ? Ignorez simplement ce message : aucun compte ne sera créé.
        Ne communiquez jamais ce code à personne.
    </p>
@endsection
