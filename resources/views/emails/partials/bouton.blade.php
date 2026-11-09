{{-- Bouton d'action (compatible Outlook), suivi du lien en clair sauf si $boutonSeul est vrai --}}
<table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 auto;">
    <tr>
        <td align="center" style="border-radius:6px; background:#1b6b3a;">
            <a href="{{ $lien }}" style="display:inline-block; padding:12px 26px; color:#ffffff; font-weight:bold; font-size:15px; text-decoration:none; border-radius:6px;">{{ $libelle }}</a>
        </td>
    </tr>
</table>
@empty($boutonSeul)
    <p style="margin:10px 0 0; text-align:center; font-size:12px; color:#8a948f; word-break:break-all;">
        Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br>
        <a href="{{ $lien }}" style="color:#1b6b3a;">{{ $lien }}</a>
    </p>
@endempty
