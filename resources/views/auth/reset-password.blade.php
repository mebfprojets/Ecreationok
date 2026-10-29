@extends('layouts.frontend')
@section('content')
<div class="container my-4">
    <div class="card shadow-sm mx-auto fenetre-compte" style="max-width: 520px; border-top: 4px solid #1b6b3a;">
        <form action="{{ route('reset.password.post') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="card-body p-4">
                <h3 class="modal-title mb-1"><i class="fas fa-key me-2" aria-hidden="true"></i>Nouveau mot de passe</h3>
                <p class="small text-muted mb-4">Saisissez l’adresse e-mail de votre compte puis choisissez un nouveau mot de passe.</p>

                <div class="champ">
                    <label class="form-label" for="reset_email">Adresse e-mail</label>
                    <input id="reset_email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                           placeholder="Exemple : nom@gmail.com" required autocomplete="username">
                </div>

                <div class="champ">
                    <label class="form-label" for="reset_password">Nouveau mot de passe</label>
                    <input id="reset_password" class="form-control" type="password" name="password" placeholder="8 caractères minimum"
                           minlength="8" required autocomplete="new-password">
                </div>

                <div class="champ">
                    <label class="form-label" for="reset_password_confirmation">Confirmer le mot de passe</label>
                    <input id="reset_password_confirmation" class="form-control" type="password" name="password_confirmation"
                           placeholder="Saisissez à nouveau le mot de passe" minlength="8" required autocomplete="new-password">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success fw-semibold">
                        <i class="fas fa-check me-1" aria-hidden="true"></i>Enregistrer le mot de passe
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
