<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre') — e-Création</title>
    <style>
        :root { --primary: #1b6b3a; --text: #2b2b2b; --muted: #666; --bg: #f4f6f5; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
               font-family: Arial, Helvetica, sans-serif; background: var(--bg); color: var(--text); padding: 16px; }
        .carte { max-width: 560px; width: 100%; background: #fff; border-radius: 10px; padding: 32px;
                 border-top: 6px solid var(--primary); box-shadow: 0 4px 14px rgba(0, 0, 0, .08); text-align: center; }
        .code { font-size: 14px; color: var(--muted); letter-spacing: .08em; margin: 0 0 8px; }
        h1 { font-size: 22px; margin: 0 0 12px; }
        p { color: var(--muted); line-height: 1.5; margin: 0 0 24px; }
        .actions a { display: inline-block; margin: 4px; padding: 10px 18px; border-radius: 6px; text-decoration: none;
                     background: var(--primary); color: #fff; font-size: 15px; }
        .actions a.secondaire { background: #e9ecea; color: var(--text); }
    </style>
</head>
<body>
    <div class="carte">
        <p class="code">Erreur @yield('code')</p>
        <h1>@yield('titre')</h1>
        <p>@yield('message')</p>
        <div class="actions">
            <a href="{{ url('/') }}">Retour à l'accueil</a>
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="secondaire">Page précédente</a>
        </div>
    </div>
</body>
</html>
