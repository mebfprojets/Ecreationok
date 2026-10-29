@extends('emails.layout')

@section('titre', 'Votre demande a été validée')
@section('apercu', 'Le '.$cefore.' a validé votre demande « '.$entreprise.' ». Prochaine étape : déposer le dossier physique.')

@section('bandeau')
    <div style="background:#e7f4ec; border-bottom:1px solid #cfe5d6; padding:14px 28px; color:#1b6b3a; font-weight:bold; font-size:15px;">
        &#10004;&nbsp; Demande validée
    </div>
@endsection

@section('contenu')
    <p style="margin:0 0 14px;">Bonjour {{ $nomComplet }},</p>
    <p style="margin:0 0 20px;">
        Bonne nouvelle : le <strong>{{ $cefore }}</strong> a étudié votre demande de création d’entreprise et l’a <strong>validée</strong>.
    </p>

    @include('emails.partials.recapitulatif')

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:0 0 22px;">
        <tr>
            <td style="background:#f3f9f5; border-left:4px solid #1b6b3a; border-radius:6px; padding:14px 16px;">
                <div style="font-weight:bold; margin-bottom:6px;">Prochaine étape</div>
                Présentez-vous au <strong>{{ $cefore }}</strong> avec le <strong>dossier physique</strong>
                (les originaux des pièces transmises en ligne) pour la suite du traitement.
                Vous serez informé(e) de l’avancement de vos formalités.
            </td>
        </tr>
    </table>

    @include('emails.partials.bouton', ['lien' => $lien, 'libelle' => 'Suivre ma demande'])

    <p style="margin:22px 0 0; font-size:13px; color:#6b7570;">
        Vous pouvez suivre votre demande à tout moment dans l’espace « Mes demandes » de la plateforme.
    </p>
@endsection
