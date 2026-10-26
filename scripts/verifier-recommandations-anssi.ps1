<#
.SYNOPSIS
    Vérifie depuis l'extérieur la correction des vulnérabilités du rapport ANSSI (creerentreprise.me.bf).

.DESCRIPTION
    Contrôles effectués :
      VUL-002  Certificat TLS valide (jours restants)
      VUL-003  Seuls les ports 80/443 sont ouverts       (à lancer depuis un réseau EXTÉRIEUR)
      VUL-010  Plus de Bootstrap 3/4 chargé ni accessible
      VUL-011  web.config / .env / fichiers sensibles inaccessibles
      VUL-012  jQuery UI >= 1.13.2 chargé, anciennes copies inaccessibles
      + contrôles de non-régression : VUL-001, VUL-006, VUL-007, VUL-008

    Un rapport texte horodaté est enregistré à côté du script (preuve pour le rapport de suivi).

.EXAMPLE
    powershell -ExecutionPolicy Bypass -File .\scripts\verifier-recommandations-anssi.ps1

.EXAMPLE
    powershell -ExecutionPolicy Bypass -File .\scripts\verifier-recommandations-anssi.ps1 -SansPorts
#>
param(
    [string]$Url = 'https://creerentreprise.me.bf',
    [string]$PageAccueil = '/',
    [switch]$SansPorts
)

$ErrorActionPreference = 'Stop'
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
$Url = $Url.TrimEnd('/')
$hote = ([Uri]$Url).Host
$resultats = New-Object System.Collections.Generic.List[object]

function Ajouter($vul, $controle, $ok, $detail) {
    $statut = if ($ok -eq $true) { 'OK' } elseif ($ok -eq $false) { 'A CORRIGER' } else { 'INFO' }
    $resultats.Add([pscustomobject]@{ VUL = $vul; Controle = $controle; Statut = $statut; Detail = $detail })
    $couleur = @{ 'OK' = 'Green'; 'A CORRIGER' = 'Red'; 'INFO' = 'Yellow' }[$statut]
    Write-Host ("  [{0,-10}] {1} {2}" -f $statut, $controle, $(if ($detail) { "-> $detail" })) -ForegroundColor $couleur
}

# Code HTTP sans suivre les redirections (curl.exe est fourni avec Windows 10/11)
function CodeHttp($chemin) {
    (curl.exe -s -o NUL -w '%{http_code}' --max-time 20 "$Url$chemin") -as [int]
}

function Telecharger($u) {
    if ($u.StartsWith('//')) { $u = 'https:' + $u }
    elseif ($u -notmatch '^https?://') { $u = $Url + '/' + $u.TrimStart('/') }
    $txt = curl.exe -s -L --max-time 30 $u
    if ($null -eq $txt) { $txt = '' } elseif ($txt -is [array]) { $txt = $txt -join "`n" }
    return @{ Url = $u; Contenu = [string]$txt }
}

Write-Host "`nVérification de $Url  ($(Get-Date -Format 'dd/MM/yyyy HH:mm'))`n" -ForegroundColor Cyan

# ---------------------------------------------------------------- VUL-002
Write-Host 'VUL-002  Certificat TLS' -ForegroundColor Cyan
if (([Uri]$Url).Scheme -ne 'https') {
    Ajouter 'VUL-002' 'Certificat TLS' $null 'ignoré (URL en http)'
} else { try {
    $tcp = New-Object Net.Sockets.TcpClient($hote, 443)
    $ssl = New-Object Net.Security.SslStream($tcp.GetStream(), $false, { $true })
    $ssl.AuthenticateAsClient($hote)
    $cert = New-Object Security.Cryptography.X509Certificates.X509Certificate2($ssl.RemoteCertificate)
    $chaineOk = (New-Object Security.Cryptography.X509Certificates.X509Chain).Build($cert)
    $jours = [int]($cert.NotAfter - (Get-Date)).TotalDays
    Ajouter 'VUL-002' 'Certificat valide et reconnu' ($chaineOk -and $jours -gt 0) ("expire le {0:dd/MM/yyyy} ({1} jours)" -f $cert.NotAfter, $jours)
    if ($jours -le 30 -and $jours -gt 0) { Ajouter 'VUL-002' 'Renouvellement proche' $null 'moins de 30 jours restants' }
    $ssl.Dispose(); $tcp.Close()
} catch { Ajouter 'VUL-002' 'Certificat TLS' $false $_.Exception.Message } }

