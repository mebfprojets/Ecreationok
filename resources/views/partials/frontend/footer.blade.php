
  <footer id="footer" class="footer bg-overlay" style="margin-top: 40px">
    <div class="footer-main">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-5 col-md-6 footer-widget footer-about">
            <h3 class="widget-title">MEBF</h3>
            <img loading="lazy" width="100px" class="footer-logo" src="{{asset('frontend/images/MEBF-CEFORE.JPG')}}" alt="Constra">
            <p>132, Avenue de Lyon, 11 BP 379 OUAGADOUGOU 11,</p>
              {{-- Adresse e-mail encodée en entités HTML, comme dans l'en-tête (ANSSI Vul-009 : pas d'adresse en clair pour les robots) --}}
              <p>BURKINA FASO Tel: 25 39 80 60 Fax: 25 39 80 62 Email: &#105;&#110;&#102;&#111;&#64;&#109;&#101;&#46;&#98;&#102;</p>
            <div class="footer-social" style="margin-bottom:-50px; ">
              <ul>
                <li><a href="https://www.facebook.com/ME.BurkinaFaso" target="_blank" aria-label="Facebook"><i
                      class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://twitter.com/themefisher" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </li>
                <li><a href="https://instagram.com/themefisher" aria-label="Instagram"><i
                      class="fab fa-instagram"></i></a></li>
                <li><a href="https://github.com/themefisher" aria-label="Github"><i class="fab fa-github"></i></a></li>
              </ul>
            </div><!-- Footer social end -->
          </div><!-- Col end -->

          <div class="col-lg-4 col-md-6 footer-widget mt-5 mt-md-0">
            <h3 class="widget-title">Horaires</h3>
            <div class="working-hours">
            <p>Les dépôts en ligne se font 7j/7 et 24h/24.
              Les retraits des documents (RCCM, IFU, CNSS et CPC) se font dans les représentations
              régionales de la MEBF.</p>
              <!-- <br><br> Lundi - Friday: <span class="text-right">10:00 - 16:00 </span>
              <br> Saturday: <span class="text-right">12:00 - 15:00</span>
              <br> Sunday and holidays: <span class="text-right">09:00 - 12:00</span> -->
            </div>
          </div><!-- Col end -->
 
          <div class="col-lg-3 col-md-6 mt-5 mt-lg-0 footer-widget">
            <h3 class="widget-title">Liens Utiles</h3>
            <ul class="list-arrow">
              <li><a href="http://me.bf/" target="_blank">MEBF</a></li>
              <li><a href="https://fichiernationalrccm.bf/" target="_blank">FNRCCM</a></li>
              <li><a href="https://cci.bf/" target="_blank">CCI-BF</a></li>
              <li><a href="https://www.ohada.com/" target="_blank">OHADA</a></li>
            </ul>
          </div><!-- Col end -->
        </div><!-- Row end -->
      </div><!-- Container end -->
    </div><!-- Footer main end -->

    <div class="copyright">
      <div class="container">
        <div class="row align-items-center" style="margin-top:-25px;">
        <center><div class="col-md-6">
           <div class="copyright-info">
              <span>Copyright &copy; <script nonce="{{ $cspNonce ?? '' }}">
                  document.write(new Date().getFullYear())
                </script>, Designed &amp; Developed by <a href="https://themefisher.com">MEBF</a></span>
            </div>

          </div>
          </center>
        </div><!-- Row end -->

        <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top position-fixed">
          <button class="btn btn-primary" title="Back to Top">
            <i class="fa fa-angle-double-up"></i>
          </button>
        </div>

      </div><!-- Container end -->
    </div><!-- Copyright end -->
  </footer><!-- Footer end -->
  <div id='updatepiecejointe'class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Modifier une  pièce jointe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fileUploadForm_u" action="javascript:void(0)" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id='piece_id_u' name="piece_id"  > 
                    <input type="hidden" class='type_doc' name="type_doc"  value=""> 
                    <input type="hidden" class='categorie_piece' name="categorie_piece"  value=""> 

            <div class="row">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" id='type_piece_declaration_u' >
                    <div class="form-group" >
                        <label class=" control-label" for="example-chosen">Type pièce<span class="text-danger">*</span></label>
                            <select  name="type_document" class="form-control  type_document" data-placeholder="selection le type de document" style="width: 100%;">
                                <option></option>
                                <option value="declaration">Declaration sur l'honneur</option>
                                <option value="casier_judiciaire">Casier judiciaire</option>
                            </select>
                    </div>
                        @if ($errors->has('type_piecejointe'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type_piecejointe') }}</strong>
                        </span>
                        @endif
                    
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" id='type_piece_identite_u' style="display: none">
                    <div class="form-group" >
                        <label class="control-label" for="example-chosen">Type pièce <span class="text-danger">*</span></label>
                            <select name="type_document_identite" class="form-control type_document" data-placeholder="selection le type de document" style="width: 100%;"  >
                                <option></option>
                                <option value="cnib">CNIB</option>
                                <option value="passport">Passport</option>
                            </select>

                    </div>
                        @if ($errors->has('type_piecejointe'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type_piecejointe') }}</strong>
                        </span>
                        @endif
                    
                </div>
                <div class="form-group col-md-6">
                    <label class=" control-label" for="val_username">Numéro référence pièce</label>
                        <div class="input-group" >
                            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                            <div class="input-group">
                                <input type="text" id="reference_piece_u" name="numero_ref"  class="form-control" required>
                            </div>
                        </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label class=" control-label" for="val_username">Date d'établissement</label>
                        <div class="input-group" id="datepicker2">
                            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                            <input type="text" id="date_etablissement_u" name="date_detablissment" required class="form-control" placeholder="dd-mm-yyyy"
                             data-date-format="dd-mm-yyyy" data-date-container='#datepicker2' data-provide="datepicker">
                        </div>
                </div>
                <div class="form-group col-md-6">
                    <label class=" control-label" for="val_username">Lieu d'établissment</label>
                        <div class="input-group" >
                            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                            <div class="input-group">
                                <input type="text" id="lieu_etablissement_u" name="lieu_etablissment" class="form-control"  required>
                            </div>
                        </div>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('piece_jointe') ? ' has-error' : '' }}">
                    <label class=" control-label" for="piece_contractuelle">Joindre la piece<span class="text-success">*</span></label>
                    <input class="form-control" type="file" id='piece_jointe_u' name="piece_jointe" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de l'ordre de service" >  
                        @if ($errors->has('piece_jointe'))
                        <span class="help-block">
                            <strong>{{ $errors->first('piece_jointe') }}</strong>
                        </span>
                        
                        @endif
                </div>
                <span class="upload_image"> </span>
            </div> 
            </div>
            <div class="panel-footer text-center">
                <input type="button" data-bs-dismiss="modal"  class="btn btn-sm btn-warning"  value="Fermer la fenetre">
                <input  id='saveData' type="submit"   class="btn btn-sm btn-success"  value="Enregister mes données">
            </div>
            
        </form>
        </div>
    </div>
</div>
<div id='updatepiecejointe_correction'class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg ">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" >Modifier une pièce jointe</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="{{ route('update.pjcorrect') }}" method="POST"  class="form-horizontal form-bordered" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="hidden" id='piece_id_correct' name="piece_id_correct"  > 
          <div class="row">
              <div class="form-group col-md-6">
                  <label class=" control-label" for="val_username">Numéro référence pièce</label>
                      <div class="input-group" >
                          <div class="input-group">
                              <input type="text" id="reference_correct_piece_u" name="numero_ref"  class="form-control" required>
                          </div>
                      </div>
              </div>
              <div class="form-group col-md-6">
                  <label class=" control-label" for="val_username">Date d'établissement</label>
                      <div class="input-group" id="datepicker2">
                          <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                          <input type="text" id="date_etablissement_correct_u" name="date_detablissment" required class="form-control date_piecejointe" placeholder="dd-mm-yyyy"
                           data-date-format="dd-mm-yyyy"  data-provide="datepicker">
                      </div>
              </div>
              <div class="form-group col-md-6">
                  <label class=" control-label" for="val_username">Lieu d'établissment</label>
                      <div class="input-group" >
                          <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                          <div class="input-group">
                              <input type="text" id="lieu_etablissement_correct_u" name="lieu_etablissment" class="form-control"  required>
                          </div>
                      </div>
              </div>
              
          </div>
          <div class="row">
              <div class="form-group{{ $errors->has('piece_jointe') ? ' has-error' : '' }}">
                  <label class=" control-label" for="piece_contractuelle">Joindre la piece<span class="text-success">*</span></label>
                  <input class="form-control" type="file" id='piece_jointe_u' name="piece_jointe" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de l'ordre de service" >  
                      @if ($errors->has('piece_jointe'))
                      <span class="help-block">
                          <strong>{{ $errors->first('piece_jointe') }}</strong>
                      </span>
                      
                      @endif
              </div>
          </div> 
          </div>
          <div class="panel-footer text-center">
              <input type="button" data-bs-dismiss="modal"  class="btn btn-sm btn-warning"  value="Annuler">
              <input  type="submit"   class="btn btn-sm btn-success"  value="Modifier">
          </div>
          
      </form>
      </div>
  </div>
</div>
  {{-- Fenêtres « Pièces à fournir » et « Avant de commencer » : partials/frontend/modales_pieces (page d'accueil) --}}

  <!-- Javascript Files
  ================================================== -->
  <!-- initialize jQuery Library -->
  {{-- <script src="{{asset('frontend/js/vendor/jquery.min.js')}}"></script> --}}

  {{-- <script src="{{asset('frontend/plugins/jQuery/jquery.min.js')}}"></script> --}}
  <!-- Gestionnaires data-csp-* (remplacent les onclick/onchange interdits par la CSP) -->
  <script src="{{asset_version('js/csp-handlers.js')}}"></script>
  <!-- Messages lisibles pour les erreurs des appels AJAX -->
  <script src="{{asset_version('js/erreurs-ajax.js')}}"></script>
  {{-- Rechargement de la page après inactivité (le serveur déconnecte alors l'utilisateur) --}}
  <script src="{{ asset_version('js/inactivite.js') }}"></script>
  <!-- Slick Carousel -->
  <script src="{{asset('frontend/plugins/slick/slick.min.js')}}"></script>
  <script src="{{asset('frontend/plugins/slick/slick-animation.min.js')}}"></script>
  <!-- Color box -->
  <script src="{{asset('frontend/plugins/colorbox/jquery.colorbox.js')}}"></script>
  <!-- shuffle -->
  <script src="{{asset('frontend/plugins/shuffle/shuffle.min.js')}}" defer></script>
  
  {{-- Google Maps retiré : aucune page n'affiche de carte (#map), et la clé d'API était exposée --}}
  <!-- Template custom -->
  <script src="{{asset('frontend/js/login.js')}}"></script>
  <script src="{{asset('frontend/js/script.js')}}"></script>

  
  <!-- Pour test formulaire demande -->
  <!-- <script src="{{asset('frontend/js/plugins.js')}}"></script>
  <script src="{{asset('frontend/js/app.js')}}"></script> -->
  {{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
  {{-- <script src="{{asset('backend/libs/jquery/jquery.min.js')}}"></script> --}}
  {{-- jQuery Validation 1.21.0, hébergé localement (la 1.15.0 du CDN Microsoft avait des failles connues : CVE-2021-21252, CVE-2022-31147) --}}
  <script src="{{ asset('vendor/jquery-validation-1.21.0/jquery.validate.min.js') }}"></script>
  {{-- <script src=https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.2-dev/js/formValidation.min.js></script> --}}


  <script src="{{asset('js/jquery.steps.js')}}"></script>

  <!-- Bootstrap 5.3 (unique, Popper inclus) -->
  <script src="{{asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('backend/libs/metismenu/metisMenu.min.js')}}"></script>
  <script src="{{asset('backend/libs/simplebar/simplebar.min.js')}}"></script>
  <script src="{{asset('backend/libs/node-waves/waves.min.js')}}"></script>
  <script src="{{asset('backend/libs/select2/js/select2.min.js')}}"></script>
  <script src="{{asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('backend/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
  <script src="{{asset('backend/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
  <script src="{{asset('backend/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js')}}"></script>
  <script src="{{asset('backend/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
  <script src="{{asset('backend/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
  <script src="{{asset('backend/libs/twitter-bootstrap-wizard/prettify.js')}}"></script>
  <script src="{{asset('backend/libs/parsleyjs/parsley.min.js')}}"></script>
  <script src="{{asset('backend/js/pages/form-validation.init.js')}}"></script>
  <script src="{{asset('backend/js/pages/form-wizard.init.js')}}"></script>
  <script src="{{asset('backend/js/pages/form-advanced.init.js')}}"></script>
  <script src="{{asset('backend/js/app.js')}}"></script>
  
  <!-- Pour la signature -->
  <!--  -->
  <script src="{{asset('vendor/jquery-ui-1.14.1/jquery-ui.min.js')}}"></script>
  <script src="{{asset('backend/js/signature.js')}}"></script>
  <script src="{{asset('frontend/js/front-personal.js')}}"></script>
  <script src="{{asset('backend/js/loaddata.js')}}"></script>
  <script nonce="{{ $cspNonce ?? '' }}">$(function(){ Login.init(); });</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha384-duAtk5RV7s42V6Zuw+tRBFcqD8RjRKw6RFnxmxIj1lUGAQJyum/vtcUQX8lqKQjp" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.fr.min.js" integrity="sha384-0QYShvU8+CrUwWRv5soLL/H+9wcwZLBj/F+0l2U1jwetUpy+beDjuDRzKylb7UFH" crossorigin="anonymous"></script>
  <script nonce="{{ $cspNonce ?? '' }}">$(document).ready(function()
   {$('.select2').select2();});</script>
  <script nonce="{{ $cspNonce ?? '' }}">
    // $("#next").click(function() { $(".select2").select2(); });
  </script>
  <script nonce="{{ $cspNonce ?? '' }}">
      // Création de compte : longueur du mot de passe et concordance avec la confirmation
      function verifier_password(){
        var pass = $('#password_cc').val() || '';
        var confirmation = $('#password_confirmation_cc').val() || '';
        var tropCourt = pass.length > 0 && pass.length < 8;
        var differents = confirmation.length > 0 && confirmation !== pass;
        $('#mot_de_passe').toggle(tropCourt);
        $('#password_cc').toggleClass('is-invalid', tropCourt);
        $('#mots_de_passe_differents').toggle(differents);
        $('#password_confirmation_cc').toggleClass('is-invalid', differents);
      }
    </script>
  <script nonce="{{ $cspNonce ?? '' }}">
    // Création de compte : l'adresse e-mail doit être vérifiée par un code avant de pouvoir créer le compte.
    // Le bouton « Vérifier l'adresse » n'apparaît qu'une fois une adresse complète saisie.
    var inscription = {
        adresseCode: @json(($codeDejaEnvoye ?? false) ? mb_strtolower(trim(old('email'))) : ''),  // adresse à laquelle le code a été envoyé
        emailExiste: false,
        envoiEnCours: false,
        attente: 0,
        minuterie: null,
        temporisation: null
    };

    function adresseSaisie() {
        return $.trim($('#email_cc').val() || '').toLowerCase();
    }

    function adresseComplete(adresse) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(adresse);
    }

    function majBoutonsInscription() {
        var adresse = adresseSaisie();
        var codeEnvoye = inscription.adresseCode !== '' && inscription.adresseCode === adresse;
        var adresseUtilisable = adresseComplete(adresse) && !inscription.emailExiste;
        $('#btn_envoyer_code')
            .toggleClass('d-none', !adresseUtilisable)
            .prop('disabled', inscription.envoiEnCours || inscription.attente > 0);
        $('#btn_creer_compte').prop('disabled', !adresseUtilisable || !codeEnvoye);
        $('#aide_creer_compte').toggle(!codeEnvoye);
    }

    // Message sous l'adresse e-mail : vert (code envoyé) ou rouge (échec)
    function statutCodeInscription(type, message) {
        var ok = (type === 'ok');
        $('#code_statut')
            .removeClass('alert-success alert-danger')
            .addClass('alert py-2 px-3 mb-0 ' + (ok ? 'alert-success' : 'alert-danger'))
            .empty()
            .append($('<i class="fas me-1" aria-hidden="true"></i>').addClass(ok ? 'fa-check-circle' : 'fa-exclamation-triangle'))
            .append(document.createTextNode(message))
            .show();
    }

    // Délai avant de pouvoir redemander un code
    function attenteCodeInscription(secondes) {
        clearInterval(inscription.minuterie);
        inscription.attente = secondes;
        var libelle = $('#btn_envoyer_code .libelle');
        var tic = function () {
            if (inscription.attente <= 0) {
                clearInterval(inscription.minuterie);
                libelle.text('Renvoyer le code');
            } else {
                libelle.text('Renvoyer le code (' + inscription.attente + ' s)');
            }
            majBoutonsInscription();
            inscription.attente--;
        };
        tic();
        inscription.minuterie = setInterval(tic, 1000);
    }

    // Saisie de l'adresse : on repart de zéro si elle diffère de celle qui a reçu le code,
    // puis on vérifie (après une courte pause de frappe) qu'aucun compte ne l'utilise déjà.
    function saisie_email_inscription() {
        var adresse = adresseSaisie();
        if (adresse !== inscription.adresseCode && !inscription.envoiEnCours) {
            inscription.adresseCode = '';
            clearInterval(inscription.minuterie);
            inscription.attente = 0;
            $('#bloc_code').hide();
            $('#code_verification').val('');
            $('#code_statut').hide();
            $('#btn_envoyer_code .libelle').text('Vérifier l’adresse');
        }
        inscription.emailExiste = false;
        $('#email_existe').hide();
        $('#email_cc').removeClass('is-invalid');
        majBoutonsInscription();

        clearTimeout(inscription.temporisation);
        if (adresseComplete(adresse)) {
            inscription.temporisation = setTimeout(function () { email_existe(adresse); }, 400);
        }
    }

    function email_existe(adresse) {
        $.ajax({
            url: "{{ route('email_existe') }}",
            type: 'GET',
            data: {username: adresse},
            dataType: 'json',
            // Vérification de confort : le serveur contrôle de toute façon l'adresse à l'envoi du code
            success: function (data) {
                if (adresseSaisie() !== adresse) { return; }  // l'usager a modifié l'adresse entre-temps
                inscription.emailExiste = (data == 0);
                $('#email_existe').toggle(inscription.emailExiste);
                $('#email_cc').toggleClass('is-invalid', inscription.emailExiste);
                if (inscription.emailExiste) { $('#code_statut').hide(); }
                majBoutonsInscription();
            }
        });
    }

    function envoyer_code_inscription(){
        var adresse = adresseSaisie();
        if (!adresseComplete(adresse)) {
            statutCodeInscription('erreur', 'Saisissez une adresse e-mail complète (exemple : nom@gmail.com).');
            $('#email_cc').trigger('focus');
            return;
        }
        var libelle = $('#btn_envoyer_code .libelle');
        var texteAvant = libelle.text();
        inscription.envoiEnCours = true;
        libelle.text('Envoi en cours…');
        majBoutonsInscription();

        $.ajax({
            url: "{{ route('inscription.code') }}",
            type: 'POST',
            dataType: 'json',
            data: {email: adresse},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                inscription.envoiEnCours = false;
                inscription.adresseCode = adresse;
                $('#bloc_code').show();
                $('#code_verification').val('').trigger('focus');
                statutCodeInscription('ok', data.message);
                attenteCodeInscription(data.attente || 60);
            },
            error: function (xhr) {
                inscription.envoiEnCours = false;
                var json = xhr.responseJSON || {};
                // Adresse refusée : on affiche directement le message (sans la liste « Veuillez corriger… »)
                var erreurs = xhr.status === 422 && json.errors;
                statutCodeInscription('erreur', erreurs && erreurs.email ? erreurs.email[0] : messageErreurAjax(xhr));

                if (json.attente) {
                    // Un code vient déjà de partir : renvoi possible après le délai
                    attenteCodeInscription(json.attente);
                    return;
                }
                // Le code n'est pas parti (service d'envoi, connexion...) : on peut le renvoyer immédiatement
                libelle.text(xhr.status === 0 || xhr.status >= 500 ? 'Renvoyer le code' : texteAvant);
                majBoutonsInscription();
            }
        });
    }

    $(function () { majBoutonsInscription(); });
  </script>
  <script nonce="{{ $cspNonce ?? '' }}">
    function sendData(){
    var form = $('#fileUploadForm')[0];
    // Create an FormData object 
    var data = new FormData(form);
    console.log(data);
    var url = "{{ route('piecejointe.laod') }}";
    $.ajax({
    type: 'post',
    url: url,
    data: data,
    success: function (response) {
     console.log('ojo');
    }
  });
  return false;
}
  </script>
  <script nonce="{{ $cspNonce ?? '' }}">
   function verifier_nom_commercial(champ_nom_commercial){
      var nom_commercial= $('#'+champ_nom_commercial).val();
      $('#pNomindisponible').hide();
      $('#pNomdisponible').hide();
      var url = "{{ route('verifier_nom_commercial') }}";
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                    url: url,
                    type:'POST',
                    dataType:'json',
                    data: {nom_commercial: nom_commercial} ,
                    beforeSend: function(){
                      $('#loading').show();
                    },
                    complete: function(){
                      $('#loading').hide();
                    },
                    error:function(xhr)
                    {alert(messageErreurAjax(xhr));},
                    success:function(data){
                     // alert('oko');
                     if(data.status=='200'){
                        $('#pNomdisponible').show()
                        $('#pNomindisponible').hide()
                     }
                     if(data.status!='200'){
                        $('#pNomdisponible').hide()
                        $('#pNomindisponible').show()
                     }

                     
                    }
                });
      }
      // Étape 2 « Entreprise » : disponibilité du nom commercial / de la dénomination sociale.
      // Les messages s'affichent sous le champ vérifié uniquement (jamais en alerte).
      function valider_nom_commercial(champ_nom_commercial){
      var champ = $('#'+champ_nom_commercial);
      var bloc = champ.closest('[class*="col-"]');
      var indisponible = bloc.find('.nomCommercialindispo');
      var erreur = bloc.find('.nomCommercialErreur');
      var nom_commercial = champ.val();

      indisponible.hide();
      erreur.hide();
      champ.removeClass('is-invalid');
      if (!$.trim(nom_commercial)) {
          return;
      }

      var url = "{{ route('verifier_nom_commercial') }}";
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                    url: url,
                    type:'POST',
                    dataType:'json',
                    data: {nom_commercial: nom_commercial} ,
                    // Vérification impossible (service FNRCCM injoignable, trop de tentatives...)
                    error:function(){ erreur.show(); },
                    success:function(data){
                     var pris = (data.status != '200');
                     indisponible.toggle(pris);
                     champ.toggleClass('is-invalid', pris);
                    }
                });
      }
  </script>
  <script nonce="{{ $cspNonce ?? '' }}">
      function editpiecejointes(categoriepiece){
       // var id=id;     
        console.log("categoriepiece")
        var url = "{{ route('piecejointe.correct_piece') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {categoriepiece: categoriepiece} ,
                    error:function(xhr){alert(messageErreurAjax(xhr));},
                    success:function(data){
                     $("#piece_name_update").html(data.categorie_piece);
                        $("#piece_id_u").val(data.id);
                        $("#piece_id_correct").val(data.id);

                       $("#reference_piece_u").val(data.reference);
                       $("#reference_correct_piece_u").val(data.reference);
                       $("#date_etablissement_correct_u").val(data.date_etablissement);
                       $("#lieu_etablissement_correct_u").val(data.lieu_etablissement);
                       $("#date_etablissement_u").val(data.date_etablissement);
                       $("#lieu_etablissement_u").val(data.lieu_etablissement);
                       $('.type_document_u').val('');
                       $('.type_document_u').val(data.type_piece);
                       //alert($('.type_document_u').val());
                       if(data.categorie_piece=='declaration')
                       $('#type_piece_declaration_u').show()
                       else
                       $('#type_piece_declaration_u').hide()
                       if(data.categorie_piece=='piece_didentite')
                       $('#type_piece_identite_u').show()
                       else
                       $('#type_piece_identite_u').hide()
                    }
                });
      }
      function editpiecejointe(categoriepiece){
       // var id=id;     
        console.log("categoriepiece")
        var url = "{{ route('piecejointe.modif') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {categoriepiece: categoriepiece} ,
                    error:function(xhr){alert(messageErreurAjax(xhr));},
                    success:function(data){
                     $("#piece_name_update").html(data.categorie_piece);
                        $("#piece_id_u").val(data.id);
                        $("#piece_id_correct").val(data.id);
                        
                       $("#reference_piece_u").val(data.reference);
                       $("#reference_correct_piece_u").val(data.reference); 
                       $("#date_etablissement_correct_u").val(data.date_etablissement); 
                       $("#lieu_etablissement_correct_u").val(data.lieu_etablissement);
                       $("#date_etablissement_u").val(data.date_etablissement);
                       $("#lieu_etablissement_u").val(data.lieu_etablissement);
                       $('.type_document_u').val('');
                       $('.type_document_u').val(data.type_piece);
                       //alert($('.type_document_u').val());
                       if(data.categorie_piece=='declaration')
                       $('#type_piece_declaration_u').show()
                       else
                       $('#type_piece_declaration_u').hide()
                       if(data.categorie_piece=='piece_didentite')
                       $('#type_piece_identite_u').show()
                       else
                       $('#type_piece_identite_u').hide()
                    }
                });
      }
  </script>
 <script nonce="{{ $cspNonce ?? '' }}">
          
          // Cascade Région > Province > Commune > Arrondissement > Secteur / Village.
          // - le niveau suivant est vidé à chaque changement (et, par enchaînement, tous ceux d'après) ;
          // - s'il n'y a qu'un seul choix (commune sans arrondissement, arrondissement unique),
          //   il est sélectionné automatiquement, ce qui charge directement le niveau suivant.
          function changeValue(champ_actuel,champ_suivant, table, champ_precedent)
        {
            var valeur_actuel = $("#"+champ_actuel).val();
            var val_precedent=  $("#"+champ_precedent).val();
            var suivant = $('#'+champ_suivant);

            suivant.empty().append('<option></option>');
            if (!valeur_actuel) {
                suivant.trigger('change');
                return;
            }

            var url = '{{ route('valeur.selection') }}';
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {valeur_actuel: valeur_actuel, table: table, val_precedent:val_precedent},
                    dataType: 'json',
                    error:function(xhr){alert(messageErreurAjax(xhr));},
                    success: function (data) {
                        suivant.empty().append('<option></option>');
                        $.each(data || [], function (i, ligne) {
                            suivant.append($('<option></option>').val(ligne.id).text(ligne.name));
                        });
                        if (data && data.length === 1) {
                            suivant.val(String(data[0].id));
                        }
                        suivant.trigger('change');
                    }
            });
        }
 </script>
