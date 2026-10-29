{{-- Récapitulatif de la demande (entreprise, numéro, CEFORE, date) --}}
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:0 0 22px; border:1px solid #e3e9e5; border-radius:8px; font-size:14px;">
    <tr>
        <td style="padding:10px 16px; color:#6b7570; width:40%; border-bottom:1px solid #eef2ef;">Entreprise</td>
        <td style="padding:10px 16px; font-weight:bold; border-bottom:1px solid #eef2ef;">{{ $entreprise }}</td>
    </tr>
    @if ($numero)
        <tr>
            <td style="padding:10px 16px; color:#6b7570; border-bottom:1px solid #eef2ef;">N° de demande</td>
            <td style="padding:10px 16px; border-bottom:1px solid #eef2ef;">{{ $numero }}</td>
        </tr>
    @endif
    <tr>
        <td style="padding:10px 16px; color:#6b7570; border-bottom:1px solid #eef2ef;">Centre</td>
        <td style="padding:10px 16px; border-bottom:1px solid #eef2ef;">{{ $cefore }}</td>
    </tr>
    <tr>
        <td style="padding:10px 16px; color:#6b7570;">Date</td>
        <td style="padding:10px 16px;">{{ $date }}</td>
    </tr>
</table>
