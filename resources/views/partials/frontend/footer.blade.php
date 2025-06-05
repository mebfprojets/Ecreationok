
  <footer id="footer" class="footer bg-overlay" style="margin-top: 40px">
    <div class="footer-main">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-5 col-md-6 footer-widget footer-about">
            <h3 class="widget-title">MEBF</h3>
            <img loading="lazy" width="100px" class="footer-logo" src="{{asset('frontend/images/MEBF-CEFORE.JPG')}}" alt="Constra">
            <p>132, Avenue de Lyon, 11 BP 379 OUAGADOUGOU 11,</p>
              <p>BURKINA FASO Tel: 25 39 80 60 Fax: 25 39 80 62 Email: info@me.bf</p>
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
              <span>Copyright &copy; <script>
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
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                <input type="button" data-dismiss="modal"  class="btn btn-sm btn-warning"  value="Fermer la fenetre">
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
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
              <input type="button" data-dismiss="modal"  class="btn btn-sm btn-warning"  value="Annuler">
              <input  type="submit"   class="btn btn-sm btn-success"  value="Modifier">
          </div>
          
      </form>
      </div>
  </div>
</div>
  <div id="modal-piece_pp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title"><i class="gi gi-pen"></i>Pièces Personne Physique</h4>
            </div>
            <div class="modal-body">

                <p>•	<a href="https://me.bf/fr/file/2967/download?token=kziektSF" style="color: blue">Télécharger ici la fiche de déclaration sur l'honneur</a></p>
                <p>•	<a href="https://me.bf/fr/file/2968/download?token=pI__AZKv" style="color: blue">Télécharger ici le formulaire de demande de carte professionnelle de commerçant (CPC)</a></p>
                <!-- <p>•	<a href="http://me.bf/fr/file/2893/download?token=P7jVe3E4" style="color: blue">Télécharger ici la fiche de demande de localisation</a></p> -->
                <p>•	<a href="https://me.bf/fr/file/2969/download?token=yvogbXGZ" style="color: blue">Télécharger ici la fiche de visite</a></p>
                <p>•	1 photocopie légalisée de la pièce d’identité ou du  passeport du promoteur;</p>
                <p>•	1 extrait de casier judiciaire (Bulletin N°3) de moins de 3 mois du promoteur. Les personnes ne pouvant pas établir leurs casiers judiciaires à Ouagadougou disposent de 75 jours pour l’apporter au CEFORE afin de compléter leur dossier;</p>
                <p>•	1 copie de l’acte de mariage (s’il y a lieu) ;</p>
                <p>•	1 certificat de résidence de l’année en cours (payement de la taxe de résidence au domaine, et établissement du certificat de résidence à la mairie ou au commissariat de police) ;</p>
                <p>•	L’un des documents suivants au nom du créateur d’entreprise :