<script nonce="{{ $cspNonce ?? '' }}">
          
          function changeActivite(champ_actuel,champ_suivant)
          {
          //alert('ok');  
          var valeur_actuel = $("#"+champ_actuel).val();          
            //alert(niveau);
            var url = '{{ route('valeur.activite') }}';
            $.ajax({
                    url: url,
                    type: 'GET', 
                    data: {valeur_actuel: valeur_actuel},
                    dataType: 'json',
                    error:function(xhr){alert(messageErreurAjax(xhr));},
                    success: function (data) {
                        var options = '<option></option>';
                      if( data.length==1){
                        for (var x = 0; x < data.length; x++) {
                          console.log(data[x]['id']);
                          var id_val= data[x]['Code'];
                         
                         
                          options += '<option value="' + id_val + '"  >' + data[x]['description'] + '</option>';
                         
 
                        }
                      }
                      else{
                        for (var x = 0; x < data.length; x++) {
                            options += '<option value="' + data[x]['Code'] + '">' + data[x]['description'] + '</option>';
                        }
                      }
                        
                       $('#'+champ_suivant).html(options);
                    }
            });
        }
</script>
<script nonce="{{ $cspNonce ?? '' }}">
  $(document).ready(function() {
    jQuery.extend(jQuery.validator.messages, {
    required: "Ce champ est obligatoire.",
    remote: "Please fix this field.",
    email: "Entrez une adresse mail valide.",
    url: "Please enter a valid URL.",
    date: "Entrer une date valide.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Ce champ ne doit pas avoir plus de {0} caractères."),
    minlength: jQuery.validator.format("Ce champ doit avoir au moins {0} caractères."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Ce champ ne doit pas avoir une valeur supérieure à {0}."),
    min: jQuery.validator.format("Ce champ ne doit pas avoir une valeur inférieure à {0}.")
});
});
</script>
<script nonce="{{ $cspNonce ?? '' }}">
  function detail_morale(){
    var denomination_sociale_pm=$("#denomination_sociale_pm").val();
    $("#val_denomination_sociale_pm").text(denomination_sociale_pm);

    var nom_commercial_pm=$("#nom_commercial_pm").val();
    $("#val_nom_commercial_pm").text(nom_commercial_pm);

    var sigle_pm=$("#sigle_pm").val();
    $("#val_sigle_pm").text(sigle_pm);

    var capital=$("#capital").val();
    $("#val_capital").text(capital);

    var dont_numeraire=$("#dont_numeraire").val();
    $("#val_dont_numeraire").text(dont_numeraire);

    var dont_nature=$("#dont_nature").val();
    $("#val_dont_nature").text(dont_nature);

    var montant_action=$("#montant_action").val();
    $("#val_montant_action").text(montant_action);

    var nbre_action=$("#nbre_action").val();
    $("#val_nbre_action").text(nbre_action);
    

    //$( "#myselect option:selected" ).text();
     var type_etablissement_pm=$("#type_etablissement_pm option:selected").text();
     $("#val_type_etablissement_pm").text(type_etablissement_pm);

     var forme_juridique_pm=$("#forme_juridique_pm option:selected").text();
     $("#val_forme_juridique_pm").text(forme_juridique_pm);

    var chiffre_daffaire_prev_pm=$("#chiffre_daffaire_prev_pm").val();
    $("#val_chiffre_daffaire_prev_pm").text(chiffre_daffaire_prev_pm);

    var activite_principale_pm=$("#activite_principale_pm option:selected").text();
     $("#val_activite_principale_pm").text(activite_principale_pm);

     var objet_social_pm=$("#objet_social_pm").val();
    $("#val_objet_social_pm").text(objet_social_pm);

    var employee_permanant_pm=$("#employee_permanant_pm").val();
    $("#val_employee_permanant_pm").text(employee_permanant_pm);   

     var province_entreprise=$("#province_entreprise option:selected").text();
     $("#val_province_entreprise").text(province_entreprise);

     var commune_entreprise=$("#commune_entreprise option:selected").text();
     $("#val_commune_entreprise").text(commune_entreprise);

     var arrondissement_entreprise=$("#arrondissement_entreprise option:selected").text();
     $("#val_arrondissement_entreprise").text(arrondissement_entreprise);

     var secteur_entreprise=$("#secteur_entreprise option:selected").text();
     $("#val_secteur_entreprise").text(secteur_entreprise);

     var region_entreprise=$("#region_entreprise option:selected").text();
     $("#val_region_entreprise").text(region_entreprise+' / '+province_entreprise+' / '+commune_entreprise+' / '+secteur_entreprise);

     var tel_bureau_pm=$("#tel_bureau_pm").val();
   // $("#val_tel_bureau_pp").text(tel_bureau_pp); 

     var mobile_pm=$("#mobile_pm").val();
    $("#val_mobile_pm").text(mobile_pm+' / '+tel_bureau_pm); 

  }
  function detail_physique(){
    var nom_commercial=$("#nom_commercial_pp").val();
    $("#val_denomination_pp").text(nom_commercial);

    var sigle_pp=$("#sigle_pp").val();
    $("#val_sigle_pp").text(sigle_pp);

    //$( "#myselect option:selected" ).text();
     var type_etablissements=$("#type_etablissements option:selected").text();
     $("#val_type_etablissement_pp").text(type_etablissements);

     var forme_juridique_pp=$("#forme_juridique_pp option:selected").text();
     $("#val_forme_juridique_pp").text(forme_juridique_pp);

    var chiffre_daffaire_prev_pp=$(".chiffre_daffaire_prev_pp").val();
    $("#val_chiffre_daffaire_prev_pp").text(chiffre_daffaire_prev_pp);

    var activite_principale=$(".activite_principale option:selected").text();
     $("#val_activite_principale").text(activite_principale);

     var objet_social=$("#objet_social").val();
    $("#val_objet_social").text(objet_social);

    var employee_permanant=$("#employee_permanant").val();
    $("#val_employee_permanant").text(employee_permanant);   

     var province_usager=$("#province_usager option:selected").text();
     $("#val_province_usager").text(province_usager);

     var commune_usager=$("#commune_usager option:selected").text();
     $("#val_commune_usager").text(commune_usager);

     var arrondissement_usager=$("#arrondissement_usager option:selected").text();
     $("#val_arrondissement_usager").text(arrondissement_usager);

     var secteur_usager=$("#secteur_usager option:selected").text();
     $("#val_secteur_usager").text(secteur_usager);

     var region_usager=$("#region_usager option:selected").text();
     $("#val_region_usager").text(region_usager+' / '+province_usager+' / '+commune_usager+' / '+secteur_usager);

     var tel_bureau_pp=$("#tel_bureau_pp").val();
   // $("#val_tel_bureau_pp").text(tel_bureau_pp); 

     var mobile_pp=$("#mobile_pp").val();
    $("#val_mobile_pp").text(mobile_pp+' / '+tel_bureau_pp); 

    
    //type_etablissements chiffre_daffaire_prev_pp
  }
