@extends('backend.adminlte.main')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <button type="button" class="btn btn-outline-danger me-2 cancel" onclick="history.back()"><i class="fas fa fa-ban"></i> Retour</button>
        <center><h4>
        {{$demandes->commercial_name}}    
        - @if($demandes->company_type=="EI")
                      Personne Physique
                    @else
                    Personne Morale
                    @endif
                    - {{$cefore_code}}</h4></center>
                    <br>
<form action="{{ route('demande.update',$demandes->id)}}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                  @can('valider.demande',Auth::user())
                  @if($demandes->organisation_code== Auth::user()->organisation || Auth::user()->organisation=="001000")
            @if($demandes->etat !=1 && $demandes->paye==1 )  
            <center><a  style="margin-left:10px;" href="#modal-confirm" data-toggle="modal" data-dismiss="modal" id="declaration_edit"  class="btn btn-md btn-success declaration" > <i class="fa fa-check-circle"></i> Valider </a>
            <a  style="margin-left:10px;" id="declaration_edit" href="#modal-confirm-rejet" data-toggle="modal" data-dismiss="modal" style="display:none" class="btn btn-md btn-danger declaration" > <i class="fa fa-window-close"></i> Rejéter </a><br></center>
            @endif
            @if($demandes->motif!="")
            <label class="form-label" style="color:red; font-size:16px;" for="progress-basicpill-vatno-input">                              
                              Motif du Rejet : {{$demandes->motif}}   <br>
                              Envoyée Pour Traitement                           
            </label>
            @endif
          
        @endif
        @endcan
       @if($demandes->RCCM !="")
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Formalites retour</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
            @foreach($typepieceformaliteretours as $typejointe)
              <div class="col-md-3" style="padding:5px;">
                <div class="input-group">
                <!-- <label>Nom Pièce</label> -->
               
                <input class="form-control"  disabled="disabled" type="text" value="{{$typejointe->libelle}}">
                @if(getformalite($typejointe->id,$demandes->id))
                @can('save_formalite_retour',Auth::user())
                  <a  href="#modal-update-piece" data-toggle="modal"  onclick="gettypepiece_update('{{$typejointe->id}}','{{$typejointe->libelle}}');" style="margin-left:10px;"  class="btn btn-md btn-success" > <i class="fas fa-pen"></i> </a>
                @endcan
                  <a href="{{ route('show_formalite_retour',getformalite($typejointe->id,$demandes->id)) }}" style="margin-left:10px;" target="_blank"   class="btn btn-md btn-success "> <i class="fas fa-eye"></i> </a>
                @else
                @can('save_formalite_retour',Auth::user())
                    <a href="#modal-add-piece" data-toggle="modal" onclick="gettypepiece('{{$typejointe->id}}','{{$typejointe->libelle}}');"  style="margin-left:10px;"  class="btn btn-md btn-success" > <i class="fas fa-plus"></i> </a>
                @endcan
                @endif
                </div>
              </div>

            @endforeach
            </div>
          </div>
          </div>
      </div>
      @endif
      <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Compte Utilisateur</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nom</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{getuser($usager->user_id)['nom']}}">
                </div>                
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Email</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{getuser($usager->user_id)['email']}}">
                </div>                
                <!-- /.form-group -->
              </div>      
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          
          <!-- /.card-body -->
          
        </div>
        <div class="card card-default">
          <div class="card-header">
            <h2 class="card-title btn btn-tool" data-card-widget="collapse">Entreprise</h2>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nom Commercial</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->commercial_name}}">
                  <input class="form-control save_demande" style="display:none" name="nom_commercial" type="text" value="{{$demandes->commercial_name}}">
                </div>
                <!-- /.form-group -->
                @if($demandes->company_type=="ES")
                <div class="form-group">
                  <label>Dénomination Sociale</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->denomination_social}}">
                  <input class="form-control save_demande" style="display:none" name="denomination_sociale" type="text" value="{{$demandes->denomination_social}}">                  
                </div>
                @endif
                <div class="form-group">
                  <label>Sigle</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->sigle}}">
                  <input class="form-control save_demande" style="display:none" name="sigle" type="text" value="{{$demandes->sigle}}">         
                </div>
                <div class="form-group">
                  <label>Enseigne</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->enseigne}}">
                  <input class="form-control save_demande"  style="display:none" name="enseigne" type="text" value="{{$demandes->enseigne}}">         
                </div>
                <div class="form-group">
                  <label>Chiffre d'affaire Prévisionnel</label>
                  <input class="form-control edit_demande" disabled="disabled" type="number" value="{{$demandes->chiffre_daffaire_previsionel}}">
                  <input class="form-control save_demande" style="display:none" name="chiffre_daffaire" type="number" value="{{$demandes->chiffre_daffaire_previsionel}}">     

                </div> 
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                
                <div class="form-group">
                  <label class="edit_demande">Forme Juridique</label>
                  <textarea class="form-control edit_demande" disabled="disabled" value="{{$forme_juridiques->libelle}}" rows="2" placeholder="{{$forme_juridiques->libelle}}"></textarea>
                    <div class="mb-3 save_demande" style="display:none;">
                      <label class="form-label" for="progress-basicpill-cstno-input">Forme Juridique</label>
                      @if($demandes->request_type=="P1")
                          <select id="forme_juridique_pp" name="forme_juridique_pp" data-placeholder="Choisir la forme juridique ..." class="form-control select" style="width: 100%;">
                               <option value="{{$forme_juridiques->code}}">{{$forme_juridiques->libelle}}</option>
                                    @foreach ($FJ_EI as $FJ_PP )
                               <option value="{{ $FJ_PP->code }}">{{ $FJ_PP->libelle }}</option>
                                    @endforeach
                          </select>
                      @endif
                      @if($demandes->request_type=="M1")
                          <select id="forme_juridique_pp" name="forme_juridique_es" data-placeholder="Choisir la forme juridique ..." class="form-control select" style="width: 100%;">
                               <option value="{{$forme_juridiques->code}}">{{$forme_juridiques->libelle}}</option>
                                    @foreach ($FJ_ES as $FJ_PM )
                               <option value="{{ $FJ_PM->code }}">{{ $FJ_PM->libelle }}</option>
                                    @endforeach
                          </select>
                      @endif
                      @if($demandes->request_type=="G1")
                          <select id="forme_juridique_pp" name="forme_juridique_gie" data-placeholder="Choisir la forme juridique ..." class="form-control select" style="width: 100%;">
                               <option value="{{$forme_juridiques->code}}">{{$forme_juridiques->libelle}}</option>
                                    @foreach ($FJ_GIE as $FJ_GI )
                               <option value="{{ $FJ_GI->code }}">{{ $FJ_GI->libelle }}</option>
                                    @endforeach
                          </select>
                      @endif
                    </div>    
                </div>
                <div class="form-group">
                  <label>Secteur d'activité</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->activity_sector}}">
                  <div class="mb-3 save_demande" style="display:none;">
                      <select id="secteur_activite" name="secteur_activite"  class="form-control select" data-placeholder="Choisir le secteur ..." style="width: 100%;" onchange="changeActivite('secteur_activite','activite_principale');" required>                                                                          
                          <option value="{{$demandes->activity_sector}}">{{$demandes->activity_sector}}</option>
                              @foreach ($activites_all as $activite )
                                <option value="{{ $activite->secteur_activite }}">{{ $activite->secteur_activite }}</option>
                            @endforeach
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label>Activité Principale</label>
                  <textarea class="form-control edit_demande" disabled="disabled" rows="2" placeholder="{{$activites->description}}"></textarea>
                  <div class="mb-3 save_demande" style="display:none;">
                      <!-- <label class="form-label" for="progress-basicpill-vatno-input">Activité Principale (<font color="red">*</font>)</label> -->
                           <select id="activite_principale" name="activite_principale" data-placeholder="Choisir l'activité ..." class="form-control select activite_principale" style="width: 100%;">
                               <option value="{{$activites->Code}}">{{$activites->description}}</option>                                                                            
                           </select>                                                                   
                  </div>
                </div>            
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Statut</label>
                  @if($demandes->paye==0)
                  <input class="form-control" disabled="disabled" type="text" value="Attente de Paiement">
                  @else                  
                  <input class="form-control" disabled="disabled" type="text" value="En traitement">
                  @endif      
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Date Création</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{ date("d-m-Y à H:i", strtotime($demandes->created_at)) }}">         
                </div>
                <div class="form-group">
                  <label>Objet Social</label>
                  <textarea class="form-control edit_demande" disabled="disabled" rows="6" value="{{$demandes->objet_social}}" placeholder="{{$demandes->objet_social}}"></textarea>
                  <textarea class="form-control save_demande" name="objet_social" style="display:none" rows="6">{{$demandes->objet_social}}</textarea>
                  <!-- <input class="form-control" disabled="disabled" type="text" value="{{$demandes->objet_social}}">                   -->
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
              <div class="col-md-4">
                
                <div class="form-group">
                  <label>Région</label>
                  <input class="form-control" disabled="disabled" type="textarea" value="{{$regions->name}}">                    
                </div>
                <div class="form-group">
                  <label>Province</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$provinces->name}}">                  
                </div>
                <div class="form-group">
                  <label>Commune</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$communes->name}}">         
                </div>
                <div class="form-group">
                  <label>Arrondissement</label>
                  <input class="form-control" disabled="disabled" type="text" value="Test">         
                </div>
                <div class="form-group">
                  <label>Secteur/Village</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$secteurs->name}}">         
                </div> 
                               
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">      
                <div class="form-group">
                  <input type="hidden" name="id_terrain" value="{{$demandes->id_terrain}}">
                  <label>Lot</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$terrains->numero_lot}}">
                  <input class="form-control save_demande" name="lot" style="display:none;" type="text" value="{{$terrains->numero_lot}}">                  
                </div>
                <div class="form-group">
                  <label>Section</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$terrains->numero_section}}">
                  <input class="form-control save_demande" name="section" style="display:none;" type="text" value="{{$terrains->numero_section}}">                  
                </div>
                <div class="form-group">
                  <label>Parcelle</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$terrains->numero_parcelle}}">
                  <input class="form-control save_demande" name="parcelle" style="display:none;" type="text" value="{{$terrains->numero_parcelle}}">                  
                </div> 
                <div class="form-group">
                  <label>Usage Terrain</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$terrains->id_usage_terrain}}">
                    <div class="col-md-3 save_demande" style="display:none;">                     
                               <select id="usage" name="usage" data-placeholder="Choisir l'usage" class="form-control select" style="width: 100%;" required>
                                     <option value="{{$terrains->id_usage_terrain}}">{{$terrains->id_usage_terrain}}</option>
                                          @foreach ($usage_terrains as $usage_terrain )
                                     <option value="{{ $usage_terrain->Code }}">{{ $usage_terrain->Libelle }}</option>
                                          @endforeach
                               </select>  
                      </div>         
                </div>                    
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              @if($demandes->company_type=="ES")
              <div class="col-md-4"> 
              
                <div class="form-group">
                  <label>Capital Social</label>
                  <input class="form-control" disabled="disabled" type="textarea" value="{{$demandes->capital_social}}">         
                </div> 
                <div class="form-group">
                  <label>Dont en numéraire</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->capital_en_numeraire}}">         
                </div>
                <div class="form-group">
                  <label>Dont en nature</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->capital_en_nature}}">         
                </div>
                <div class="form-group">
                  <label>Montant par action</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->montant_action}}">         
                </div>
                <div class="form-group">
                  <label>Nombre d'action</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->nbre_actions}}">         
                </div>

              </div>
              @endif 
                         
              <!-- /.col -->
            </div>         <br>   
            @if($demandes->paye==1 && $demandes->etat==2)                      
          <center>
            <a  style="margin-left:10px;" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration edit_demande" onclick="editdemande()" > <i class="fas fa-pen"></i> Corriger Entreprise </a>
            <button type="submit" style="margin-left:10px;display:none" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success save_demande" > <i class="fas fa-pen"></i> Enregistrer </button>
            <!-- <a  style="margin-left:10px;" id="declaration_edit"  data-toggle="modal" style="display:none" class="btn btn-md btn-danger declaration save_demande" onclick="editdemande()" > <i class="fa fa-window-close"></i> Annuler </a> -->
          </center>
          @endif
            <!-- /.row -->
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         
        </div>
        <!-- /.card -->
