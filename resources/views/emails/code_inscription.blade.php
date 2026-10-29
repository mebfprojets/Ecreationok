<!DOCTYPE html>
<html lang="fr">
<head><meta charset="utf-8"><title>Code de vérification</title></head>
<body style="margin:0; padding:24px; background:#f4f6f5; font-family:Arial, Helvetica, sans-serif; color:#2b2b2b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:520px; margin:0 auto; background:#ffffff; border-radius:10px; border-top:6px solid #1b6b3a;">
        <tr>
            <td style="padding:28px;">
                <h1 style="font-size:20px; margin:0 0 12px;">Vérification de votre adresse e-mail</h1>
                <p style="margin:0 0 16px; line-height:1.5;">
                    Vous créez un compte sur la plateforme <strong>e-Création</strong> de la Maison de l’Entreprise du Burkina Faso.
                    Saisissez le code ci-dessous dans le formulaire d’inscription :
                </p>
                <p style="text-align:center; margin:24px 0;">
                    <span style="display:inline-block; font-size:32px; font-weight:bold; letter-spacing:8px; padding:12px 20px; background:#eef7f1; border:1px dashed #1b6b3a; border-radius:8px; color:#1b6b3a;">{{ $code }}</span>
                </p>
                <p style="margin:0 0 8px; line-height:1.5;">Ce code est valable <strong>{{ $dureeMinutes }} minutes</strong>.</p>
                <p style="margin:0; line-height:1.5; color:#666; font-size:13px;">
                    Si vous n’êtes pas à l’origine de cette demande, ignorez simplement ce message : aucun compte ne sera créé.
                    Ne communiquez jamais ce code à personne.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