</script>
 @yield('additionnel_script')


  <script nonce="{{ $cspNonce ?? '' }}" type="text/javascript">
    function makeid(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
  }
</script>
<script nonce="{{ $cspNonce ?? '' }}">
    function empty_input_file(input) {
      // alert($('.'+input).val());
        $('.'+input).val('');
}
// Contrôle d'un fichier choisi : type (PDF, JPG, JPEG, PNG) et taille (10 Mo au maximum).
// Contrôle le champ réellement modifié (this) ; l'identifiant passé en argument ne sert qu'en secours.
function VerifyUploadSizeIsOK(docsize)
{
   var fld = (this && this.nodeType === 1 && this.type === 'file') ? this : document.getElementById(docsize);
   var MaxSizeInBytes = 10485760;

   // Aucun fichier (sélection annulée) : rien à contrôler
   if (!fld || !fld.files || fld.files.length === 0) {
      return true;
   }

   var fichier = fld.files[0];
   var morceaux = fichier.name.split('.');
   var ext = morceaux.length > 1 ? morceaux[morceaux.length - 1].toLowerCase() : '';
   var arrayExtensions = ["jpg", "jpeg", "png", "pdf"];

   if (arrayExtensions.indexOf(ext) === -1) {
      alert("Le fichier « " + fichier.name + " » n'est pas accepté. Seuls les fichiers PDF, JPG, JPEG et PNG sont autorisés.");
      fld.value = '';
      return false;
   }
   if (fichier.size > MaxSizeInBytes)
   {
      alert("Le fichier « " + fichier.name + " » est trop volumineux : " + parseInt(MaxSizeInBytes/1024/1024) + " Mo au maximum.");
      fld.value = '';
      return false;
   }
   return true;
}