</form>
    
        <form action="{{ route('usager.update',$usager->id)}}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Dirigeant</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nom</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager->NomRaisonSociale}}">
                  <input class="form-control save_usager" style="display:none" name="nom" type="text" value="{{$usager->NomRaisonSociale}}">
                </div>
                <div class="form-group">
                  <label>Prénom</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager->Prenom}}">
                  <input class="form-control save_usager" style="display:none" name="prenom" type="text" value="{{$usager->Prenom}}">
                </div>
                <div class="form-group">
                  <label>Genre</label>
                  <input class="form-control" disabled="disabled" type="text" value="@if($usager->Gender==1) Féminin @else Masculin @endif">                                     
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Date de naissance</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager->DateNaissance}}">
                  <input type="text" name="date_de_naissance" style="display:none" value="{{format_date($usager->DateNaissance)}}" class="form-control date_nais_usager save_usager" placeholder="{{$usager->DateNaissance}}"
                        data-date-format="dd-mm-yyyy">                 
                </div>
                <div class="form-group">
                  <label>Lieu de naissance</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager->LieuNaissance}}">
                  <input class="form-control save_usager" style="display:none" name="lieu_naissance" type="text" value="{{$usager->LieuNaissance}}">
                </div>
                <div class="form-group">
                  <label>Téléphone mobile</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager->Phone_No_}}">
                  <input class="form-control save_usager" style="display:none" name="tel_mobile" type="text" value="{{$usager->Phone_No_}}">                      
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Téléphone bureau</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager->Tel_Bureau}}">
                  <input class="form-control save_usager" style="display:none" name="tel_bureau" type="text" value="{{$usager->Tel_Bureau}}">
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Civilité</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="@if($usager->Civility=='M.')Monsieur @elseif($usager->Civility=='MME')Madame @else Mademoiselle @endif">
                  <div class="mb-3 save_usager" style="display:none;">
                      <select id="single-select-field" name="civilite" class="form-control select2"  data-placeholder="Selectionnez votre civilité" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                             <option value="{{$usager->Civility}}">@if($usager->Civility=='M.')Monsieur @elseif($usager->Civility=='MME')Madame @else Mademoiselle @endif</option>
                                  @foreach ($civilites as $civilite )
                             <option value="{{ $civilite->code }}">{{ $civilite->libelle }}</option>
                                  @endforeach
                      </select>
                  </div>  
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Situation matrimoniale</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="@if($usager->SituationMatrimoniale==1) Célibataire @elseif($usager->SituationMatrimoniale==2) Marié @else Divorcé @endif">
                  <div class="mb-3 save_usager" style="display:none;">                    
                       <select id="situation_matrimoniale" name="situation_matrimoniale" class="form-control select2" data-placeholder="Choisir votre situation matrimoniale" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire" onchange="afficher_conjoint();">
                            <option value="{{$usager->SituationMatrimoniale}}">@if($usager->SituationMatrimoniale==1) Célibataire @elseif($usager->SituationMatrimoniale==2) Marié @else Divorcé @endif</option>
                            <option value="1" {{ old('situation_matrimoniale') == 1 ? 'selected' : '' }}>Celibataire</option>
                            <option value="2" {{ old('situation_matrimoniale') == 2 ? 'selected' : '' }}>Marié</option>
                            <option value="3" {{ old('situation_matrimoniale') == 3 ? 'selected' : '' }}>Divorcé</option>
                        </select>                                             
                   </div>         
                </div>
                <div class="form-group">
                  <label>Profession</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{getfonction($usager->IdFonction)}}">
                    <div class="mb-3 save_usager" style="display:none;">                     
                          <select id="profession" name="profession" data-placeholder="Choisir votre profession ..." class="form-control select2" style="width: 100%;">
                              <option value="{{$usager->IdFonction}}">{{getfonction($usager->IdFonction)}}</option>
                                   @foreach ($professions as $profession )
                              <option value="{{ $profession->code }}">{{ $profession->libelle }}</option>
                                   @endforeach                                                                  
                          </select>                                                                   
                     </div>
                </div>
                <div class="form-group">
                  <label>Pays</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{getpays($usager->Country_Code)}}">
                  <div class="mb-3 save_usager" style="display:none">
                     <select id="code_pays" name="pays_usager" data-placeholder="Choisir le pays de residence" class="form-control select2" style="width: 100%;">
                          <option value="{{$usager->Country_Code}}">{{getpays($usager->Country_Code)}}</option>
                              @foreach ($pays as $pay )
                          <option value="{{ $pay->code }}">{{ $pay->libelle }}</option>
                              @endforeach                                
                      </select>
                   </div>       
                </div>                
                <div class="form-group">
                  <label>Nationalité</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{getpays($usager->Nationality_No_)}}">
                  <div class="mb-3 save_usager" style="display:none;">                           
                      <select id="code" name="nationalite_usager" data-placeholder="Choisir votre Nationalité" class="form-control select2" style="width: 100%;" >
                           <option value="{{$usager->Nationality_No_}}">{{getpays($usager->Nationality_No_)}}</option>
                                   @foreach ($nationalites as $nationalite )
                           <option value="{{ $nationalite->code }}">{{ $nationalite->libelle }}</option>
                                   @endforeach                                 
                      </select>
                  </div>         
                </div>                   
                <div class="form-group">
                  <label>Boite Postale</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager->Boite_postale}}">
                  <input class="form-control save_usager" style="display:none" name="boite_postale" type="text" value="{{$usager->Boite_postale}}">
                </div>  
                <div class="form-group">
                  <label>E-mail</label>
                  <input class="form-control edit_usager" disabled="disabled" type="text" value="{{$usager['E-Mail']}}">
                  <input class="form-control save_usager" style="display:none" name="mail" type="text" value="{{$usager['E-Mail']}}">
                </div>          
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">                
                <div class="form-group">
                  <label>Région</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$regions->name}}">
                  <div class="mb-3" style="display:none;">                       
                            <select id="region_usager" name="region_usager" data-placeholder="{{$regions->name}}" value="{{old("region_usager")}}" class="form-control select2" style="width: 100%;"  onchange="changeValue('region_usager', 'province_usager', 'provinces','region_usager');">
                                 <option value="{{$regions->id}}">{{$regions->name}}</option>
                                    @foreach ($regions_all as $region )
                                 <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach                                                                         
                            </select>                                                
                    </div>         
                </div>
                <div class="form-group">
                  <label>Province</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$provinces->name}}">
                  <div class="mb-3" style="display:none;">                  
                      <select id="province_usager" name="province_usager" data-placeholder="{{$provinces->name}}" class="form-control select2" style="width: 100%;"   onchange="changeValue('province_usager', 'commune_usager', 'communes','region_usager');">
                            <option value="{{$provinces->id}}">{{$provinces->name}}</option>                                                                   
                      </select>
                  </div>                
                </div>
                <div class="form-group">
                  <label>Commune</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$communes->name}}">         
                </div>
                <div class="form-group">
                  <label>Arrondissement</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->Civility}}">         
                </div>
                <div class="form-group">
                  <label>Secteur/Village</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$secteurs->name}}">         
                </div>
                <div class="form-group">
                  <label>Site Web</label>
                  <input class="form-control" disabled="disabled" type="text" value="test">         
                </div>
                <!-- /.form-group -->
                
                <!-- /.form-group -->
              </div>       
              <!-- /.col -->
            </div>
            @if($demandes->paye==1 && $demandes->etat==2)                      
          <center><a  style="margin-left:10px; color:black;" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration edit_usager" onclick="editusager()" > <i class="fas fa-pen"></i> Corriger Dirigeant</a>
            <button type="submit" style="margin-left:10px;display:none" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success save_usager" > <i class="fas fa-pen"></i> Enregistrer </button>
            <!-- <a  style="margin-left:10px;" id="declaration_edit"  data-toggle="modal" style="display:none;" class="btn btn-md btn-danger save_usager" onclick="editusager()" > <i class="fa fa-window-close"></i> Annuler </a> -->
          </center>
          @endif
            <!-- /.row -->
          </div>
          
          <!-- /.card-body -->
          
        </div>
  </form>

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Pièces Jointes</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
            @foreach($piecejointes as $piecejointe)
              <div class="col-md-3" style="padding:5px;">
                <div class="input-group">
                <!-- <label>Nom Pièce</label> -->
                <input class="form-control"  disabled="disabled" type="text" value="{{$piecejointe->type_piece}}">
                <a href="{{ route('edit.pj',$piecejointe) }}" style="margin-left:10px;"  class="btn btn-md btn-success declaration" > <i class="fas fa-pen"></i> </a>
                <!-- <a href="{{ route('show.pj',$piecejointe) }}" style="margin-left:10px;" target="_blank"   class="btn btn-md btn-success "> <i class="fas fa-eye"></i> </a> -->
                <a  style="margin-left:10px;" href="#piece{{$piecejointe->id}}" data-toggle="modal" data-dismiss="modal" id="declaration_edit"  class="btn btn-md btn-success declaration" > <i class="fas fa-eye"></i> </a>
                
                <!-- <a href="{{ route('detaildocument',$piecejointe->id)}}"title="Visualiser le document" class="btn btn-xs btn-default" ><i class="fa fa-eye"></i> </a> -->
                  <!-- <label>Nom et Prénom</label>
                  <input class="form-control" disabled="disabled" type="text" value="Test"> -->
                </div>
                <!-- /.form-group -->
                <!-- <div class="form-group">
                  <label>Date de naissance</label>
                  <input class="form-control" disabled="disabled" type="text" value="Test">                  
                </div> -->
                <!-- /.form-group -->
              </div>
              <div class="modal fade modal-front" id="piece{{$piecejointe->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        
                        <div class="modal-header">
                
                        <center><h3 class="modal-title text-center" id="modal-login-label"> Visualisation du document</h3></center>

                          <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                        </div>
                        
                        <div class="modal-body">    
                          <!-- <p>{{$piecejointe->url}}</p>   -->
                            <!-- <embed src= "{{ asset('storage/files/1202/casier_judiciaire.pdf') }}" height=600 type='application/pdf' style="width: 100%;" /> -->
                            <iframe id="#" src="{{ Storage::url($piecejointe->url) }}" width="100%" height="550px" style="border: none;"></iframe>  
                                            
                        </div>
                        
                      </div>
                    </div>
              </div>
            @endforeach
              <!-- /.col -->
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          
          <!-- /.card-body -->
          
        </div>
        <!-- /.card -->

      
        <!-- /.card -->

      
        <!-- /.row -->
       
        <!-- /.row -->
     
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade modal-front" id="modal-add-piece" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <center><h3 class="modal-title text-center" id="modal-login-label"> Ajouter la formalité <span class="p_typepiece"></span></h3></center>
        </div>
        <div class="modal-body">
          <div class="row">
        <form method="POST" action="{{ route('add_formalite_retour') }}"  enctype="multipart/form-data">
                @csrf
                  
                    <input id="typepiece" type="hidden" class="form-control" name="typepiece">
                    <input id="demande" type="hidden" class="form-control" name="demande" value="{{$demandes->id}}">
                    <label for="">Joindre une copie de la formalite:</label>
                    <input class="" type="file" name="copie_de_la_formalite" accept=".pdf, .jpeg, .png" required placeholder="Joindre une copie de la formalite">
                    <center><a class="btn btn-md btn-danger" data-dismiss="modal">Fermer</a>
                      <input type="submit" class="btn btn-md btn-success" value="Valider"></center>
                </form>
         
        </div>
             
        </div>
        
      </div>
    </div>
