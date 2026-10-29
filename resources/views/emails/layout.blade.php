{{--
    Mise en page commune des e-mails envoyés aux usagers.
    Styles en ligne et tableaux : c'est ce que les messageries (Gmail, Outlook, Yahoo, téléphones) affichent correctement.
    Le logo est joint au message (pièce intégrée) : il s'affiche même quand la messagerie bloque les images externes.
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>@yield('titre')</title>
</head>
<body style="margin:0; padding:0; background:#eef2ef; font-family:Arial, Helvetica, sans-serif; color:#2b2b2b; -webkit-text-size-adjust:100%;">
    {{-- Aperçu affiché par la messagerie sous l'objet --}}
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all;">@yield('apercu')</div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#eef2ef;">
        <tr>
            <td align="center" style="padding:24px 12px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.08);">
                    {{-- En-tête --}}
                    <tr>
                        <td style="background:#1b6b3a; padding:18px 28px;">
                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <tr>
                                    @isset($message)
                                        <td style="padding-right:12px; vertical-align:middle;">
                                            <img src="{{ $message->embed(public_path('frontend/images/logo-me.jpg')) }}" width="44" height="44" alt="MEBF" style="display:block; border-radius:6px; background:#ffffff;">
                                        </td>
                                    @endisset
                                    <td style="vertical-align:middle; color:#ffffff;">
                                        <div style="font-size:19px; font-weight:bold; line-height:1.2;">e-Création</div>
                                        <div style="font-size:12px; opacity:.85; line-height:1.4;">Maison de l’Entreprise du Burkina Faso</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Bandeau de statut (couleur et libellé propres à chaque message) --}}
                    @hasSection('bandeau')
                        <tr>
                            <td style="padding:0;">@yield('bandeau')</td>
                        </tr>
                    @endif

                    {{-- Contenu --}}
                    <tr>
                        <td style="padding:28px; font-size:15px; line-height:1.6;">
                            @yield('contenu')
                        </td>
                    </tr>

                    {{-- Pied --}}
                    <tr>
                        <td style="background:#f6f8f7; border-top:1px solid #e3e9e5; padding:18px 28px; font-size:12px; line-height:1.6; color:#6b7570;">
                            <strong style="color:#2b2b2b;">Besoin d’aide ?</strong>
                            Appelez le (+226) 02 21 21 21 · 58 80 77 77 · 56 62 02 02 ou rendez-vous dans le CEFORE le plus proche.<br>
                            Plateforme : <a href="{{ rtrim(config('app.url'), '/') }}" style="color:#1b6b3a;">{{ preg_replace('#^https?://#', '', rtrim(config('app.url'), '/')) }}</a><br>
                            Ce message vous a été envoyé automatiquement par la plateforme e-Création. Ne communiquez jamais votre mot de passe : nos agents ne vous le demanderont pas.
                        </td>
                    </tr>
                </table>
                <div style="max-width:600px; font-size:11px; color:#8a948f; padding:12px 8px 0; text-align:center;">
                    © {{ date('Y') }} Maison de l’Entreprise du Burkina Faso · Centres de formalités des entreprises (CEFORE)
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
