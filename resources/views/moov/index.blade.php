@extends('layouts.frontend')
@section('content')
@include('demande.partials.styles')

@php
    $demande = $demande ?? \App\Models\Demande::find($demande_id);
    $montantEntier = (int) round((float) $montant);
@endphp

<div class="ed-page ed-page-etroite">
    <a href="{{ route('demande.liste') }}" class="d-inline-block mb-3 text-decoration-none">
        <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Mes demandes
    </a>
    <h1 class="ed-titre h3">Paiement par Moov Money</h1>
    <p class="ed-sous-titre mb-3">Deux étapes : votre numéro, puis le code de confirmation reçu sur votre téléphone.</p>

    @include('demande.partials.paiement_recap', ['demande' => $demande])

    <section class="ed-carte mt-3" style="--accent-paiement: #0066b3;">
        <div class="ed-carte-entete">
            <h2><img src="{{ asset('frontend/images/Moov.png') }}" alt="" width="28" height="28" class="me-2">Moov Money</h2>
            <span class="ed-meta">Étape {{ $otp == 1 ? '2' : '1' }} sur 2</span>
        </div>
        <div class="ed-carte-corps">
            @if ($otp == 0)
                <form action="{{ route('moov.store') }}" method="POST" data-envoi-unique>
                    @csrf
                    <input type="hidden" name="id" value="{{ $demande_id }}">
                    <input type="hidden" name="command" value="{{ $command }}">
                    <input type="hidden" name="montant" value="{{ $montant }}">

                    <label for="numero_moov" class="form-label fw-bold mb-1">Numéro Moov Money</label>
                    <div class="text-muted small mb-2">Le numéro du compte Moov Money qui va payer (8 chiffres, sans espace). Un code de confirmation y sera envoyé.</div>
                    <input type="tel" id="numero_moov" name="numero" class="form-control" inputmode="numeric"
                           autocomplete="tel" data-chiffres-max="8" pattern="[0-9]{8}"
                           title="Saisissez les 8 chiffres du numéro, sans espace" data-csp-input="__chiffres" required>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                        <a href="{{ route('demande.liste') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-moov" data-libelle-envoi="Envoi du code…">
                            Recevoir le code de confirmation <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-info py-2">
                    <i class="fas fa-mobile-alt me-1" aria-hidden="true"></i>
                    Un code de confirmation a été envoyé au <strong>{{ $numero }}</strong>.
                </div>
                <form action="{{ route('moov.otp') }}" method="POST" data-envoi-unique>
                    @csrf
                    <input type="hidden" name="id" value="{{ $demande_id }}">
                    <input type="hidden" name="command" value="{{ $requestId }}">
                    <input type="hidden" name="transId" value="{{ $transId }}">
                    <input type="hidden" name="numero" value="{{ $numero }}">

                    <label for="otp_moov" class="form-label fw-bold mb-1">Code de confirmation (OTP)</label>
                    <input type="text" id="otp_moov" name="otp" class="form-control" inputmode="numeric"
                           autocomplete="one-time-code" maxlength="10" required autofocus>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                        <button type="submit" class="btn btn-moov" data-libelle-envoi="Paiement en cours…">
                            <i class="fas fa-lock me-1" aria-hidden="true"></i> Payer {{ number_format($montantEntier, 0, ',', ' ') }} FCFA
                        </button>
                    </div>
                </form>
                <form action="{{ route('moov.index') }}" method="POST" class="mt-2 text-end">
                    @csrf
                    <input type="hidden" name="id" value="{{ $demande_id }}">
                    <button type="submit" class="btn btn-link btn-sm p-0">Changer de numéro</button>
                </form>
            @endif
        </div>
    </section>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
        <form action="{{ route('orange.index') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $demande_id }}">
            <button type="submit" class="btn btn-link p-0"><i class="fas fa-exchange-alt me-1" aria-hidden="true"></i> Choisir un autre moyen de paiement</button>
        </form>
    </div>
</div>
@endsection