</script>
<script nonce="{{ $cspNonce ?? '' }}">
  $(document).on("click", "#ccp_es", function(){
   if($('#ccp_es').prop( "checked" )){
    $('#block_formulaire_cpc').show()
   }
   else{
        $('#block_formulaire_cpc').hide()
   }
    
})
</script>
<script nonce="{{ $cspNonce ?? '' }}">
$(function(){
    var today = new Date();
   startDate= new Date(today.getFullYear()-18, today.getMonth(), today.getDate());
    $('.date_nais_usager').datepicker({
            autoclose: true,
            endDate: new Date(today.getFullYear()-18, today.getMonth(), today.getDate()),
            language: 'fr',
            dateFormat: 'dd-mm-yy',
});
}); 
</script>
<script nonce="{{ $cspNonce ?? '' }}">
  $(function(){
      $('.date_piecejointe').datepicker({
              autoclose: true,
              endDate: new Date(),
              language: 'fr',
              dateFormat: 'dd-mm-yy',
             
  });
  }); 

  $(function(){
      $('.date_mariage').datepicker({
              autoclose: true,
              endDate: new Date(),
              language: 'fr',
              dateFormat: 'dd-mm-yy',
             
  });
  });

  </script>
  <script nonce="{{ $cspNonce ?? '' }}">
    function editdemande()
      {
        //alert('ok');
          $('.edit_demande').hide();
          $('.save_demande').show();
      }
      function editusager()
      {
        //alert('ok');
          $('.edit_usager').hide();
          $('.save_usager').show();
      }
  </script>
   <script nonce="{{ $cspNonce ?? '' }}">
    $(document).ready(function(){
        // Le message disparaît après 5 secondes (5000 ms)
        setTimeout(function() {
            $(".custom-alert").fadeOut("slow", function() {
                $(this).remove();
            });
        }, 5000); // 5000 ms = 5 secondes
        setTimeout(function() {
            $(".custom-rouge").fadeOut("slow", function() {
                $(this).remove();
            });
        }, 5000); // 5000 ms = 5 secondes
    });