</div>
<div class="modal fade modal-front" id="modal-update-piece" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <center><h3 class="modal-title text-center" id="modal-login-label"> Modifier la formalité <span class="p_typepiece_u"></span></h3></center>
        </div>
        <div class="modal-body">
          <div class="row">
        <form method="POST" action="{{ route('update_formalite_retour') }}"  enctype="multipart/form-data">
                @csrf
                    <input id="typepiece_u" type="hidden" class="form-control" name="typepiece">
                    <input id="demande" type="hidden" class="form-control" name="demande" value="{{$demandes->id}}">
                    <label for="">Joindre une copie de la formalite:</label>
                    <input class="" type="file" name="copie_de_la_formalite" accept=".pdf, .jpeg, .png" required placeholder="Joindre une copie de la formalite">
                    <center>
                    <a class="btn btn-md btn-danger" data-dismiss="modal">Fermer</a>
                      <input type="submit" class="btn btn-md btn-success" value="Valider"></center>
                </form>    
                
        </div>
             
        </div>
        
      </div>
    </div>
</div>
  <div class="modal fade modal-front" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        
        <div class="modal-header">
 
        <center><h3 class="modal-title text-center" id="modal-login-label"> Confirmation</h3></center>

          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                <a href="{{ route('valider.demande', $demandes->id) }}?etat=oui" class="btn btn-success"> Oui</a>
                <a href="{{ route('valider.demande', $demandes->id) }}?etat=non" class="btn btn-danger"> Non</a>
               
              </div>
          </div>
          
                
        </div>
        
      </div>
    </div>
</div>
<div class="modal fade modal-front" id="modal-confirm-rejet" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        
        <div class="modal-header">
 
        <center><h3 class="modal-title text-center" id="modal-login-label"> Confirmation du Rejet</h3></center>

          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                <form action="{{ route('valider.demande', $demandes->id) }}">
                @csrf
                    <label for="">Motif</label>
                    <textarea name="motif" id="" class="form-control" placeholder="Saisir le motif du rejet" cols="20" rows="5"></textarea><br>
                    <center><input type="submit" class="btn btn-md btn-success" value="Valider"></center>
                </form>                
              </div>
          </div>                
        </div>
        
      </div>
    </div>
</div>

<script>
  function gettypepiece(id,libelle)
      {
    
        $('#typepiece').val(id);
        $('.p_typepiece').text(libelle);
      }
      function  gettypepiece_update(id,libelle)
      {
        $('#typepiece_u').val(id);
        $('.p_typepiece_u').text(libelle);
      }
     
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

@endsection