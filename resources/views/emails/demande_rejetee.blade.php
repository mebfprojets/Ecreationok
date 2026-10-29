@extends('emails.layout')

@section('titre', 'Votre demande doit être corrigée')
@section('apercu', 'Le '.$cefore.' vous demande de corriger votre demande « '.$entreprise.' ». Motif : '.\Illuminate\Support\Str::limit($motif, 120))

@section('bandeau')
    <div style="background:#fdf3e1; border-bottom:1px solid #f3dcae; padding:14px 28px; color:#8a5a00; font-weight:bold; font-size:15px;">
        &#9888;&nbsp; Correction demandée
    </div>
@endsection

@section('contenu')
    <p style="margin:0 0 14px;">Bonjour {{ $nomComplet }},</p>
    <p style="margin:0 0 20px;">
        Le <strong>{{ $cefore }}</strong> a étudié votre demande de création d’entreprise.
        Certaines informations ou pièces doivent être <strong>corrigées</strong> avant qu’elle puisse être validée.
    </p>

    @include('emails.partials.recapitulatif')

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:0 0 22px;">
        <tr>
            <td style="background:#fff8ec; border-left:4px solid #e0a100; border-radius:6px; padding:14px 16px;">
                <div style="font-weight:bold; margin-bottom:6px;">Motif indiqué par votre conseiller</div>
                <div style="white-space:pre-line;">{{ $motif }}</div>
            </td>
        </tr>
    </table>

    <div style="font-weight:bold; margin:0 0 8px;">Comment corriger votre demande</div>
    <ol style="margin:0 0 22px; padding-left:20px;">
        <li style="margin-bottom:4px;">Connectez-vous à la plateforme e-Création.</li>
        <li style="margin-bottom:4px;">Ouvrez la demande dans l’espace « Mes demandes ».</li>
        <li style="margin-bottom:4px;">Corrigez les informations ou remplacez les pièces concernées.</li>
        <li>Cliquez sur <strong>« Renvoyer pour traitement »</strong> : votre conseiller sera prévenu.</li>
    </ol>

    @include('emails.partials.bouton', ['lien' => $lien, 'libelle' => 'Corriger ma demande'])
@endsection