</script>
<script nonce="{{ $cspNonce ?? '' }}">
function initRechercheUsager(selecteur) {
    $(selecteur).select2({
        width: '100%',
        placeholder: 'Saisir le N° complet de la CNIB / du passeport',
        minimumInputLength: 6,
        language: {
            inputTooShort: function () { return 'Saisissez le numéro complet de la pièce'; },
            noResults:     function () { return 'Aucun promoteur avec ce numéro'; },
            searching:     function () { return 'Recherche…'; }
        },
        ajax: {
            url: "{{ route('usager.recherche') }}",
            dataType: 'json',
            delay: 400,
            data: function (params) { return { q: params.term }; },
            processResults: function (data) { return data; }
        }
    });
}
$(function () { initRechercheUsager('select.recherche-usager'); });
</script>
<script nonce="{{ $cspNonce ?? '' }}">
    document.addEventListener('DOMContentLoaded', function() {
      // Sélectionner tous les inputs et textareas
      const inputs = document.querySelectorAll('input[type="text"], input:not([type]), textarea');
      
      inputs.forEach(input => {
          // Transformer en majuscules lors de la saisie
          input.addEventListener('input', function() {
              this.value = this.value.toUpperCase();
          });
          
          // Transformer en majuscules lors de la perte de focus (au cas où)
          input.addEventListener('blur', function() {
              this.value = this.value.toUpperCase();
          });
          
          // Transformer la valeur initiale si elle existe
          if (input.value) {
              input.value = input.value.toUpperCase();
          }
      });
    });
</script>
  </div><!-- Body inner end -->
  </body>

  </html>