@include('partials.frontend.header')
<div>
        @include('partials.frontend.alertes')
        @yield('content')
</div>
  {{-- Style commun aux fenêtres « Se connecter » et « Créer votre compte » --}}
  <style>
    .fenetre-compte .modal-header { align-items: flex-start; border-bottom: 3px solid #1b6b3a; padding: 18px 24px; }
    .fenetre-compte .modal-title { font-size: 1.35rem; font-weight: 700; color: #1b6b3a; text-transform: none; margin: 0 0 2px; }
    .fenetre-compte .modal-body { padding: 20px 24px 8px; }
    .fenetre-compte .modal-footer { padding: 12px 24px 18px; border-top: 1px solid #e6ece8; }
    .fenetre-compte .form-label { font-weight: 600; font-size: .95rem; color: #2b2b2b; margin-bottom: 4px; }
    .fenetre-compte .form-control { height: auto; padding: 10px 12px; font-size: 1rem; color: #212529; }
    .fenetre-compte .form-control::placeholder { color: #9aa3a0; }
    .fenetre-compte .aide { font-size: .85rem; color: #6c757d; margin-top: 4px; }
    .fenetre-compte .champ { margin-bottom: 16px; }
    .fenetre-compte .message-champ { font-size: .85rem; margin-top: 4px; }
    .fenetre-compte .lien-vert { color: #1b6b3a; font-weight: 600; text-decoration: none; }
    .fenetre-compte .lien-vert:hover, .fenetre-compte .lien-vert:focus { text-decoration: underline; }
    .fenetre-compte .form-check-input:checked { background-color: #1b6b3a; border-color: #1b6b3a; }
    .fenetre-compte .ligne-email { display: flex; gap: 8px; flex-wrap: wrap; }
    .fenetre-compte .ligne-email .form-control { flex: 1 1 240px; }
    .fenetre-compte #btn_envoyer_code { white-space: nowrap; font-weight: 600; }
    .fenetre-compte .bloc-code { background: #f3f9f5; border: 1px solid #cfe5d6; border-radius: 8px; padding: 12px 14px; margin-top: 10px; }
    .fenetre-compte #code_verification { max-width: 200px; font-size: 1.3rem; letter-spacing: 6px; text-align: center; font-weight: 700; }
  </style>

  @php $formConnexion = old('_form') === 'login'; @endphp
  <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-titre" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 500px;">
      <div class="modal-content fenetre-compte">
        <form action="{{ route('login') }}" method="post" class="d-flex flex-column" style="min-height: 0; max-height: 100%;">
          @csrf
          <input type="hidden" name="_form" value="login">

          <div class="modal-header">
            <div>
              <h3 class="modal-title" id="modal-login-titre"><i class="fas fa-sign-in-alt me-2" aria-hidden="true"></i>Se connecter</h3>
              <div class="small text-muted">Accédez à votre espace pour suivre vos demandes.</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>

          <div class="modal-body">
            @if ($errors->any() && $formConnexion)
                <div class="alert alert-danger py-2 px-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>{{ $errors->first() }}
                </div>
            @endif

            <div class="champ">
              <label class="form-label" for="login_email">Adresse e-mail</label>
              <input id="login_email" class="form-control" type="email" name="email" value="{{ $formConnexion ? old('email') : '' }}"
                     placeholder="Exemple : nom@gmail.com" required autocomplete="username">
            </div>

            <div class="champ">
              <div class="d-flex justify-content-between align-items-baseline flex-wrap">
                <label class="form-label" for="login_password">Mot de passe</label>
                <a href="#modal-forget-password" class="lien-vert small" data-bs-toggle="modal" data-bs-dismiss="modal">Mot de passe oublié ?</a>
              </div>
              <input id="login_password" class="form-control" type="password" name="password"
                     placeholder="Votre mot de passe" required autocomplete="current-password">
            </div>

            <div class="form-check champ">
              <input class="form-check-input" type="checkbox" id="login-remember-me" name="remember">
              <label class="form-check-label" for="login-remember-me">Rester connecté sur cet appareil</label>
            </div>
          </div>

          <div class="modal-footer">
            <div class="small text-muted me-auto">
              Pas encore de compte ?
              <a href="#modal-create-compte" class="lien-vert" data-bs-toggle="modal" data-bs-dismiss="modal">Créer un compte</a>
            </div>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success fw-semibold">
              <i class="fas fa-sign-in-alt me-1" aria-hidden="true"></i>Se connecter
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-forget-password" tabindex="-1" role="dialog" aria-labelledby="modal-forget-password-titre" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
      <div class="modal-content fenetre-compte">
        <form action="{{ route('password.oubli') }}" method="post">
          @csrf
          <div class="modal-header">
            <div>
              <h3 class="modal-title" id="modal-forget-password-titre"><i class="fas fa-key me-2" aria-hidden="true"></i>Mot de passe oublié</h3>
              <div class="small text-muted">Nous vous enverrons un lien pour choisir un nouveau mot de passe.</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>

          <div class="modal-body">
            <div class="champ">
              <label class="form-label" for="oubli_email">Adresse e-mail de votre compte</label>
              <input id="oubli_email" class="form-control" type="email" name="email" placeholder="Exemple : nom@gmail.com" required autocomplete="email">
              <div class="aide">Le lien est valable 60 minutes. Pensez à regarder dans les courriers indésirables.</div>
            </div>
          </div>

          <div class="modal-footer">
            <a href="#modal-login" class="lien-vert small me-auto" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-arrow-left me-1" aria-hidden="true"></i>Retour à la connexion</a>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success fw-semibold"><i class="fas fa-paper-plane me-1" aria-hidden="true"></i>Envoyer le lien</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-verifier-nomCommercial" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        
        <div class="modal-header">
          <h3 class="text-center" style="margin-left: 200px" id="modal-login-label"> Vérification de nom commercial <i class="fa fa-key"></i></h3>
            
          <button type="button" class="close" data-bs-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
            
            <div class="col-md-10 form-login">
            <form role="form" class="login-form">
                @csrf
                <div class="form-group" >
                  <label class="control-label login-label" for="val_username">Entrez le nom commercial: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="nom_commercial" placeholder="Entrez le nom commercial" class="form-control input-lg" type="text" name="name" required />
                      </div>
              </div>
              <div id="loading" style="display: none;">Vérification en cours...</div>
                  <p id='pNomdisponible' style="color:green; display:none"> Ce Nom commercial est disponible</p>
                  <p id='pNomindisponible' style="color:red; display:none"> Ce Nom commercial n'est pas disponible</p>
                <div class="text-center">
                  <input type="reset" class="btn btn-danger"  value="Annuler">
                  <input   class="btn btn-success"  value="Valider" data-csp-click="verifier_nom_commercial" data-csp-click-args='["nom_commercial"]'>
                </div>
                        
                  </a>
              </form> 
            </div>
                 
              </div>
      
          
                
        </div>
        
      </div>
    </div>
</div>
  {{-- Création de compte : l'adresse e-mail est vérifiée par un code avant la création --}}
  @php
      $formInscription = old('_form') === 'register';
      $codeDejaEnvoye = $formInscription && old('email');
  @endphp
  <div class="modal fade" id="modal-create-compte" tabindex="-1" role="dialog" aria-labelledby="modal-create-compte-titre" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 580px;">
      <div class="modal-content fenetre-compte">
        <form action="{{ route('register') }}" method="post" class="d-flex flex-column" style="min-height: 0; max-height: 100%;">
          @csrf
          <input type="hidden" name="_form" value="register">

          <div class="modal-header">
            <div>
              <h3 class="modal-title" id="modal-create-compte-titre"><i class="fas fa-user-plus me-2" aria-hidden="true"></i>Créer votre compte</h3>
              <div class="small text-muted">Tous les champs sont obligatoires.</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>

          <div class="modal-body">
            @if ($errors->any() && $formInscription)
                <div class="alert alert-danger py-2 px-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>
                    @if ($errors->count() === 1)
                        {{ $errors->first() }}
                    @else
                        Le compte n’a pas pu être créé :
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $erreur)
                                <li>{{ $erreur }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            <div class="champ">
              <label class="form-label" for="name_cc">Nom complet</label>
              <input id="name_cc" class="form-control" type="text" name="name" value="{{ $formInscription ? old('name') : '' }}"
                     placeholder="Exemple : OUEDRAOGO Awa" required autocomplete="name">
            </div>

            <div class="champ">
              <label class="form-label" for="email_cc">Adresse e-mail</label>
              <div class="ligne-email">
                <input id="email_cc" class="form-control" type="email" name="email" value="{{ $formInscription ? old('email') : '' }}"
                       placeholder="Exemple : nom@gmail.com" required autocomplete="email" aria-describedby="aide_email email_existe code_statut"
                       data-csp-input="saisie_email_inscription" data-csp-change="saisie_email_inscription">
                <button type="button" id="btn_envoyer_code" class="btn btn-success d-none" data-csp-click="envoyer_code_inscription">
                  <i class="fas fa-paper-plane me-1" aria-hidden="true"></i>
                  <span class="libelle">{{ $codeDejaEnvoye ? 'Renvoyer le code' : 'Vérifier l’adresse' }}</span>
                </button>
              </div>
              <div id="aide_email" class="aide">Nous vous enverrons un code à 6 chiffres pour confirmer que cette adresse vous appartient.</div>
              <div id="email_existe" class="message-champ text-danger" role="alert" style="display:none">
                <i class="fas fa-exclamation-circle me-1" aria-hidden="true"></i>
                Un compte existe déjà avec cette adresse e-mail.
                <a href="#modal-login" data-bs-toggle="modal" data-bs-dismiss="modal" class="text-danger fw-semibold">Se connecter</a>
              </div>
              <div id="code_statut" class="message-champ mt-2" role="status" style="display:none"></div>

              <div id="bloc_code" class="bloc-code" @unless($codeDejaEnvoye) style="display:none" @endunless>
                <label class="form-label" for="code_verification">Code reçu par e-mail</label>
                <input id="code_verification" name="code_verification" class="form-control" type="text" inputmode="numeric"
                       autocomplete="one-time-code" pattern="[0-9]{6}" data-chiffres-max="6" data-csp-input="__chiffres"
                       placeholder="______" title="Saisissez le code à 6 chiffres reçu par e-mail" required>
                <div class="aide">Le code est valable 10 minutes. Vous ne le trouvez pas ? Regardez dans les courriers indésirables (spam).</div>
              </div>
            </div>

            <div class="champ">
              <label class="form-label" for="password_cc">Mot de passe</label>
              <input id="password_cc" class="form-control" type="password" name="password" placeholder="8 caractères minimum"
                     required autocomplete="new-password" aria-describedby="mot_de_passe" data-csp-input="verifier_password">
              <div id="mot_de_passe" class="message-champ text-danger" role="alert" style="display:none">
                <i class="fas fa-exclamation-circle me-1" aria-hidden="true"></i>
                Le mot de passe doit contenir au moins 8 caractères.
              </div>
            </div>

            <div class="champ">
              <label class="form-label" for="password_confirmation_cc">Confirmer le mot de passe</label>
              <input id="password_confirmation_cc" class="form-control" type="password" name="password_confirmation" placeholder="Saisissez à nouveau le mot de passe"
                     required autocomplete="new-password" aria-describedby="mots_de_passe_differents" data-csp-input="verifier_password">
              <div id="mots_de_passe_differents" class="message-champ text-danger" role="alert" style="display:none">
                <i class="fas fa-exclamation-circle me-1" aria-hidden="true"></i>
                Les deux mots de passe ne sont pas identiques.
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <div id="aide_creer_compte" class="small text-muted w-100 text-end"@if($codeDejaEnvoye) style="display:none" @endif>
              <i class="fas fa-info-circle me-1" aria-hidden="true"></i>Vérifiez d’abord votre adresse e-mail.
            </div>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" id="btn_creer_compte" class="btn btn-success fw-semibold" @unless($codeDejaEnvoye) disabled @endunless>
              <i class="fas fa-user-check me-1" aria-hidden="true"></i>Créer mon compte
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@yield('modal_parpage')
@include('partials.frontend.footer')
@if (session('ouvrir_connexion') && !Auth::check())
<script nonce="{{ $cspNonce ?? '' }}">
    // Session expirée pour inactivité : la fenêtre de connexion s'ouvre directement
    $(function () { $('#modal-login').modal('show'); });
</script>
@endif
@if ($errors->any() && in_array(old('_form'), ['login', 'register'], true))
<script nonce="{{ $cspNonce ?? '' }}">
    $(function () {
        $('#{{ old('_form') === 'login' ? 'modal-login' : 'modal-create-compte' }}').modal('show');
    });
</script>
@endif
