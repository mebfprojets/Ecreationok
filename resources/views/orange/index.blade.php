@extends('layouts.frontend')
@section('content')
@include('demande.partials.styles')

@php
    $demande = $demande ?? \App\Models\Demande::find($demande_id);
    $montantEntier = (int) round((float) $montant);
    $codeUssd = '*144*4*6*'.$montantEntier.'#';
@endphp

<div class="ed-page ed-page-etroite">
    <a href="{{ route('demande.liste') }}" class="d-inline-block mb-3 text-decoration-none">
        <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Mes demandes
    </a>
    <h1 class="ed-titre h3">Paiement de votre demande</h1>
    <p class="ed-sous-titre mb-3">Réglez les frais pour que votre demande soit transmise au CEFORE.</p>

    @include('demande.partials.paiement_recap', ['demande' => $demande])

    <h2 class="h5 fw-bold mt-4 mb-3">Choisissez votre moyen de paiement</h2>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="ed-paiement-option orange" data-carte-cliquable>
                <img src="{{ asset('frontend/images/OM.png') }}" alt="">
                <h3>Orange Money</h3>
                <p>Générez un code de paiement (OTP) sur votre téléphone, puis saisissez-le ici.</p>
                <button type="button" class="btn btn-orange w-100" data-action-principale data-bs-toggle="collapse" data-bs-target="#paiement-orange"
                        aria-expanded="false" aria-controls="paiement-orange">
                    Payer avec Orange Money
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ed-paiement-option moov" data-carte-cliquable>
                <img src="{{ asset('frontend/images/Moov.png') }}" alt="">
                <h3>Moov Money</h3>
                <p>Saisissez votre numéro : un code de confirmation vous sera envoyé par Moov Money.</p>
                <form action="{{ route('moov.index') }}" method="POST" data-envoi-unique>
                    @csrf
                    <input type="hidden" name="id" value="{{ $demande_id }}">
                    <input type="hidden" name="numero_command" value="{{ $command }}">
                    <button type="submit" class="btn btn-moov w-100" data-action-principale data-libelle-envoi="Chargement…">Payer avec Moov Money</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Paiement Orange Money --}}
    <div class="collapse mt-3" id="paiement-orange">
        <section class="ed-carte" style="--accent-paiement: #ff7900;">
            <div class="ed-carte-entete">
                <h2><img src="{{ asset('frontend/images/OM.png') }}" alt="" width="28" height="28" class="me-2">Paiement par Orange Money</h2>
            </div>
            <div class="ed-carte-corps">
                <form action="{{ route('orange.store') }}" method="POST" data-envoi-unique>
                    @csrf
                    <input type="hidden" name="id" value="{{ $demande_id }}">
                    <input type="hidden" name="command" value="{{ $command }}">
                    <input type="hidden" name="montant" value="{{ $montant }}">

                    <ol class="ed-etapes-paiement">
                        <li>
                            <strong>Composez ce code sur votre téléphone Orange</strong> pour générer votre code de paiement (OTP) :
                            <div>
                                <span class="ed-ussd">
                                    <code>{{ $codeUssd }}</code>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-csp-click="__copier"
                                            data-copier="{{ $codeUssd }}" data-libelle-copie="Copié ✓">
                                        <i class="far fa-copy me-1" aria-hidden="true"></i> Copier
                                    </button>
                                </span>
                            </div>
                        </li>
                        <li>
                            <label for="numero_orange" class="form-label fw-bold mb-1">Numéro Orange Money</label>
                            <div class="text-muted small mb-2">Le numéro de téléphone qui a généré le code OTP (8 chiffres, sans espace).</div>
                            <input type="tel" id="numero_orange" name="numero" class="form-control" inputmode="numeric"
                                   autocomplete="tel" data-chiffres-max="8" pattern="[0-9]{8}"
                                   title="Saisissez les 8 chiffres du numéro, sans espace" data-csp-input="__chiffres" required>
                        </li>
                        <li>
                            <label for="otp_orange" class="form-label fw-bold mb-1">Code OTP</label>
                            <div class="text-muted small mb-2">Le code reçu par SMS après avoir composé le code ci-dessus.</div>
                            <input type="text" id="otp_orange" name="otp" class="form-control" inputmode="numeric"
                                   autocomplete="one-time-code" maxlength="10" required>
                        </li>
                    </ol>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#paiement-orange">Annuler</button>
                        <button type="submit" class="btn btn-orange" data-libelle-envoi="Paiement en cours…">
                            <i class="fas fa-lock me-1" aria-hidden="true"></i> Payer {{ number_format($montantEntier, 0, ',', ' ') }} FCFA
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
