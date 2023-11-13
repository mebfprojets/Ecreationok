
                        <!-- end row -->
                  
                        <div class="row" id="progrss-wizar2" style="display:none">
                            <div class="col-lg-12">
                                <div class="card">  
                                    <div class="card-body">
                                    <h2 class="font-size-20 mb-4 text-center">Formulaire Personne Morale</h2>
                                        <div id="progrss-wizard" class="twitter-bs-wizard">
                                            {{-- <ul class="twitter-bs-wizard-nav nav-justified">
                                                <li class="nav-item">
                                                    <a href="#progress-seller-detailss" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">01</span>
                                                        <span class="step-title">Formalités et Pièces</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#progress-company-documents" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">02</span>
                                                        <span class="step-title">Entreprise</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="#progress-bank-details" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">03</span>
                                                        <span class="step-title">Signature</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#progress-confirm-details" class="nav-link" data-toggle="tab">
                                                        <span class="step-number">04</span>
                                                        <span class="step-title">Validation</span>
                                                    </a>
                                                </li>
                                            </ul> --}}

                                            {{-- <div id="bar" class="progress mt-4">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                                            </div> --}}
                                         <form action="{{ route('demande.store') }}" id="morale" method="post" class='moral'>
                                            @csrf
                                            <input type="hidden" value='{{ $usager->id }}'name="usager_id">
                                            <div class="tab-content twitter-bs-wizard-tab-content">
                                            <h3>Formalités et Pieces</h3>
                                                <section class="tab-pane" id="progress-seller-detailss">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                                      </div>
                                                      <br>
                                                
                                                    <div class="row">
                                                            <h5 class="font-size-14 mb-4 text-center">Enregistrer les pièces requises</h5>
                                                            <div class="row text-center" style="border: 1px solid rgb(116, 116, 105); margin-bottom:5px;"  class="mb-2">
                                                                <h4 class="font-size-14 mb-4">Formalités</h4>
                                                                
                                                                <div class="row" style="margin-left:10px;" id='prestation_ES'>
                                                            <div class="form-check col-md-3">
                                                                <input class="form-check-input"  type="checkbox" id="ccp_es" name='ccp_es' />
                                                                <label class="form-check-label" for="formCheck1">
                                                                    CPC
                                                                </label>
                                                            </div>
                                                        @foreach ($prestation_PMs as $prestation_PM)
                                                            <div class="form-check col-md-3">
                                                                <input class="form-check-input"  type="checkbox" id="formCheck1" disabled checked/>
                                                                <label class="form-check-label" for="formCheck1">
                                                                    {{ $prestation_PM->type }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                           
                                                           
                                                        </div>
                                                        </div>
                                                            <!-- <center><p class='alerte_piece' style="color:red; display:none; background:"> Veuillez renseigner les pièces obligatoires</p></center> -->
                                                            <center><div class="alert-warning alerte_piece_pm" style="color:red; display:none;">
                                                                <p>Veuillez renseigner les pièces obligatoires</p>
                                                            </div>
                                                            </center>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Déclaration sur l'honneur/Casier</label>
                                                                    <div class="input-group declaration_group_edit" style="display: none" >
                                                                        <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration"  value="Declaration sur l'honneur" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success" onclick="editpiecejointe('declaration')" > <i class="fas fa-pen"></i> </a>
                                                                             <a href="{{ route('detaildocument') }}?categoriepiece=declaration"  id="declaration_view"   class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @if(returnpieceinfos('declaration'))
                                                                    <div class="input-group">
                                                                        <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration piece_declaration"  value="Declaration sur l'honneur" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success" onclick="editpiecejointe('declaration')" > <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=declaration" id="declaration_view"   class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group declaration_group_add">
                                                                    <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration piece_declaration">
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id="declaration"  data-toggle="modal"  class="btn btn-md btn-success declaration"  > <i class=" fas fa-plus"></i> </a>
                                                                      
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Acte de Depots</label>
                                                                    <div class="input-group acte_de_depot_group_edit" style="display: none">
                                                                        <input type="text" name="acte_de_depot_input" id="acte_de_depot_input" disabled class="form-control col-md-7 acte_de_depot_input"  value="Acte de depot" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="acte_de_depot_edit"   data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('acte_de_depot')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=acte_de_depot" id="acte_de_depot_view"   class="btn btn-md btn-success acte_de_depot_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('acte_de_depot'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="acte_de_depot_input" id="acte_de_depot_input" disabled class="form-control col-md-7 acte_de_depot_input piece_acte_depot"  value="Acte de depot" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="acte_de_depot_edit"   data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('acte_de_depot')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=acte_de_depot" id="acte_de_depot_view"   class="btn btn-md btn-success acte_de_depot_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div class="input-group acte_de_depot_group_add">
                                                                        <input type="text" name="acte_de_depot_input" id="acte_de_depot_input" disabled class="form-control col-md-7 acte_de_depot_input piece_acte_depot">
                                                                         <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id='acte_de_depot' data-toggle="modal" class="btn btn-md btn-success acte_de_depot" onclick="redefinir_formulaire('formulaire_dem_cpc')"  > <i class=" fas fa-plus"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                 @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Statut</label>
                                                                    <div class="input-group edit_statut_group_hide " style="display: none">
                                                                        <input type="text" name="statut" id="statut_input" disabled class="form-control col-md-7 statut_input"  value="staut" >
                                                                         <div class="col-md-5">
                                                                        <a href="#updatepiecejointe" id="statut_edit"  data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('acte_de_depot')"> <i class="fas fa-pen"></i> </a>
                                                                         <a href="{{ route('detaildocument') }}?categoriepiece=statut"  id="statut_view"   class="btn btn-md btn-success statut_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @if(returnpieceinfos('statut'))
                                                                    <div class="input-group" >
                                                                        <input type="text" name="statut" id="statut_input" disabled class="form-control col-md-7 statut_input piece_statut"  value="staut" >
                                                                         <div class="col-md-5">
                                                                        <a href="#updatepiecejointe" id="statut_edit"  data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('statut')"> <i class="fas fa-pen"></i> </a>
                                                                        <a href="{{ route('detaildocument') }}?categoriepiece=statut"  id="statut_view"   class="btn btn-md btn-success statut_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group add_statut_group">
                                                                    <input type="text" name="statut" id="statut_input" disabled class="form-control col-md-7 statut_input piece_statut">
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id='statut' data-toggle="modal" class="btn btn-md btn-success statut" onclick="redefinir_formulaire('formulaire_dem_cpc')"  > <i class=" fas fa-plus"></i> </a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Formulaire RCCM</label>
                                                                    <div class="input-group formulaire_rccm_group_edit" style="display: none">
                                                                        <input type="text" name="formulaire_rccm" id="formulaire_rccm_input" disabled class="form-control col-md-7 formulaire_rccm_input"  value="Formulaire RCCM" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="formulaire_rccm_edit"  data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('formulaire_rccm')"> <i class="fas fa-pen"></i> </a>
                                                                           <a href="{{ route('detaildocument') }}?categoriepiece=formulaire_rccm" id="formulaire_rccm_view"   class="btn btn-md btn-success formulaire_rccm_view"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                 @if(returnpieceinfos('formulaire_rccm'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="formulaire_rccm" id="formulaire_rccm_input" disabled class="form-control col-md-7 formulaire_rccm_input piece_rccm"  value="Formulaire RCCM" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="formulaire_rccm_edit"  data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('formulaire_rccm')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=formulaire_rccm" id="formulaire_rccm_view"   class="btn btn-md btn-success formulaire_rccm_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group formulaire_rccm_group_add">
                                                                    <input type="text" name="formulaire_rccm" id="formulaire_rccm_input" disabled class="form-control col-md-7 formulaire_rccm_input piece_rccm">
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id='formulaire_rccm' data-toggle="modal" class="btn btn-md btn-success formulaire_rccm" onclick="redefinir_formulaire('formulaire_dem_cpc')" > <i class=" fas fa-plus"></i> </a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="progress-basicpill-firstname-input">Piece d'identité</label>
                                                                        <div class="input-group piece_didentite_group_edit" style="display: none">
                                                                            <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input" value="Piece d'identité" >
                                                                             <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                                 <a href="{{ route('detaildocument') }}?categoriepiece=piece_didentite" id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a> 
                                                                            </div>
                                                                        </div>
                                                                     @if(returnpieceinfos('piece_didentite'))
                                                                        <div class="input-group">
                                                                            <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input piece_identite" value="Piece d'identité" >
                                                                             <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                                <a href="{{ route('detaildocument') }}?categoriepiece=piece_didentite"  id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a>
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
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Titre de Propriete/Jouissance</label>
                                                                    <div class="input-group titre_de_propriete_group_edit" style="display: none">
                                                                        <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input"  value="Titre de propriété" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="titre_de_propriete_edit" data-toggle="modal"  class="btn btn-md btn-success titre_de_propriete" onclick="editpiecejointe('titre_de_propriete')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=titre_de_propriete" id="titre_de_propriete_view"  class="btn btn-md btn-success titre_de_propriete_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @if(returnpieceinfos('titre_de_propriete'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input piece_propriete"  value="Titre de propriété" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="titre_de_propriete_edit" data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('titre_de_propriete')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=titre_de_propriete" id="titre_de_propriete_view"  class="btn btn-md btn-success titre_de_propriete_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="input-group titre_de_propriete_group_add">
                                                                        <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input piece_propriete">
                                                                        <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id='titre_de_propriete' data-toggle="modal" class="btn btn-md btn-success titre_de_propriete"   > <i class=" fas fa-plus"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6" id='block_formulaire_cpc' style="display:none;">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Formulaire de demande CPC</label>
                                                                    <div class="input-group formulaire_cpc_es_group_edit" style="display: none">
                                                                        <input type="text" name="formulaire_cpc_es" id="formulaire_cpc_es" disabled class="form-control col-md-7 formulaire_cpc_es_input"  value="Formulaire de demande CPC" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="formulaire_cpc_es_edit" data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('formulaire_cpc_es')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=formulaire_cpc_es" id="formulaire_cpc_es_view"  class="btn btn-md btn-success formulaire_cpc_es_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @if(returnpieceinfos('formulaire_dem_cpc'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="formulaire_cpc_es" id="formulaire_cpc_es_input" disabled class="form-control col-md-7 formulaire_cpc_es_input formulaire_cpc_es"  value="Formulaire de demande CPC" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="formulaire_cpc_es_edit" data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('formulaire_cpc_es')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=formulaire_cpc_es" id="formulaire_cpc_es_view"  class="btn btn-md btn-success formulaire_cpc_es_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="input-group formulaire_cpc_es_group_add">
                                                                        <input type="text" name="formulaire_cpc_es" id="formulaire_cpc_es_input" disabled class="form-control col-md-7 formulaire_cpc_es_input piece_propriete">
                                                                        <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id='formulaire_cpc_es' data-toggle="modal" class="btn btn-md btn-success formulaire_cpc_es"   > <i class=" fas fa-plus"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                     
                                                    <!-- </form> -->
                                                    </section>
                                                <h3>Entreprise</h3>
                                                <section class="tab-pane" id="progress-company-documents">
                                                <div>
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
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nom Commercial (<font color="red">*</font>)</label>
                                                                    <input type="text" id="nom_commercial_pm" name="nom_commercial" class="form-control"  onchange="valider_nom_commercial('nom_commercial_pm');" required>
                                                                    <!--  -->
                                                                    <input type="hidden" name="type_request"  class="form-control" id="type_demande">
                                                                    <!-- <input type="text" name="nom" class="form-control" id="progress-basicpill-pancard-input"> -->
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
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Dénomination Sociale (<font color="red">*</font>)</label>
                                                                    <input type="text" id="denomination_sociale_pm" name="denomination_sociale" class="form-control"  onchange="valider_nom_commercial('denomination_sociale_pm');" required>
                                                                </div>
                                                                <p class='nomCommercialindispo' style="color:red; display:none"> Cette Dénomination Sociale est indisponible</p>
                                                            </div>   
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Sigle</label>
                                                                    <input type="text" name="sigle" class="form-control" id="sigle_pm" >
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
                                                                    <select id="type_etablissement_pm" name="type_etablissement" data-placeholder="Choisir le type d'établissement ..." class="form-control select" style="width: 100%;" required>
                                                                        <option></option>
                                                                            <option value="Principal">Principal</option>
                                                                            <option value="Sécondaire">Sécondaire</option>
                                                                            <option value="Succursale">Succursale</option>
                                                                    </select>
                                                                </div>                                                                
                                                            </div>
                                                            <div class="col-lg-6" id="formjuridiquees">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Forme Juridique (<font color="red">*</font>)</label>
                                                                    <select id="forme_juridique_pm" name="forme_juridique_es" data-placeholder="Choisir la forme juridique ..." class="form-control select" style="width: 100%;">
                                                                    <option></option>
                                                                            @foreach ($FJ_ES as $FJ_PM )
                                                                            <option value="{{ $FJ_PM->code }}">{{ $FJ_PM->libelle }}</option>
                                                                            @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                                <div class="col-lg-6" style="display:none" id="formjuridiquegie">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Forme Juridique GIE (<font color="red">*</font>)</label>
                                                                        <select id="forme_juridique_gie" name="forme_juridique_gie" data-placeholder="Choisir la forme juridique ..." class="form-control select" style="width: 100%;">
                                                                        <option></option>
                                                                                @foreach ($FJ_GIE as $FJ_PM )
                                                                                <option value="{{ $FJ_PM->code }}">{{ $FJ_PM->libelle }}</option>
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
                                                                <p class="chiffre_pm" style="color:red; display:none;">La valeur doit être supérieure ou égale à 1 000 000 FCFA</p>                                                        
                                                                    <input type="number" name="chiffre_daffaire_previsionnel" class="form-control" id="chiffre_daffaire_prev_pm" onchange="chiffre_daffaire();" required>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Activités</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Secteur d'activité (<font color="red">*</font>)</label>
                                                                    <select id="secteur_activite_pm" name="secteur_activite" data-placeholder="Choisir l'activité ..." class="form-control select" onchange="changeActivite('secteur_activite_pm','activite_principale_pm');" style="width: 100%;" required>
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
                                                                        <select id="activite_principale_pm" name="activite_principale" data-placeholder="Choisir l'activité ..." class="form-control select" style="width: 100%;" required>
                                                                            <option></option>                                                                           
                                                                        </select>                                                           
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Objet Social (<font color="red">*</font>)</label>
                                                                    <textarea type="text" name="objet_social" class="form-control" data-placeholder="Saisir les activités que vous exercez" id="objet_social_pm" required></textarea>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Activités Sécondaires</label>
                                                                    <select id="activite_secondaire" name="activite_secondaire" data-placeholder="Choisir l'activité ..." class="form-control select" style="width: 100%;"  >
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
                                                            </div>                                                              -->
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Capital</span></legend>
                                                        <div class="row">                                                            
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Dont Numéraire</label>
                                                                    <input type="number" name="capital_en_numeraire" class="form-control" id="dont_numeraire" onchange="montantCapital();" required>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Dont En industrie</label>
                                                                    <input type="number" name="capital_en_industrie" class="form-control" id="dont_industrie" onchange="montantCapital();">
                                                                </div>
                                                            </div> -->
                                                            <div class="col-lg-4"> 
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Dont Nature</label>
                                                                    <input type="number" name="capital_en_nature" class="form-control" id="dont_nature" onchange="montantCapital();" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Montant Total</label>
                                                                    <input type="number" name="montant_capital"   class="form-control" style="pointer-events: none;" id="montant_capital" >
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="row">                                                        
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Montant Action ou Montant Part Social</label>
                                                                    <input type="number" name="montant_action" class="form-control" id="montant_action" onchange="montantAction();" required>
                                                                </div>
                                                            </div>  
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nombre d'Actions ou De Parts Sociales</label>
                                                                    <input type="number" name="nombre_action" class="form-control" style="pointer-events: none;" id="nbre_action">
                                                                </div>
                                                            </div>                                    
                                                        </div>
                                                     </fieldset> <br>                                                     
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Employés</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Permanent (<font color="red">*</font>)</label>                                                                    
                                                                    <input type="number" name="employee_permanant" class="form-control" id="employee_permanant_pm" required> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Temporaire</label>                                                                    
                                                                    <input type="number" name="employee_temporaire" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Etranger</label>                                                                    
                                                                    <input type="number" name="employee_etranger" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Dirigeant Principal</span></legend>
                                                        <!-- <div class="row">                                                        
                                                        <a href="#addusager" id="addusager" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" > Ajouter usager </a>
                                                        </div> -->
                                                        <div class="row">
                                                            <div class="row">                                                                                                                
                                                            <div class="col-md-4">
                                                                <div class="mb-3" >                                                            
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Dirigeant (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="dirigeant_principal"  name="dirigeant" data-placeholder="Sélectionner le dirigeant ..." class="form-control select conjoints" style="width: 100%;"  >
                                                                        <option></option>
                                                                            @foreach ($all_usagers as $all_usager )
                                                                                <option value="{{ $all_usager->id }}">{{ $all_usager->CIN }}-{{ $all_usager->NomRaisonSociale }}{{ $all_usager->prenom }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>
                                                                </div>                                                                
                                                            </div>                              
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Fonction (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="fonction_dirigeant_p" name="fonction_dirigeant_p" data-placeholder="Choisir l'activité ..." class="form-control select" style="width: 100%;" >
                                                                            <option></option>
                                                                                @foreach ($fonctions as $fonction )
                                                                                <option value="{{ $fonction->id }}">{{ $fonction->libelle }}</option>
                                                                                @endforeach
                                                                    </select>                                                                    
                                                                </div>                                                                
                                                            </div>                                                            
                                                            <div class="col-lg-2">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">% Capital (<font color="red">*</font>)</label>
                                                                    <input type="number" name="capital_dirigeant" class="form-control" id="progress-basicpill-cstno-input" >                                                                   
                                                                </div>
                                                            </div>                                                            
                                                         </div>
                                                        </div>
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Associé (s)</span></legend>
                                                        <!-- <div class="row">                                                        
                                                        <a href="#addusager" id="addusager" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" > Ajouter usager </a>
                                                        </div> -->
                                                        <div class="row field_wrapper">
                                                            <div class="row">                                                                                                                
                                                            <div class="col-md-4">
                                                                <div class="mb-3" >                                                            
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Associé (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="dirigeant"  name="associes[]" data-placeholder="Sélectionner le dirigeant ..." class="form-control select conjoints" style="width: 100%;"  >
                                                                        <option></option>
                                                                            @foreach ($all_usagers as $all_usager )
                                                                                <option value="{{ $all_usager->id }}">{{ $all_usager->CIN }}-{{ $all_usager->NomRaisonSociale }}{{ $all_usager->prenom }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>
                                                                </div>                                                                
                                                            </div>                                                            
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Fonction (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="fonction_dirigeant" name="fonction_associes[]" data-placeholder="Choisir l'activité ..." class="form-control select" style="width: 100%;" >
                                                                            <option></option>
                                                                                @foreach ($fonctions as $fonction )
                                                                                <option value="{{ $fonction->id }}">{{ $fonction->libelle }}</option>
                                                                                @endforeach
                                                                    </select>                                                                    
                                                                </div>                                                                
                                                            </div>                                                            
                                                            <div class="col-lg-2">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">% Capital (<font color="red">*</font>)</label>
                                                                    <input type="number" name="capital_associes[]" class="form-control" id="progress-basicpill-cstno-input" >                                                                   
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-2">
                                                                <div class="mb-" style="margin-top: 30px;"> 
                                                                <a href="javascript:void(0);"  class="btn btn-md btn-success add-line"> <i class="fas fa-plus"></i> </a>
                                                                <a href="#addusager" id="addusager" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" >Créé Dirigeant</a>
                                                                </div>
                                                            </div>
                                                         </div>
                                                        </div>
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Notaire</span></legend>
                                                        <div class="row">
                                                        <div class="col-md-4">
                                                                <div class="mb-3" >                                                            
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nom et Prénom</label>                                                                    
                                                                    <select id="notaire"  name="notaire" data-placeholder="Selectionner notaire ..." class="form-control select conjoints" style="width: 100%;" >
                                                                        <option></option>
                                                                            @foreach ($all_usagers as $all_usager )
                                                                                <option value="{{ $all_usager->id }}">{{ $all_usager->CIN }} - {{ $all_usager->NomRaisonSociale }} {{ $all_usager->Prenom }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Commissaires aux comptes</span></legend>
                                                        <div class="row com_wrapper">
                                                            <div class="row">                                                                                                  
                                                            <div class="col-md-5">
                                                                <div class="mb-3">                                                
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nom et Prénom</label>                                                                    
                                                                    <select id="commissaire1"  name="commissaire[]" data-placeholder="Selectionner le commissaire ..." class="form-control select conjoints" style="width: 100%;">
                                                                        <option></option>
                                                                            @foreach ($all_usagers as $all_usager )
                                                                                <option value="{{ $all_usager->id }}">{{ $all_usager->CIN }} - {{ $all_usager->NomRaisonSociale }} {{ $all_usager->Prenom }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>
                                                                </div>                                                                
                                                            </div>                                                            
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Qualité</label>                                                                    
                                                                    <select id="qualite_commissaire1" name="qualite_commissaire[]" data-placeholder="Choisir la qualite ..." class="form-control select" style="width: 100%;" >                                                                                                                                                       
                                                                                <option value="0" Selected>Titulaire</option>                                                                                                                                                          
                                                                    </select>                                                                    
                                                                </div>                                                            
                                                            </div>                                                 
                                                         </div>
                                                        </div>   
                                                        <div class="row com_wrapper">
                                                            <div class="row">                                                                                                  
                                                            <div class="col-md-5">
                                                                <div class="mb-3">                                                
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nom et Prénom</label>                                                                    
                                                                    <select id="commissaire2"  name="commissaire[]" data-placeholder="Selectionner le commissaire ..." class="form-control select conjoints" style="width: 100%;" >
                                                                        <option></option>
                                                                            @foreach ($all_usagers as $all_usager )
                                                                                <option value="{{ $all_usager->id }}">{{ $all_usager->CIN }} - {{ $all_usager->NomRaisonSociale }} {{ $all_usager->Prenom }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>
                                                                </div>                                                                
                                                            </div>                                                            
                                                            <div class="col-lg-5">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Qualité</label>                                                                    
                                                                    <select id="qualite_commissaire2" name="qualite_commissaire[]" data-placeholder="Choisir la qualité ..." class="form-control select" style="width: 100%;">                                                                                                                                                         
                                                                                <option value="1" selected>Supléant</option>                                                                                                                                                         
                                                                    </select>                                                                    
                                                                </div>                                                            
                                                            </div>                                                 
                                                         </div>
                                                        </div>                                                     
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Adresse & Contact de l'entreprise</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Région (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="region_entreprise" name="region_entreprise" data-placeholder="Choisir la région" class="form-control select" style="width: 100%;"  onchange="changeValue('region_entreprise', 'province_entreprise', 'provinces','region_entreprise');" required>
                                                                        <option></option>
                                                                        @foreach ($regions as $region )
                                                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                                        @endforeach
                                                                         
                                                                    </select>                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Province (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="province_entreprise" name="province_entreprise" data-placeholder="Choisir la province" class="form-control select" style="width: 100%;"   onchange="changeValue('province_entreprise', 'commune_entreprise', 'communes','region_entreprise');" required>
                                                                        <option></option>                                                                     
                                                                    </select>                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Commune ou Département (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="commune_entreprise" name="commune_entreprise" data-placeholder="Choisir la commune" class="form-control select" style="width: 100%;"   onchange="changeValue('commune_entreprise', 'arrondissement_entreprise', 'arrondissements','province_entreprise');" >
                                                                        <option></option>
                                                                    </select>
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Arrondissement</label>                                                                    
                                                                    <select id="arrondissement_entreprise" name="arrondissement_entreprise" data-placeholder="Choisir l'arrondissement" class="form-control select" style="width: 100%;"  onchange="changeValue('arrondissement_entreprise', 'secteur_entreprise', 'secteur_villages','commune_entreprise');" required>
                                                                        <option> -- Selectionner --</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Secteur ou Village (<font color="red">*</font>)</label>                                                                    
                                                                    <select id="secteur_entreprise" name="secteur_entreprise" data-placeholder="Choisir le Secteur ou Village" class="form-control select" style="width: 100%;" required>
                                                                        <option> -- Selectionner --</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Mobile 1 (<font color="red">*</font>)</label>
                                                                    <input type="text" name="mobile_1" class="form-control" id="mobile_pm" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Tel Bureau</label>
                                                                    <input type="text" name="tel_bureau" class="form-control"  id="tel_bureau_pm">
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
                                                                    <input type="text" name="email" class="form-control" placeholder="example@gmail.com" id="progress-basicpill-cstno-input" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Site Web</label>
                                                                    <input type="text" name="site_web" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                     </fieldset> <br> 
                                                    <!-- </form> -->

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
                                                                        <select id="type_terrain_pm" name="type_terrain" data-placeholder="Choisir le type terrain" class="form-control select" style="width: 100%;" >
                                                                            <option></option>
                                                                            <option value="0">Parcelle</option>
                                                                            <option value="1">Terrain</option>
                                                                        </select>  
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label" for="progress-basicpill-cstno-input">Usage (<font color="red">*</font>)</label>   
                                                                        <select id="usage_terrain" name="usage" data-placeholder="Choisir l'usage" class="form-control select" style="width: 100%;" required>
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
                                                <section class="tab-pane" id="progress-bank-details">
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
                                                                <div class="mb-3" id="sign_pm">
                                                                      <!-- <label class="form-label" for="progress-basicpill-namecard-input">Signez dans la case ci-dessous</label> -->
                                                                       <!-- <textarea name="signed" class="form-control signature" id="" style="dislpay:none;"></textarea> -->
                                                                       <input type="hidden" name="signed" class="form-control" id="signature_pm">
                                                                       <button class="button-sign" id="clear_pm">Effacer Signature</button>
                                                                      <!--<button class="button-sign" id="clear">Save</button> -->
                                                                      <!-- <textarea type="text" name="email" class="form-control" id="progress-basicpill-namecard-input" cols="30" rows="10"></textarea> -->
                                                                  </div>
                                                              </div> 
                                                          </div>
                                                                  
                                                         
                                                      </fieldset><br><br>

                                                      <fieldset class="confirm">
                                                        <legend><span class="legend-fieldest">Confirmation</span></legend>
                                                          <div class="row">
                                                              <div class="col-lg-12">
                                                                  <div class="mb-6">
                                                                  <label class="confirme">Je certifie que les documents joints sont authentiques (absence de faux et usage de faux)
                                                                        et les déclarations sont sincères. Je m'engage à apporter la totalité des dossiers en cas de besoin.
                                                                        <input type="checkbox" id="confirmation_pm"><span class="checkmark"></span>
                                                                   </label>                                                              
                                                                  </div>

                                                              </div>
                                                             
                                                          </div>
                                                      </fieldset>                                                          
                                                         
                                                    </div>
                                                </section>
                                                <h3>Confirmer</h3>
                                                <section class="tab-pane" id="progress-confirm-detail">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                      </div>
                                                      <br>
                                                    <!-- <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="row text-center" style="border: 1px solid rgb(116, 116, 105); margin-bottom:5px;"  class="mb-2">
                                                                <h5 class="font-size-14 mb-4">Formalités</h5>
                                                                
                                                                <div class="row" style="margin-left:10px;" id='prestation_ES'>
                                                            <div class="form-check col-md-3">
                                                                <input class="form-check-input"  type="checkbox" id="formCheck1" name='ccp_es' />
                                                                <label class="form-check-label" for="formCheck1">
                                                                    CPC
                                                                </label>
                                                            </div>
                                                            @foreach ($prestation_PMs as $prestation_PM)
                                                            <div class="form-check col-md-3">
                                                                <input class="form-check-input"  type="checkbox" id="formCheck1" disabled checked/>
                                                                <label class="form-check-label" for="formCheck1">
                                                                    {{ $prestation_PM->type }}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                           
                                                           
                                                        </div>
                                                    </div> -->
                                                        <div class="row">
                                                            <h2 style="padding-bottom: 1rem;">Résume</h2>
                                                            <p style="display:none; background:red" class="signature_resume">Veuillez signer avant de valider votre demande</p>
                                                            <table class="table" style="background-color: #f0f0f0;">
                                                                <tbody>
                                                                <tr>
                                                                        <td>Nom Commercial </td>
                                                                        <td><strong id="val_nom_commercial_pm"></strong></td>                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Denomination </td>
                                                                        <td><strong id="val_denomination_sociale_pm"></strong></td>                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sigle </td>
                                                                        <td><strong id="val_sigle_pm"></strong></td>                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Type Entreprise </td>
                                                                        <td><strong id="val_type_etablissement_pm"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Chiffre d'affaire Prévisionnel</td>
                                                                        <td><strong id="val_chiffre_daffaire_prev_pm"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Capital</td>
                                                                        <td>Montant: <strong id="val_capital"> </strong>    
                                                                        Dont Numeraire: <strong id="val_dont_numeraire"></strong>  
                                                                        Dont Nature: <strong id="val_dont_nature"></strong>  
                                                                        Montant Action: <strong id="val_montant_action"></strong>  
                                                                        Nombre Action: <strong id="val_nbre_action"></strong>
                                                                        </td>                                                    
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Forme Juridique</td>
                                                                        <td><strong id="val_forme_juridique_pm"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Activité Principale</td>
                                                                        <td><strong id="val_activite_principale_pm"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Objet Social</td>
                                                                        <td><strong id="val_objet_social_pm"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Employé Permanent</td>
                                                                        <td><strong id="val_employee_permanant_pm"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Adresse</td>
                                                                        <td><strong id="val_region_entreprise"></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Contacts</td>
                                                                        <td><strong id="val_mobile_pm"></strong></td>
                                                                    </tr>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>                                                            
                                                        </div>                                                    
                                                </section>
                                                
                                            </div>
                                            
                                        </form>

                                      
                                            <!-- <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                                            </ul> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        
                    