# ---------------------------------------------------------------- VUL-003
Write-Host "`nVUL-003  Ports exposés" -ForegroundColor Cyan
if ($SansPorts) {
    Ajouter 'VUL-003' 'Scan des ports' $null 'ignoré (-SansPorts)'
} else {
    Write-Host '  (à lancer depuis un réseau extérieur : 4G, autre FAI... pas depuis le VPN ni le réseau interne)' -ForegroundColor DarkGray
    $autorises = 80, 443
    foreach ($port in 21, 22, 53, 80, 135, 139, 443, 445, 1433, 3306, 3389, 5985, 5986) {
        $client = New-Object Net.Sockets.TcpClient
        $ouvert = $false
        try { $ouvert = $client.ConnectAsync($hote, $port).Wait(3000) -and $client.Connected } catch {}
        $client.Close()
        if ($autorises -contains $port) {
            Ajouter 'VUL-003' "Port $port" $null $(if ($ouvert) { 'ouvert (attendu)' } else { 'fermé' })
        } else {
            Ajouter 'VUL-003' "Port $port" (-not $ouvert) $(if ($ouvert) { 'OUVERT sur Internet' } else { 'filtré/fermé' })
        }
    }
}

# ---------------------------------------------------------------- VUL-011
Write-Host "`nVUL-011  Fichiers sensibles" -ForegroundColor Cyan
foreach ($chemin in '/web.config', '/.env', '/.git/config', '/composer.json', '/backend/libs/gmaps/yarn-error.log') {
    $code = CodeHttp $chemin
    Ajouter 'VUL-011' $chemin ($code -in 401, 403, 404, 410) "HTTP $code"
}

# ---------------------------------------------------------------- VUL-010 / VUL-012
Write-Host "`nVUL-010 / VUL-012  Librairies chargées par $PageAccueil" -ForegroundColor Cyan
$html = (Telecharger $PageAccueil).Contenu
if (-not $html) {
    Ajouter 'VUL-010' "Lecture de $PageAccueil" $false 'page vide ou inaccessible'
} else {
    $liens = [regex]::Matches($html, '(?:src|href)\s*=\s*["'']([^"'']+)["'']') | ForEach-Object { $_.Groups[1].Value } |
        Where-Object { $_ -match 'bootstrap|jquery-ui|jqueryui' -and $_ -match '\.(js|css)(\?|$)' } | Select-Object -Unique
    $vusBootstrap = 0; $vusUi = 0
    foreach ($lien in $liens) {
        $f = Telecharger $lien
        if (-not $f.Contenu) {
            # Fichier injoignable depuis ce poste : version lue dans l'URL du CDN (ex. bootstrap@4.0.0, jqueryui/1.12.1)
            $vBs = [regex]::Match($lien, '/bootstrap(?:@|/)(\d+\.\d+\.\d+)/')
            $vUi = [regex]::Match($lien, '/(?:jqueryui|ui|jquery-ui)(?:@|/)(\d+\.\d+\.\d+)/')
            if ($vBs.Success) { $vusBootstrap++; $v = [version]$vBs.Groups[1].Value; Ajouter 'VUL-010' "Bootstrap $v (d'après l'URL)" ($v.Major -ge 5) $lien }
            elseif ($vUi.Success) { $vusUi++; $v = [version]$vUi.Groups[1].Value; Ajouter 'VUL-012' "jQuery UI $v (d'après l'URL)" ($v -ge [version]'1.13.2') $lien }
            elseif ($lien -match '/bootstrap(\.bundle)?(\.min)?\.(js|css)(\?|$)') { Ajouter 'VUL-010' 'Bootstrap non vérifiable' $null "injoignable : $lien" }
            elseif ($lien -match 'jquery-ui|jqueryui') { Ajouter 'VUL-012' 'jQuery UI non vérifiable' $null "injoignable : $lien" }
            continue
        }
        $entete = $f.Contenu.Substring(0, [Math]::Min(1500, $f.Contenu.Length))
        # (?<!for\s) : exclut les plugins du type « Datepicker for Bootstrap v1.9.0 »
        $bs = [regex]::Match($entete, '(?<!for\s)\bBootstrap\s+v(\d+\.\d+\.\d+)')
        $ui = [regex]::Match($entete, 'jQuery UI\s*-\s*v(\d+\.\d+\.\d+)')
        if ($bs.Success) {
            $vusBootstrap++
            $v = [version]$bs.Groups[1].Value
            Ajouter 'VUL-010' "Bootstrap $v" ($v.Major -ge 5) $lien
        } elseif ($ui.Success) {
            $vusUi++
            $v = [version]$ui.Groups[1].Value
            Ajouter 'VUL-012' "jQuery UI $v" ($v -ge [version]'1.13.2') $lien
        }
    }
    if (-not $vusBootstrap) { Ajouter 'VUL-010' 'Bootstrap' $null 'aucun fichier Bootstrap avec version détecté' }
    if (-not $vusUi) { Ajouter 'VUL-012' 'jQuery UI' $null 'aucun fichier jQuery UI détecté sur cette page' }
}

