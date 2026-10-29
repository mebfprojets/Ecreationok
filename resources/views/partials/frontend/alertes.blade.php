{{-- Messages de retour (succès, erreur, champs invalides) affichés en haut des pages publiques.
     Les erreurs des fenêtres de connexion / inscription sont affichées dans ces fenêtres. --}}
{{-- Une vue qui affiche déjà ses propres messages de session déclare @section('alertes_locales', '1') :
     seules les erreurs de validation sont alors affichées ici. --}}
@php
    $formulaireFenetre = in_array(old('_form'), ['login', 'register'], true);
    $messagesSession = ! View::hasSection('alertes_locales');
@endphp

@if (($messagesSession && (session('success') || session('message') || session('error'))) || ($errors->any() && ! $formulaireFenetre))
<div class="container mt-3" id="alertes-page">
    @if ($messagesSession && (session('success') || session('message')))
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-fermeture-auto="10">
            {{ session('success') ?? session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if ($messagesSession && session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if ($errors->any() && ! $formulaireFenetre)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Le formulaire n’a pas pu être enregistré :</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif
</div>
@endif

{{-- Messages qui se ferment seuls : data-fermeture-auto="<secondes>" (succès uniquement ; les erreurs restent affichées) --}}
<script nonce="{{ $cspNonce ?? '' }}">
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-fermeture-auto]').forEach(function (message) {
            var secondes = parseInt(message.getAttribute('data-fermeture-auto'), 10) || 10;
            setTimeout(function () {
                if (window.bootstrap && bootstrap.Alert) {
                    bootstrap.Alert.getOrCreateInstance(message).close();
                } else {
                    message.remove();
                }
            }, secondes * 1000);
        });
    });
</script>
