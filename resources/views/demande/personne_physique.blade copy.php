
                        <div class="row" id="progrss-wizar" >
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body taille">
                                    <h2 class="font-size-20 mb-4 text-center">Formulaire Personne Physique</h2>
                                        {{-- <a href="#modal-confirm-devis" id="declaration"  data-toggle="modal"  class="btn btn-md btn-success"  > <i class=" fas fa-plus"></i> </a> --}}
                                        <div >
                                            {{-- <ul class="twitter-bs-wizard-nav nav-justified">
                                                <li class="nav-item">
                                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">01</span>
                                                        <span class="step-title">Formalités et Pièces</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">02</span>
                                                        <span class="step-title">Entreprise</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">03</span>
                                                        <span class="step-title">Signature</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">04</span>
                                                        <span class="step-title">Validation</span>
                                                    </a>
                                                </li>
                                            </ul> --}}

                                            {{-- <div id="bar" class="progress mt-4">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                                            </div>
                                            <br> --}}
 
                                         <form action="{{ route('demande.store') }}" id="physique" method="post"  class='form_individuel'>
                                            @csrf
                                       <input type="hidden" value='{{ $usager->id }}'name="usager_id">
                                            <div class="tab-content twitter-bs-wizard-tab-content">
                                                <h3>Pieces</h3>
                                                <section >
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                                    </div>
                                                      
                                                      <br>
                                                    <!-- <form> -->
                                                        
                                                        <div class="row">
                                                            <h5 class="font-size-14 mb-4 text-center">Enregistrer les pièces requises</h5>
                                                            <div class="row text-center" style="border: 1px solid rgb(116, 116, 105); margin-bottom:5px;"  class="mb-2">
                                                                <h5 class="font-size-14 mb-4">Formalités</h5>                                                                
                                                                <div class="row" style="margin-left:10px;">
                                                                    @foreach ($prestation_PPs as $prestation_PP)
                                                                            <div class="form-check col-md-3">
                                                                                <input class="form-check-input"  type="checkbox" id="formCheck1" disabled checked>
                                                                                <label class="form-check-label" for="formCheck1">
                                                                                    {{ $prestation_PP->type }}
                                                                                </label>
                                                                            </div>
                                                                    @endforeach                                                         
                                                                </div>
                                                    </div>
                                                            <!-- <center><p class='alerte_piece' style="color:red; display:none; background:"> Veuillez renseigner les pièces obligatoires</p></center> -->
                                                            <center><div class="alert-warning alerte_piece" style="color:red; display:none; background:">
                                                                <p>Veuillez renseigner les pièces obligatoires</p>
                                                            </div>
                                                            </center>
                                                            <div class="col-lg-6">  
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Déclaration sur l'honneur/Casier (<font color="red">*</font>)</label>
                                                                    <div class="input-group declaration_group_edit" style="display: none" >
                                                                        <input type="text" name="declaration_sur_lhonneur" id='input_certificat_de_residence' disabled class="form-control col-md-7"  value="declaration_sur_lhonneur" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="declaration_group_edit" data-toggle="modal" class="btn btn-md btn-success" onclick="editpiecejointe('declaration')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=declaration" id="declaration_view" class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('declaration'))
                                                                        <div class="input-group">
                                                                            <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration piece_declaration" value="declaration">
                                                                            <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration_edit" onclick="editpiecejointe('declaration')" > <i class="fas fa-pen"></i> </a>
                                                                                <a href="{{ route('detaildocument') }}?categoriepiece=declaration" id="declaration_view"  class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                    <div class="input-group declaration_group_add">
                                                                        <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration piece_declaration">
                                                                        <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id="declaration"  data-toggle="modal"  class="btn btn-md btn-success declaration"> <i class=" fas fa-plus"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Certificat de résidence (<font color="red">*</font>)</label>
                                                                    <div class="input-group certificat_de_residence_group_edit" style="display: none" >
                                                                        <input type="text" name="certificat_de_residence" id='input_certificat_de_residence' disabled class="form-control col-md-7"  value="certificat_de_residence" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="certificat_de_residence_edit" data-toggle="modal" class="btn btn-md btn-success" onclick="editpiecejointe('certificat_de_residence')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=certificat_de_residence" id="certificat_de_residence_view" class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @if(returnpieceinfos('certificat_de_residence'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="certificat_de_residence" id='input_certificat_de_residence' disabled class="form-control col-md-7 input_certificat_de_residence piece_certificat"  value="certificat_de_residence">
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="certificat_de_residence_edit" data-toggle="modal" class="btn btn-md btn-success" onclick="editpiecejointe('certificat_de_residence')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=certificat_de_residence" id="certificat_de_residence_view" class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group certificat_de_residence_group_add">
                                                                    <input type="text" name="certificat_de_residence" id='input_certificat_de_residence' disabled class="form-control col-md-7 input_certificat_de_residence piece_certificat">
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id='certificat_de_residence' data-toggle="modal" class="btn btn-md btn-success" > <i class=" fas fa-plus"></i> </a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Formulaire de Demande CPC (<font color="red">*</font>)</label>
                                                                    <div class="input-group formulaire_dem_cpc_group_edit" style="display: none">
                                                                        <input type="text" name="formulaire_dem_cpc" id="formulaire_dem_cpc_input" disabled class="form-control col-md-7" value="formulaire de demande CPC formulaire_dem_cpc_input" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" data-toggle="modal" id="formulaire_dem_cpc_edit" class="btn btn-md btn-success formulaire_dem_cpc_edit" onclick="editpiecejointe('formulaire_dem_cpc')"> <i class="fas fa-pen"></i> </a>
                                                                             <a  href="{{ route('detaildocument') }}?categoriepiece=formulaire_dem_cpc" id="formulaire_dem_cpc_view" class="btn btn-md btn-success formulaire_dem_cpc_view"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('formulaire_dem_cpc'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="formulaire_dem_cpc" id="formulaire_dem_cpc_input" disabled class="form-control col-md-7 formulaire_dem_cpc_input piece_cpc" value="formulaire de demande CPC" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" data-toggle="modal" id="formulaire_dem_cpc_edit" class="btn btn-md btn-success" onclick="editpiecejointe('formulaire_dem_cpc')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=formulaire_dem_cpc"  id="formulaire_dem_cpc_view" class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="input-group formulaire_dem_cpc_group_add">
                                                                        <input type="text" name="formulaire_dem_cpc" id="formulaire_dem_cpc_input" disabled class="form-control col-md-7 formulaire_dem_cpc_input piece_cpc"  >
                                                                        <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id='formulaire_dem_cpc' data-toggle="modal" class="btn btn-md btn-success formulaire_dem_cpc"   > <i class=" fas fa-plus"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Photo d'identité (<font color="red">*</font>)</label>
                                                                    <div class="input-group photo_didentite_group_edit" style="display: none">
                                                                        <input type="text" name="photo_identite" id="photo_didentite_input" disabled class="form-control col-md-7"  value="photo_didentite" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id='photo_didentite_edit' data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('photo_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=photo_didentite"  id='photo_didentite_view'   class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('photo_didentite'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="photo_identite" id="photo_didentite_input" disabled class="form-control col-md-7 photo_didentite_input piece_photo"  value="photo_didentite" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id='photo_didentite_edit' data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('photo_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=photo_didentite"  id='photo_didentite_view'   class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group photo_didentite_group_add">
                                                                    <input type="text" name="photo_identite" id="photo_didentite_input" disabled class="form-control col-md-7 photo_didentite_input piece_photo">
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id='photo_didentite' data-toggle="modal" class="btn btn-md btn-success photo_didentite"> <i class=" fas fa-plus"></i> </a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Pièce d'identité (<font color="red">*</font>)</label>
                                                                    <div class="input-group piece_didentite_group_edit " style="display: none">
                                                                        <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input" value="pièce_didentite" >
                                                                        <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success piece_didentite_edit" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=piece_didentite" id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('piece_didentite'))
                                                                        <div class="input-group">
                                                                            <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input piece_identite" value="pièce_didentite" >
                                                                            <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success piece_didentite_edit" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                                <a  href="{{ route('detaildocument') }}?categoriepiece=piece_didentite"  id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                    <div class="input-group piece_didentite_group_add">
                                                                        <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input piece_identite">
                                                                        <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id='piece_didentite' data-toggle="modal" class="btn btn-md btn-success piece_didentite" onclick="redefinir_formulaire('formulaire_dem_cpc')"  > <i class=" fas fa-plus"></i> </a>                                                                           
                                                                        </div>                                                                  
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Titre de Propriété/Jouissance (<font color="red">*</font>)</label>
                                                                    <div class="input-group titre_de_propriete_group_edit" style="display: none">
                                                                        <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input"  value="titre_de_propriete" >
                                                                        <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="titre_de_propriete_edit" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" onclick="editpiecejointe('titre_de_propriete')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=titre_de_propriete" id="titre_de_propriete_view" class="btn btn-md btn-success titre_de_propriete_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('titre_de_propriete'))
                                                                        <div class="input-group">
                                                                            <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input piece_propriete"  value="Titre de jouissance">
                                                                            <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="titre_de_propriete_edit" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" onclick="editpiecejointe('titre_de_propriete')"> <i class="fas fa-pen"></i> </a>
                                                                                <a  href="{{ route('detaildocument') }}?categoriepiece=titre_de_propriete" id="titre_de_propriete_view" class="btn btn-md btn-success titre_de_propriete_view"> <i class="fas fa-eye"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="input-group titre_de_propriete_group_add">
                                                                            <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input piece_propriete" >
                                                                            <div class="col-md-5">
                                                                                <a href="#addpiecejointe" id='titre_de_propriete' data-toggle="modal" class="btn btn-md btn-success titre_de_propriete"   > <i class=" fas fa-plus"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    <!-- </form> -->
                                                    </section>
                                                <h3>Informations</h3>
                                                <section class="tab-pane" id="progress-company-document">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
                                                      </div>
                                                      
                                                      <br>
                                                    <!-- <form> -->
                                                    <fieldset>
                                                        <legend><span class="legend-fieldest">Dénomination</span></legend>
                                                        <div class="row">
                                                        
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <!-- <label class="form-label" for="progress-basicpill-pancard-input">Type Etablissement</label> -->
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nom Commercial (<font color="red">*</font>)</label>
                                    
                                                                    <input type="text" id="nom_commercial_pp" name="nom_commercial" class="form-control" id="progress-basicpill-vatno-input"  onchange="valider_nom_commercial('nom_commercial_pp');" required>
                                                                    <!--  -->
                                                                    <input type="hidden" name="type_request" value="P1" class="form-control" id="progress-basicpill-pancard-input">
                                                                </div>
                                                                <p class='nomCommercialindispo' style="color:red; display:none"> Ce Nom commercial est indisponible</p>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Enseigne</label>
                                                                    <input type="text" name="enseigne" class="form-control" id="progress-basicpill-vatno-input" >                                                                  
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Sigle</label>
                                                                    <input type="text" name="sigle" class="form-control" id="sigle_pp" >
                                                                </div>
                                                            </div>                                     
                                                        </div>
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Type Entreprise</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Type Etablissement (<font color="red">*</font>)</label>
                                                                    <select id="type_etablissements" name="type_etablissement" data-placeholder="Choisir le type d'établissement..." class="form-control select" style="width: 100%;" required>
                                                                        <option></option>
                                                                            <option value="Principal">Principal</option>
                                                                            <option value="Sécondaire">Sécondaire</option>
                                                                            <option value="Succursale">Succursale</option>
                                                                    </select>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Forme Juridique (<font color="red">*</font>)</label>
                                                                    <select id="forme_juridique_pp" name="forme_juridique_pp" data-placeholder="Choisir la forme juridique ..." class="form-control select" style="width: 100%;" required>
                                                                    <option></option>
                                                                            @foreach ($FJ_EI as $FJ_PP )
                                                                            <option value="{{ $FJ_PP->code }}">{{ $FJ_PP->libelle }}</option>
                                                                            @endforeach
                                                                    </select>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Régime Fiscal</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Chiffre d'affaire Prévisionnel (FCFA) (<font color="red">*</font>)</label> 
                                                                <p class="chiffre_pp" style="color:red; display:none;">La valeur doit être supérieure ou égale à 1 000 000 FCFA</p>
                                                                    <input type="number" min="1000000" name="chiffre_daffaire_previsionnel" class="form-control chiffre_daffaire_prev_pp" id="chiffre_daffaire_prev_pp" onchange="chiffre_daffaire();" required> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Activités</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" >Secteur d'activité (<font color="red">*</font>)</label>
                                                                    <select id="secteur_activite" name="secteur_activite"  class="form-control select" data-placeholder="Choisir le secteur ..." style="width: 100%;" onchange="changeActivite('secteur_activite','activite_principale');" required>                                                                          
                                                                    <option></option>
                                                                            @foreach ($activites as $activite )
                                                                            <option value="{{ $activite->secteur_activite }}">{{ $activite->secteur_activite }}</option>
                                                                            @endforeach
                                                                    </select>                                                                 
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6"> 
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Activité Principale (<font color="red">*</font>)</label>
                                                                        <select id="activite_principale" name="activite_principale" data-placeholder="Choisir l'activité ..." class="form-control select activite_principale" style="width: 100%;" required>
                                                                            <option></option>                                                                            
                                                                        </select>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Objet Social (<font color="red">*</font>)</label>
                                                                    <textarea type="text" name="objet_social" class="form-control" data-placeholder="Saisir les activités que vous exercez" id="objet_social" required></textarea>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Activités Sécondaires</label>
                                                                    <select id="activite_secondaire_pp" name="activite_secondaire" data-placeholder="Choisir l'activité..." class="form-control select" style="width: 100%;"  >
                                                                            <option></option>
                                                                            @foreach ($activites_secondaires as $activites_secondaire )
                                                                            <option value="{{ $activites_secondaire->Code }}">{{ $activites_secondaire->description }}</option>
                                                                            @endforeach  
                                                                    </select>                                                                   
                                                                </div>
                                                            </div> 
                                                            <!-- <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Date de début des activités (<font color="red">*</font>)</label>
                                                                    <input type="date" name="date_debut_activite" class="form-control" id="progress-basicpill-cstno-input" >                                                                                                                                    
                                                                </div>
                                                            </div>                                                         -->
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Employés</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Permanent (<font color="red">*</font>)</label>                                                                    
                                                                    <input type="number" min="0" name="employee_permanant" class="form-control" id="employee_permanant" required> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Temporaire</label>                                                                    
                                                                    <input type="number" min="0" name="employee_temporaire" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Etranger</label>                                                                    
                                                                    <input type="number" min="0" name="employee_etranger" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Personne(s) Pouvant engager la responsabilité de l'entreprise</span></legend>
                                                        <!-- <div class="row">                                                        
                                                        <a href="#addusager" id="addusager" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" > Ajouter usager </a>
                                                        </div> -->
                                                        <div class="row">                                                        
                                                        <div class="col-md-6  ">
                                                                <div class="mb-3" >                                                            
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Dirigeant</label>                                                                    
                                                                    <select id="dirigeants"  name="conjoints[]" data-placeholder="Selectionner le dirigeant..." class="form-control select conjoints" style="width: 100%;" >
                                                                        <option></option>
                                                                            @foreach ($all_usagers as $all_usager )
                                                                                <option value="{{ $all_usager->id }}">{{ $all_usager->CIN }} - {{ $all_usager->NomRaisonSociale }} {{ $all_usager->Prenom }} - {{ $all_usager->Phone_No_ }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>
                                                                </div>                                                                
                                                            </div>                                                            
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Fonction</label>                                                                    
                                                                    <select id="fonction_pp" name="fonction_personne_pouvant_engager" data-placeholder="Choisir la fonction ..." class="form-control select" style="width: 100%;"  >
                                                                            <option></option>
                                                                                @foreach ($fonctions as $fonction )
                                                                                <option value="{{ $fonction->id }}">{{ $fonction->libelle }}</option>
                                                                                @endforeach
                                                                    </select>                                                                    
                                                                </div>                                                                
                                                            </div>
                                                            <div class="col-lg-2 ">
                                                                <div class="mb-4" style="margin-top: 30px;">                                                                                                                              
                                                                <a href="#addusager" id="addusager" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" >Créer Dirigeant</a>                                                                        
                                                                <!-- <a href="#updatepiecejointe" id="certificat_de_residence_edit" data-toggle="modal" class="btn btn-md btn-success add-line"  onclick="editpiecejointe('certificat_de_residence')"> <i class="fas fa-plus"></i> </a> -->
                                                                </div>
                                                            </div>                                                      
                                                        </div>
                                                        
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Adresse de l'entreprise</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-cstno-input">Région (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="region_usager" name="region_entreprise" data-placeholder="Choisir la région" class="form-control select" style="width: 100%;"  onchange="changeValue('region_usager', 'province_usager', 'provinces','region_usager');" required>
                                                                        <option></option>
                                                                        @foreach ($regions as $region )
                                                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                                        @endforeach                                                                         
                                                                    </select>                                                
                                                                </div>
                                                                <div class="mb-3">
                                                                    <!-- <label class="form-label" for="progress-basicpill-cstno-input">Province (<font color="red">*</font>)</label> -->
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Province (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="province_usager" name="province_entreprise" data-placeholder="Choisir la province" class="form-control select" style="width: 100%;"   onchange="changeValue('province_usager', 'commune_usager', 'communes','region_usager');" required>
                                                                        <option></option>                                                                   
                                                                    </select>                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Commune ou Département (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="commune_usager" name="commune_entreprise" data-placeholder="Choisir la commune" class="form-control select" style="width: 100%;"   onchange="changeValue('commune_usager', 'arrondissement_usager', 'arrondissements','province_usager');" required>
                                                                        <option></option>
                                                                    </select>                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Arrondissement</label>                                                                    
                                                                    <select id="arrondissement_usager" name="arrondissement_entreprise" data-placeholder="Choisir l'arrondissement" class="form-control select" style="width: 100%;"  onchange="changeValue('arrondissement_usager', 'secteur_usager', 'secteur_villages','commune_usager');">
                                                                        <option> -- Selectionner --</option>
                                                                    </select>                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Secteur ou Village (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="secteur_usager" name="secteur_entreprise" data-placeholder="Choisir le Secteur ou Village" class="form-control select" style="width: 100%;" required>
                                                                        <option> -- Selectionner --</option>
                                                                    </select>                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Mobile 1 (<font color="red">*</font>)</label>
                                                                    <input type="text" name="mobile_1" class="form-control" id="mobile_pp" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Tel Bureau</label>
                                                                    <input type="text" name="tel_bureau" class="form-control" id="tel_bureau_pp">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Boite Postale (<font color="red">*</font>)</label>
                                                                    <input type="text" name="boite_postale" class="form-control" id="progress-basicpill-cstno-input" required>
                                                                </div>
                                                                <!-- <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Adresse</label>
                                                                    <input type="text" name="adresse" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div> -->
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">E-mail (<font color="red">*</font>)</label>
                                                                    <input type="text" name="email" class="form-control" id="progress-basicpill-cstno-input" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Site Web</label>
                                                                    <input type="text" name="site_web" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                     </fieldset> <br>                                                        
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Références Cadastrales</span></legend>
                                                        <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Section (<font color="red">*</font>)</label>   
                                                                        <input type="text" name="section" class="form-control" required> 
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Lot (<font color="red">*</font>)</label>   
                                                                        <input type="text" name="lot" class="form-control" required> 
                                                                    </div>                                                                    
                                                                    <div class="col-md-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Parcelle (<font color="red">*</font>)</label>   
                                                                        <input type="text" name="parcelle" class="form-control" required> 
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Type Terrain (<font color="red">*</font>)</label>   
                                                                        <select id="type_terrain" name="type_terrain" data-placeholder="Choisir le type terrain" class="form-control select" style="width: 100%;" >
                                                                            <option></option>
                                                                            <option value="0">Parcelle</option>
                                                                            <option value="1">Terrain</option>
                                                                        </select>  
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Usage Terrain (<font color="red">*</font>)</label>   
                                                                        <select id="usage" name="usage" data-placeholder="Choisir l'usage" class="form-control select" style="width: 100%;" required>
                                                                            <option></option>
                                                                                @foreach ($usage_terrains as $usage_terrain )
                                                                                    <option value="{{ $usage_terrain->Code }}">{{ $usage_terrain->Libelle }}</option>
                                                                                @endforeach
                                                                        </select>  
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Superficie en m² (<font color="red">*</font>)</label>   
                                                                        <input type="number" min="0" name="superficie" class="form-control" > 
                                                                    </div>
                                                                </div>                              

                                                     </fieldset><br>
                                    
                                                </section>
                                                <h3>Signature</h3>
                                                <section class="tab-pane" id="progress-bank-detail">
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                                          </div>
                                                        <br>
                                                      <!-- <form> -->
                                                      <fieldset>
                                                        <legend><span class="legend-fieldest">Signature</span></legend>
                                                          <div class="row">
                                                                <div class="col-lg-6">
                                                                <div class="mb-3" id="sign_pp">
                                                                      <!-- <label class="form-label" for="progress-basicpill-namecard-input">Signez dans la case ci-dessous</label> -->
                                                                       <!-- <textarea name="signed" class="form-control" id="signature_pp" style="dislpay:none"></textarea>  -->
                                                                       <input type="hidden" name="signed" style="display:none" class="form-control" id="signature_pp">
                                                                       <button class="button-sign" id="clear_pp">Effacer Signature</button>
                                                                      <!--<button class="button-sign" id="clear">Save</button> -->
                                                                      <!-- <textarea type="text" name="email" class="form-control" id="progress-basicpill-namecard-input" cols="30" rows="10"></textarea> -->
                                                                  </div>
                                                              </div>                                                             
                                                          </div>
                                                      </fieldset><br>
                                                      <fieldset>
                                                        <legend><span class="legend-fieldest">Confirmation</span></legend>
                                                          <div class="row">
                                                              <div class="col-lg-12">
                                                                  <div class="mb-6">
                                                                  <label class="confirme">Je certifie que les documents joints sont authentiques (absence de faux et usage de faux)
                                                                        et les déclarations sont sincères. Je m'engage à apporter la totalité des dossiers en cas de besoin.
                                                                        <input type="checkbox" id="confirmation_pp"><span class="checkmark"></span>
                                                                   </label> 
                                                                        <!-- <input type="checkbox" id="switch9" switch="dark" checked /> -->
                                                                  </div>

                                                              </div>
                                                             
                                                          </div>
                                                      </fieldset>                                    
                                                    </div>
                                                </section>
                                                <h3>Confirmation</h3>
                                                <section class="tab-pane" id="progress-confirm-detail">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                      </div>
                                                      <br><br>
                                                    
                                                        <div class="row">
                                                            <center><h2 style="padding-bottom: 1rem;">Résume</h2></center>
                                                            <p style="display:none; background:red" class="signature_resume">Veuillez signer avant de valider votre demande</p>
                                                            <table class="table" style="background-color: #f0f0f0;">
                                                                <tbody> 
                                                                    <tr>
                                                                        <td>Nom Commercial </td>
                                                                        <td><strong id="val_denomination_pp"></strong></td>                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sigle </td>
                                                                        <td><strong id="val_sigle_pp"></strong></td>                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Type Entreprise </td>
                                                                        <td><strong id="val_type_etablissement_pp"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>chiffre d'affaire</td>
                                                                        <td><strong id="val_chiffre_daffaire_prev_pp"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Forme Juridique</td>
                                                                        <td><strong id="val_forme_juridique_pp"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Activité Principale</td>
                                                                        <td><strong id="val_activite_principale"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Objet Social</td>
                                                                        <td><strong id="val_objet_social"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Employé Permanent</td>
                                                                        <td><strong id="val_employee_permanant"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Adresse Entreprise</td>
                                                                        <td><strong id="val_region_usager"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Contacts Entreprise</td>
                                                                        <td><strong id="val_mobile_pp"></strong></td>
                                                                    </tr>                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                            
                                                        </div>
                                                    
                                                </section>
                                                
                                            </div>
                                            
                                        </form>                                     
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        <!-- end row -->               