Write-Host "`nVUL-010 / VUL-012  Anciennes copies (doivent avoir disparu du serveur)" -ForegroundColor Cyan
$anciens = @(
    @('VUL-010', '/frontend/plugins/bootstrap/bootstrap.min.js'),
    @('VUL-010', '/frontend/plugins/bootstrap/bootstrap.min.css'),
    @('VUL-010', '/frontend/js/vendor/bootstrap.min.js'),
    @('VUL-010', '/frontend/css/bootstrap.min.css'),
    @('VUL-010', '/assets/bootstrap/js/bootstrap.min.js'),
    @('VUL-010', '/css/bootstrap.min.css'),
    @('VUL-010', '/js/bootstrap.min.js'),
    @('VUL-010', '/backend/libs/twitter-bootstrap-wizard/bootstrap/js/bootstrap.min.js'),
    @('VUL-012', '/backend/libs/jquery-ui-dist/jquery-ui.min.js')
)
foreach ($a in $anciens) {
    $code = CodeHttp $a[1]
    Ajouter $a[0] $a[1] ($code -in 403, 404, 410) "HTTP $code"
}

# ---------------------------------------------------------------- Non-régression (vulnérabilités déjà approuvées)
Write-Host "`nNon-régression  En-têtes et cookies" -ForegroundColor Cyan
$entetes = curl.exe -s -D - -o NUL --max-time 20 "$Url$PageAccueil"
$h = @{}; $cookies = @()
foreach ($ligne in $entetes) {
    if ($ligne -match '^([\w-]+):\s*(.*)$') {
        if ($matches[1] -ieq 'Set-Cookie') { $cookies += $matches[2] } else { $h[$matches[1].ToLower()] = $matches[2].Trim() }
    }
}
Ajouter 'VUL-008' 'X-Frame-Options' ([bool]$h['x-frame-options']) $h['x-frame-options']
Ajouter 'VUL-008' 'X-Content-Type-Options: nosniff' ($h['x-content-type-options'] -eq 'nosniff') $h['x-content-type-options']
Ajouter 'VUL-007' 'X-Powered-By masqué' (-not $h['x-powered-by']) $h['x-powered-by']
Ajouter 'VUL-007' 'Server sans version' (-not ($h['server'] -match '\d')) $h['server']
foreach ($c in $cookies) {
    $nom = ($c -split '=')[0]
    Ajouter 'VUL-006' "Cookie $nom : Secure" ($c -match ';\s*secure') $null
    if ($nom -notmatch 'XSRF') { Ajouter 'VUL-006' "Cookie $nom : HttpOnly" ($c -match ';\s*httponly') $null }
}
$code404 = curl.exe -s --max-time 20 "$Url/page-inexistante-verification-anssi"
Ajouter 'VUL-001' 'Pas de trace d''erreur détaillée (APP_DEBUG)' (-not (($code404 -join ' ') -match 'Whoops|Stack trace|vendor[\\/]laravel|SQLSTATE')) $null

# ---------------------------------------------------------------- Synthèse + rapport
$aCorriger = @($resultats | Where-Object Statut -eq 'A CORRIGER')
Write-Host "`n======================================================" -ForegroundColor Cyan
if ($aCorriger.Count -eq 0) {
    Write-Host ' Toutes les vérifications sont OK' -ForegroundColor Green
} else {
    Write-Host " $($aCorriger.Count) point(s) à corriger :" -ForegroundColor Red
    $aCorriger | ForEach-Object { Write-Host "   $($_.VUL)  $($_.Controle)  $($_.Detail)" -ForegroundColor Red }
}
$rapport = Join-Path $PSScriptRoot ("verification-anssi-{0:yyyyMMdd-HHmm}.txt" -f (Get-Date))
"Vérification de $Url le $(Get-Date -Format 'dd/MM/yyyy HH:mm') depuis $env:COMPUTERNAME`n" | Out-File $rapport -Encoding utf8
$resultats | Format-Table -AutoSize -Wrap | Out-String -Width 250 | Out-File $rapport -Append -Encoding utf8
Write-Host " Rapport enregistré : $rapport`n" -ForegroundColor Cyan