1 Contrat de bail à usage commercial enregistré, un titre foncier, un Permis Urbain d’Habiter, une attestation d’attribution de parcelle, une facture d’eau ou d’électricité;
</p>
                <p>•	2 photos d’identité du promoteur.</p>

                <!-- <h4 class="sub-header">1.1 | Cliquer sur «S'inscrire» </h4>
                <p>•	Une copie légalisée de la CNIB du promoteur </p>
                <!-- <h4 class="sub-header">1.2 | Account</h4>
                <p>•	<a href="http://me.bf/fr/file/2967/download?token=kziektSF" style="color: blue">Une fiche de déclaration sur l'honneur</a></p>
                <!-- <h4 class="sub-header">1.3 | Service</h4> 
                <p>•	Un extrait de casier judiciaire (Bulletin N°3) de moins de 3 mois du promoteur</p>
               <!-- <h4 class="sub-header">1.4 | Payments</h4>
                <p>•	Une copie de l’acte de mariage et une photocopie du document d’identité du (de la) conjoint(e)   (s’il y a lieu)</p>
                <p>•	L’un des documents suivants au nom du créateur d’entreprise :
                      <u><li>-Un contrat de bail à usage commercial enregistré, </li></u>
                      -un titre foncier, 
                      -un Permis Urbain d’Habiter, 
                      -une attestation d’attribution de parcelle, 
                      -une facture d’eau ou d’électricité récente
                </p>
                <p>•	<a href="http://me.bf/fr/file/2893/download?token=P7jVe3E4" style="color: blue">Une fiche de localisation</a></p>
                <p>•	Deux photos d’identité du promoteur</p>
                <p>•	<a href="http://me.bf/fr/file/2968/download?token=pI__AZKv" style="color: blue">Un formulaire de demande de la carte professionnelle de commerçant timbré avec un sticker sécurisé de 500 F CFA</a></p> -->
                
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-piece_pm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title"><i class="gi gi-pen"></i>Pièces Personne Morale</h4>
            </div>
            <div class="modal-body">
                <p>•	<a href="https://me.bf/fr/file/2967/download?token=kziektSF" style="color: blue">Télécharger ici la déclaration sur l'honneur</a></p>
                <p>•	<a href="https://me.bf/fr/file/2968/download?token=pI__AZKv" style="color: blue">Télécharger ici le formulaire de demande de carte professionnelle de commerçant (CPC)</a></p>
                <!-- <p>•	<a href="http://me.bf/fr/file/2893/download?token=P7jVe3E4" style="color: blue">Télécharger ici la fiche de demande de localisation</a></p> -->
                <p>•	<a href="https://me.bf/fr/file/3481/download?token=avSak-TP" style="color: blue">Télécharger ici le formulaire RCCM</a></p>
                <p>•	<a href="https://me.bf/fr/file/132/download?token=_Sx15V_e" style="color: blue">Télécharger ici le modèle d'acte de dépôt</a></p>
                <p>•	<a href="https://me.bf/fr/file/2964/download?token=a02UueF2" style="color: blue">Télécharger ici la fiche de visite</a></p>
                <p>•	<a href="https://me.bf/fr/file/3481/download?token=avSak-TP" style="color: blue">Télécharger ici le contrat d'apport de bien</a></p>
                <p>•	<a href="https://me.bf/fr/file/3481/download?token=avSak-TP" style="color: blue">Télécharger ici un exemplaire original des statuts de la société unipersonnel</a></p>
                <p>•	<a href="https://www.me.bf/fr/file/3087/download?token=pBQrGH2F" style="color: blue">Télécharger ici un exemplaire original des statuts de la société pluripersonnel</a></p>
                <p>•	<a href="https://www.me.bf/fr/file/129/download?token=v_mx1G_9" style="color: blue">Télécharger ici un exemplaire de déclaration de versement de fonds</a></p>
                <p>•	<a href="https://www.me.bf/fr/file/133/download?token=wVOcjoWQ" style="color: blue">Télécharger ici un exemplaire de Procès Verbal (PV)</a></p>
                <p>•	<a href="https://me.bf/fr/file/3481/download?token=avSak-TP" style="color: blue">Télécharger ici un exemplaire de déclaration de régularité et de conformité</a></p>
                
                <p>•	Une photocopie de la pièce d’identité ou du passeport du ou des dirigeants de la société;</p>
                <p>•	Un extrait de casier judiciaire (Bulletin N°3) de moins de 3 mois du ou des dirigeants;</p>
                <!-- <p>•	Un exemplaire du Procès-Verbal de l’assemblée générale constitutive</p> -->
                <!-- <p>•	Un exemplaire de la déclaration de souscription et de versement du capital (DSV) et/ou la DRC à savoir la déclaration de régularité et de conformité</p> -->
                <p>•	Une attestation de dépôt de capital en banque au nom de la société (cas d’apport en numéraire);</p>
                <!-- <p>•	Un contrat d’apport de biens en nature annexé des reçus des biens apportés (cas d’apport de biens en nature)</p> -->
                <p>•	Un rapport d’évaluation des biens apportés si leur estimation dépasse 5 millions;</p>
                <p>•	L’un des documents suivants au nom au nom de la société :
                  <ul>-Un contrat de bail à usage commercial enregistré</ul>
                  <ul>-Un titre foncier</ul>
                  <ul>-Un Permis Urbain d’Habiter</ul>
                  <ul>-Une attestation d’attribution de parcelle</ul>
                  <ul>-Une facture d’eau ou d’électricité récente.</ul>
                </p>
                




                <!-- <h4 class="sub-header">1.1 | Cliquer sur «S'inscrire» </h4> -->
                <!-- <p>•	Une photocopie de la pièce d’identité ou du passeport du ou des dirigeants de la société</p> -->
                <!-- <h4 class="sub-header">1.2 | Account</h4> -->
                <!-- <p>•	Une fiche de déclaration sur l’honneur dûment remplie et signée par le ou les dirigeants <a href="http://me.bf/fr/file/2967/download?token=kziektSF" style="color: blue">Télécharger</a></p> -->
                <!-- <h4 class="sub-header">1.3 | Service</h4> -->
                <!-- <p>•	Un extrait de casier judiciaire (Bulletin N°3) de moins de 3 mois du ou des dirigeants</p> -->
               <!-- <h4 class="sub-header">1.4 | Payments</h4>-->
                <!-- <p>•	Un exemplaire original des statuts de la société </p> -->
                <!-- <p>•	Un exemplaire du Procès-Verbal de l’assemblée générale constitutive</p> -->
                <!-- <p>•	Un exemplaire de la déclaration de souscription et de versement du capital (DSV) et/ou la DRC à savoir la déclaration de régularité et de conformité</p> -->
                
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-infos" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title"><i class="gi gi-pen"></i>Avant de commencer</h4>
            </div>
            <div class="modal-body">
                <!-- <h4 class="sub-header">1.1 | Cliquer sur «S'inscrire» </h4> -->
                <p>Avant de créer votre entreprise, vous devez d'abord vérifier la disponibilité du nom commercial.
                  Vous pouvez aussi réserver le nom commercial et où la dénomination sociale choisie pour votre entreprise
                  ,contre rémise d'une Attestation de Disponibilité et de Réservation qui sera jointe aux statuts pour la numérisation.
                </p>
                <!-- <h4 class="sub-header">1.2 | Account</h4> -->
                
                <p>•	Un exemplaire du Procès-Verbal de l’assemblée générale constitutive ;</p>
                <p>•	Un exemplaire de la déclaration de souscription et de versement du capital (DSV) et/ou la DRC à savoir la déclaration de régularité et de conformité.</p>
                
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

  <!-- Javascript Files
  ================================================== -->
  <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
  <!-- initialize jQuery Library -->
  <script src="{{asset('frontend/js/vendor/jquery.min.js')}}"></script>
  <script src="{{asset('frontend/js/vendor/bootstrap.min.js')}}"></script>

  <script src="{{asset('frontend/plugins/jQuery/jquery.min.js')}}"></script>
  <!-- Bootstrap jQuery -->
  <script src="{{asset('frontend/plugins/bootstrap/bootstrap.min.js')}}" defer></script>
  <!-- Slick Carousel -->
  <script src="{{asset('frontend/plugins/slick/slick.min.js')}}"></script>
  <script src="{{asset('frontend/plugins/slick/slick-animation.min.js')}}"></script>
  <!-- Color box -->
  <script src="{{asset('frontend/plugins/colorbox/jquery.colorbox.js')}}"></script>
  <!-- shuffle -->
  <script src="{{asset('frontend/plugins/shuffle/shuffle.min.js')}}" defer></script>
  
  <!-- Google Map API Key-->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
  <!-- Google Map Plugin-->
  <script src="{{asset('frontend/plugins/google-map/map.js')}}" defer></script>
  <!-- Template custom -->
  <script src="{{asset('frontend/js/login.js')}}"></script>
  <script src="{{asset('frontend/js/script.js')}}"></script>

  
  <!-- Pour test formulaire demande -->
  <!-- <script src="{{asset('frontend/js/plugins.js')}}"></script>
  <script src="{{asset('frontend/js/app.js')}}"></script> -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="{{asset('backend/libs/jquery/jquery.min.js')}}"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
  {{-- <script src=https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.2-dev/js/formValidation.min.js></script> --}}


  <script src="{{asset('js/jquery.steps.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="{{asset('backend/js/signature.js')}}"></script>
  <script src="{{asset('frontend/js/front-personal.js')}}"></script>
  <script src="{{asset('backend/js/loaddata.js')}}"></script>
  <script>$(function(){ Login.init(); });</script>
  <script
			  src="https://code.jquery.com/ui/1.7.0/jquery-ui.min.js"
			  integrity="sha256-CkxUCXQ5bBbS+VV9O06NQWvw/odbX/kf3aTCVI86HWA="
			  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.fr.min.js"></script>
  <script>$(document).ready(function()
   {$('.select2').select2();});</script>
  <script>
    // $("#next").click(function() { $(".select2").select2(); });
  </script>
  <script>
      function verifier_password(){
        //alert('ok');
        var pass=$('.password').val();
        var nbr= pass.length;
        $('#mot_de_passe').show();
      }
    </script>
  <script>
    function email_existe(){

     var username= $('#email_cc').val();
     //alert(username);
      var url = "{{ route('email_existe') }}";
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {username: username},
                    dataType: 'json', 
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                    
                       if(data==0){
                         $('#email_existe').show();
                       }
                       else{
                        $('#email_existe').hide();
                       }
                    }
            });
    }
  </script>
  <script>
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
  <script>
   function verifier_nom_commercial(champ_nom_commercial){
      var nom_commercial= $('#'+champ_nom_commercial).val();
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
                    error:function(){alert('error');},
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
      function valider_nom_commercial(champ_nom_commercial){
      var nom_commercial= $('#'+champ_nom_commercial).val();
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
                    error:function(){alert('error');},
                    success:function(data){
                     // alert('oko');
                     if(data.status=='200'){
                        $('.nomCommercialindispo').hide()
                     }
                     if(data.status!='200'){
                        $('.nomCommercialindispo').show()
                     }                     
                    }
                });
      }
  </script>
  <script>
      function editpiecejointes(categoriepiece){
       // var id=id;     
        console.log("categoriepiece")
        var url = "{{ route('piecejointe.correct_piece') }}";
                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {categoriepiece: categoriepiece} ,
                    error:function(){alert('error');},
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
                    error:function(){alert('error');},
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
 <script>
          
          function changeValue(champ_actuel,champ_suivant, table, champ_precedent)
        {
            var valeur_actuel = $("#"+champ_actuel).val();
            var val_precedent=  $("#"+champ_precedent).val();
            var val_actuel = $("#"+champ_actuel).val(); 
           
            //alert(niveau);
            var url = '{{ route('valeur.selection') }}';
            $.ajax({
                    url: url,
                    type: 'GET',
                    data: {valeur_actuel: valeur_actuel, table: table, val_precedent:val_precedent},
                    dataType: 'json', 
                    error:function(data){alert("Erreur");},
                    success: function (data) {
                        var options = '<option></option>';
                      if( data.length==1){
                        for (var x = 0; x < data.length; x++) {
                          console.log(data[x]['id']);
                          var id_val= data[x]['id'];
                         // $('#'+champ_suivant).val(id_val);
                         
                          options += '<option value="' + id_val + '"  >' + data[x]['name'] + '</option>';
                         // $('#'+champ_suivant).val(id_val)
 
                        }
                      }
                      else{
                        for (var x = 0; x < data.length; x++) {
                            options += '<option value="' + data[x]['id'] + '">' + data[x]['name'] + '</option>';
                        }
                      }
                        
                       $('#'+champ_suivant).html(options);
                    }
            });
        }
 </script>
<script>
          
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
                    error:function(data){alert("Erreur");},
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
<script>
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
<script>
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

 <!-- API DE PAIEMENT -->
 <script src=https://api.gutouch.net/touchpayv2/script/touchpaynr/prod_touchpay-0.0.1.js  type='text/javascript'>
</script>

  <script type="text/javascript">
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
  function calltouchpay(numero_demande,montant_demande){
    //alert(id);
    var id= $('#demande_id').val();
    //var numero_demande=$('#'+numero).val();
    //alert(numero_demande);
    var route_sucess= '{{ route("valider.paiement",":id")}}';
    var rout_fiche = route_sucess.replace(':id', id);
    var aleatoirestring=makeid(5)
    var order_number=numero_demande+aleatoirestring;
    var agence_code='MSENT2793';
    var secure_code='suzYy19U3ev2TIsabnK6JtKaFG75oZjc1zD36Mc4QPgcVXRZAM';
    var domaine='maison.com';
    var url_redirection_success=rout_fiche;
    var url_redirection_failed="{{route('index')}}";
    var amount=montant_demande;
    var city='Ouagadougou';
    var email='test@gmail.com';
    var clientFirstName='kk';
    var clientLastName='jhkk';
    //var clientPhone='65678787';
    sendPaymentInfos(order_number, agence_code, secure_code,
       domaine, url_redirection_success, url_redirection_failed,
       amount, 'dakar', email, 'firstname', 'lastname'
    );
    
  }
</script>
<script>
    function empty_input_file(input) {
      // alert($('.'+input).val());
        $('.'+input).val('');
}
function VerifyUploadSizeIsOK(docsize)
{
    //alert(document.getElementById(docsize));
   /* Attached file size check. Will Bontrager Software LLC, https://www.willmaster.com */
   var UploadFieldID = docsize;
   var MaxSizeInBytes = 10485760;
   var fld = document.getElementById(UploadFieldID);
   var val= fld.value;
   var ext = val.split(".");
    ext = ext[ext.length-1].toLowerCase();    
  // alert(ext)
   var arrayExtensions = ["jpg" , "jpeg", "png", "pdf"];

if (arrayExtensions.lastIndexOf(ext) == -1) {
    alert("Ce type de fichier n'est pas autorisé. Seul les extensions : jpg, jpeg, png et pdf sont autorisés");
    $('#'+ docsize).val('');
}
   //alert(fld.files.length);
   if( fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes )
   {
      alert("La taille de la copie des pièce jointes ne doit pas exceder " + parseInt(MaxSizeInBytes/1024/1024) + "MB");
      $('#'+ docsize).val('');
      return false;
   }
   return true;
}

</script>
<script>
  $(document).on("click", "#ccp_es", function(){
   if($('#ccp_es').prop( "checked" )){
    $('#block_formulaire_cpc').show()
   }
   else{
        $('#block_formulaire_cpc').hide()
   }
    
})
</script>
<script>
$(function(){
    var today = new Date();
   startDate= new Date(today.getFullYear()-20, today.getMonth(), today.getDate());
    $('.date_nais_usager').datepicker({
            autoclose: true,
            endDate: new Date(today.getFullYear()-20, today.getMonth(), today.getDate()),
            language: 'fr',
            dateFormat: 'dd-mm-yy',
});
}); 
</script>
<script>
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
  <script>
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
   <script>
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
  </div><!-- Body inner end -->
  </body>

  </html>