@extends('layouts.frontend')
@section('content')
<div class="container" style="margin-top:-30px">
    <!-- <div class="row choix_type_usager">
        <fieldset>
            <legend>Choisir le type d'usager:</legend>
            <div>
              <input style="margin-left: 30px"
                type="radio" 
                id="personne_physique" 
                name="type_usage"
                value="email"
                checked />
              <label for="contactChoice1">Personne Physique</label>
              <input style="margin-left: 50px" type="radio" id="personne_morale" name="type_usage" value="phone" />
              <label for="contactChoice2">Personne Morale</label>
            </div>
          </fieldset>
    </div> -->

    <center><div class="alert-warning">
        <p>Les champs en étoile rouge <span style="color: red">(*)</span> sont obligatoires</p>
    </div></center>
    <center> <h3 class="font-size-14 mb-4">Enregistrement du Promoteur</h3></center>

<div class="content-form" >
    <form id='form_usager_personne_physique' role="form" action="{{ route('store.usager') }}" enctype="multipart/form-data" method="post" class="form-horizontal form-bordered">
            @csrf             
        <div class="row">
           
                            <div class="col-md-12" style="margin-left:10px;"><br>
                                                <fieldset style="width:100%">
                                                        <legend><span class="legend-fieldest">Identification</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">                                                                    
                                                                    <label class="form-label" for="nom_usager">Nom (<font color="red">*</font>)</label>
                                                                        <input type="text" id="nom" name="nom_usager" class="form-control" style="width: 100%;" value="{{old('nom')}}" onchange="this.value = this.value.toUpperCase()" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
                                                                            @if ($errors->has('nom'))
                                                                                    <span class="help-block">
                                                                                        <strong>{{ $errors->first('nom_usager') }}</strong>
                                                                                    </span>
                                                                            @endif
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="val_username">Prénom (s) (<font color="red">*</font>)</label>
                                                                        <input type="text" id="prenom" name="prenom_usager" class="form-control" value="{{old('prenom')}}"placeholder="Entrez votre prenom.." required="Ce champ est obligatoire" onchange="this.value = this.value.charAt(0).toUpperCase()+ this.value.substr(1);">
                                                                    <!-- <input type="text" name="prenom_usager" class="form-control" id="progress-basicpill-vatno-input" > -->
                                                                </div>
                                                                <div class="mb-3" id="">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Date de naissance (<font color="red">*</font>)</label>
                                                                    <input type="text" name="date_de_naissance" value="{{old('date_de_formalisation')}}" required class="form-control date_nais_usager" placeholder="dd-mm-yyyy"
                                                                        data-date-format="dd-mm-yyyy">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="val_username">Lieu de naissance (<font color="red">*</font>)</label>
                                                                        <input type="text" id="" name="lieu_de_naissance" class="form-control"  placeholder="votre lieu de naissance .." value="{{old('lieu_de_naissance')}}" required>
                                                                            @if ($errors->has('lieu_de_naissance'))
                                                                                <span class="help-block text-center">
                                                                                    <strong> {{ $errors->first('lieu_de_naissance') }}</strong>
                                                                                </span>
                                                                            @endif                                        
                                                                </div>
                                                            </div>                                                            
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="val_username">Civilité (<font color="red">*</font>)</label>
                                                                    <select id="single-select-field" name="civilite" class="form-control select2"  data-placeholder="Selectionnez votre civilité" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                                                    <option></option>
                                                                    @foreach ($civilites as $civilite )
                                                                            <option value="{{ $civilite->code }}">{{ $civilite->libelle }}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="val_username">Profession (<font color="red">*</font>)</label>
                                                                    <select id="profession" name="profession" data-placeholder="Choisir votre profession ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            @foreach ($professions as $profession )
                                                                                <option value="{{ $profession->code }}">{{ $profession->libelle }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>                                                                   
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="val_username">N° Pièce d'identitié (<font color="red">*</font>)</label>
                                                                    <input type="text" id="" name="numero_piece" class="form-control"  placeholder="Numéro NIP de la CNIB ou N°Passport .." value="{{old('numero_piece')}}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="val_username">Situation matrimoniale (<font color="red">*</font>)</label>
                                                                        <select id="situation_matrimoniale" name="situation_matrimoniale" class="form-control select2" data-placeholder="Choisir votre situation matrimoniale" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire" onchange="afficher_conjoint();">
                                                                            <option></option>
                                                                            <option value="1" {{ old('situation_matrimoniale') == 1 ? 'selected' : '' }}>Celibataire</option>
                                                                            <option value="2" {{ old('situation_matrimoniale') == 2 ? 'selected' : '' }}>Marié</option>
                                                                            <option value="3" {{ old('situation_matrimoniale') == 3 ? 'selected' : '' }}>Divorcé</option>
                                                                        </select>
                                                                   
                                                                </div>
                                                            </div>           
                                                                                   
                                                        </div>
                                                     </fieldset> <br><br>
                                                <div class="usager" style="display:none">
                                                <fieldset style="width:100%" class="conjoint">
                                                        <legend><span class="legend-fieldest">Conjoints (s)</span></legend>
                                                        <div class="row field_wrapper2">
                                                            <div class="col-md-9  ">
                                                                <div class="mb-3">
                                                                    <select id="conjoints"  name="conjoints[]" data-placeholder="Selectionner votre conjoint ..." class="form-control select2 conjoints" style="width: 100%;" required >
                                                                        <option></option>
                                                                            @foreach ($all_usagers as $all_usager )
                                                                                <option value="{{ $all_usager->id }}">{{ $all_usager->CIN }} - {{ $all_usager->NomRaisonSociale }} {{ $all_usager->Prenom }} - {{ $all_usager->Phone_No_ }}</option>
                                                                            @endforeach                                                                  
                                                                    </select>
                                                                </div>
                                                                                                                
                                                            </div>
                                                            
                                                            <div class="col-lg-2">
                                                                <div class="mb-"> 
                                                                    <a href="javascript:void(0);"  class="btn btn-md btn-success add_button2"> <i class="fas fa-plus"></i> </a>
                                                                </div>
                                                                <a href="#addusager" style="margin-left: 45px; margin-top:-34px;" id="addusager" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" > Créé Conjoint </a>

                                                            </div> 
                                                                                                 
                                                        </div>
                                                        <div class="row mb-3">
                                                                <div class="col-md-5">
                                                                    <label class=" control-label" for="example-chosen">Regime Matrimonial (<font color="red">*</font>)</label>
                                                                    <select id="regime_matrimonial"  name="regime_matrimonial" data-placeholder="Selectionner le conjoint ..." class="form-control select2 conjoints" style="width: 100%;" required >
                                                                        <option></option>
                                                                                <option value="1">Monogamie Communauté universelle</option>
                                                                                <option value="2">Polygamie Séparation de biens</option>
                                                                                <option value="3">Monogamie Séparation de biens</option>
                                                                                <option value="4">Monogamie Biens Communs</option>
                                                                                                                                          
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-5" id="datepicker3">
                                                                    <label class=" control-label" for="example-chosen">Date Mariage (<font color="red">*</font>)</label>
                                                                    <input type="text" name="date_mariage" value="{{old('date_mariage')}}" class="form-control date_mariage" placeholder="dd-mm-yyyy"
                                                                    data-date-format="dd-mm-yyyy" data-date-container='#datepicker3' data-provide="datepicker">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class=" control-label" for="example-chosen">Lieu de Mariage (<font color="red">*</font>)</label>
                                                                    <input type="text" name="lieu_mariage" class="form-control" placeholder="Lieu de Mariage" id="">
                                                                </div>
                                                                <div class="col-md-5 mariage" style="display:none">
                                                                <label class=" control-label" for="example-chosen">Joindre l'acte de mariage (<font color="red">*</font>)</label>
                                                                <input class="form-control input_file" type="file" id='piece_jointe_1' name="piece_jointe_m" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de la pièce" required  onchange="VerifyUploadSizeIsOK('piece_jointe_1');" >  
                                                                    
                                                                </div> 
                                                            </div>
                                                        
                                                     </fieldset> <br><br>
                                            </div>

                                                     <fieldset style="width:100%">
                                                        <legend><span class="legend-fieldest">Adresse</span></legend>
                                                        <div class="row">
                                                        
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">                                                                    
                                                                <label class=" control-label" for="example-chosen">Nationalité (<font color="red">*</font>)</label>
                                                                <select id="code" name="nationalite_usager" data-placeholder="Choisir votre Nationalité" class="form-control select2" onchange="afficherPj();" style="width: 100%;" required >
                                                                    <option></option>
                                                                        @foreach ($nationalites as $nationalite )
                                                                            <option value="{{ $nationalite->code }}">{{ $nationalite->libelle }}</option>
                                                                        @endforeach
                                                                    
                                                                </select>
                                                                </div>
                                                                <div class="mb-3 commerce" style="display:none">
                                                                <label class=" control-label" for="example-chosen">Joindre l'autorisation d'exercer le commerce (<font color="red">*</font>)</label>
                                                                <input class="form-control input_file" type="file" id='piece_jointe_1' name="piece_jointe_c" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de la pièce" required  onchange="VerifyUploadSizeIsOK('piece_jointe_1');" >  
                                                                    
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">                                                                    
                                                                <label class=" control-label" for="example-chosen">Pays de residence (<font color="red">*</font>)</label>
                                                                <select id="code_pays" name="pays_usager" data-placeholder="Choisir le pays de residence" class="form-control select2" style="width: 100%;" required onchange="afficherDecoupage();">
                                                                    <option></option>
                                                                        @foreach ($pays as $pay )
                                                                            <option value="{{ $pay->code }}">{{ $pay->libelle }}</option>
                                                                        @endforeach
                                                                    
                                                                </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-lg-6">
                                                                <div class="mb-3 decoupage_administratif" >
                                                                    <label class=" control-label" for="example-chosen">Region (<font color="red">*</font>)</label>
                                                                        <select id="region_usager" name="region_usager" data-placeholder="Choisir région" class="form-control select2" style="width: 100%;" required onchange="changeValue('region_usager', 'province_usager', 'provinces','region_usager');" required>
                                                                            <option></option>
                                                                                @foreach ($regions as $region )
                                                                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                                                @endforeach                                                                      
                                                                        </select>
                                                                </div>
                                                                <div class="mb-3 decoupage_administratif">
                                                                    <label class=" control-label" for="example-chosen">Province (<font color="red">*</font>)</label>
                                                                    <select id="province_usager" name="province_usager" data-placeholder="Choisir province" class="form-control select2" style="width: 100%;" required  onchange="changeValue('province_usager', 'commune_usager', 'communes','region_usager');" required>
                                                                            <option></option>                                                          </select>
                                                                </div>
                                                                <div class="mb-3 decoupage_administratif">
                                                                    <label class=" control-label" for="example-chosen">Commune (<font color="red">*</font>)</label>
                                                                    <select id="commune_usager" name="commune_usager" data-placeholder="Choisir commune" class="form-control select2" style="width: 100%;" required  onchange="changeValue('commune_usager', 'arrondissement_usager', 'arrondissements','province_usager');" required>
                                                                            <option></option>
                                                                        </select>
                                                                </div>
                                                                <div class="mb-3 decoupage_administratif">
                                                                    <label class=" control-label" for="example-chosen">Arrondissement </label>
                                                                        <select id="arrondissement_usager" name="type_identite_promoteur" data-placeholder="Choisir arrondissement" class="form-control select2" style="width: 100%;" required onchange="changeValue('arrondissement_usager', 'secteur_usager', 'secteur_villages','commune_usager');" required>
                                                                            <option></option>
                                                                            <option> -- Selectionner --</option>
                                                                        </select>
                                                                </div>
                                                                <div class="mb-3 decoupage_administratif">
                                                                    <label class=" control-label" for="example-chosen"> Secteur/Village (<font color="red">*</font>)</label>
                                                                        <select id="secteur_usager" name="secteur_usager" data-placeholder="Choisir secteur/village" class="form-control select2" style="width: 100%;" required>
                                                                            <option></option>
                                                                            <option> -- Selectionner --</option>
                                                                        </select>                                                                    
                                                                </div>
                                                            </div>   
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class=" control-label" for="">Boite Postale (<font color="red">*</font>)</label>                        
                                                                        <input type="text" id="boite_postale" name="boite_postale" value="{{old('boite_postale')}}" class="form-control" placeholder="Boite Postale" required>    
                                                                        @if ($errors->has('boite_postale'))
                                                                            <span class="help-block text-danger">
                                                                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                                                            </span>
                                                                        @endif                           
                                                                </div>
                                                                <div class="mb-3 decoupage_administratif">
                                                                    <label class=" control-label" for="">Téléphone Mobile (<font color="red">*</font>)</label>
                                                                        <input type="text" id="telephone_mobile1" name="telephone_mobile1" value="{{old('telephone_mobile1')}}" class="form-control" placeholder="numéro.." required>
                                                                        @if ($errors->has('telephone_mobile1'))
                                                                            <span class="help-block text-danger">
                                                                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                                                            </span>
                                                                        @endif
                                                                </div>
                                                                <div class="mb-3 ">
                                                                    <label class=" control-label" for="">Téléphone Bureau </label>
                                                                        <input type="text" id="telephone_bureau" name="telephone_bureau" value="{{old('telephone_bureau')}}" class="form-control" placeholder="numéro..">
                                                                        @if ($errors->has('telephone_bureau'))
                                                                            <span class="help-block text-danger">
                                                                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                                                            </span>
                                                                        @endif
                                                                </div>
                                                                <div class="mb-3 ">
                                                                    <label class=" control-label" for="">E-mail (<font color="red">*</font>)</label>
                                                                        <input type="text" id="telephone_bureau" name="email_usager" value="{{old('email_usager')}}" class="form-control" placeholder="exemple@gmail.com" required>
                                                                        @if ($errors->has('telephone_bureau'))
                                                                            <span class="help-block text-danger">
                                                                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                                                            </span>
                                                                        @endif
                                                                </div>
                                                            </div>
                                                             <div class="col-lg-6">
                                                                <div class="mb-3" >
                                                                    <label class=" control-label" for="">Adresse (<font color="red">*</font>)</label>
                                                                        <input type="text" id="adresse" name="adresse" value="{{old('adresse')}}" class="form-control" placeholder="adresse.." required>
                                                                        @if ($errors->has('adresse'))
                                                                            <span class="help-block text-danger">
                                                                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                                                            </span>
                                                                        @endif
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                
                                                            </div> 
                                                            
                                                            <div class="col-lg-6">
                                                                
                                                            </div>
                                                            <!-- <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class=" control-label" for="">Telephone Mobile 2 </label>
                                                                        <input type="text" id="telephone_mobile2" name="telephone_mobile2" value="{{old('telephone_mobile2')}}" class="form-control" placeholder="numéro.." required>
                                                                        @if ($errors->has('telephone_mobile_2'))
                                                                            <span class="help-block text-danger">
                                                                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                                                            </span>
                                                                        @endif
                                                                </div>
                                                            </div>   -->
                                                            
                                                            <div class="col-lg-6">
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <!-- <div class="mb-3">
                                                                    <label class="form-label" for="val_username">Prénom</label>
                                                                    
                                                                </div> -->
                                                            </div>                              
                                                        </div>
                                                     </fieldset> <br>  
                                                     <div class="panel-footer text-center">
                        <input type="reset" class="btn btn-md btn-danger"  value="Annuler">
                        <a href="#modal-confirm" data-toggle="modal" data-dismiss="modal"  class="btn btn-md btn-success"  value="Enregister mes données">Valider</a>
            </div>     
            </div>
        </div>
    </div>

    
            
</form>
    


        <form id='form_usager_personne_morale' role="form" action="{{ route('store.usager') }}" method="post" class="form-horizontal form-bordered" style="display: none">
            @csrf
    <div class="block-style">
                <div class="panel-heading">
                    <p> Informations sur la personne morale </legend>
                </div> 
                <div class="row">
           
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label" for="nom_usager">Nom Raison Sociale <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" id="nom" name="nom_usagedr" class="form-control" style="width: 100%;" value="{{old('nom')}}" onchange="this.value = this.value.toUpperCase()" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
                                @if ($errors->has('nom'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nom_usager') }}</strong>
                                        </span>
                                @endif
                            </div>
                    </div>
               
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="val_username">Numéro IFU (s) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="numero_ifu" name="numero_ifu" class="form-control" value="{{old('numero_ifu')}}"placeholder="Entrez le numéro IFU.." required="Ce champ est obligatoire" onchange="this.value = this.value.charAt(0).toUpperCase()+ this.value.substr(1);">
                                </div>
                        </div>
                  
                    </div>
                
                </div>
    </div> 
        <div class="panel-footer text-center">
            <input type="reset" class="btn btn-sm btn-warning"  value="Annuler">
            <input type="reset" class="btn btn-sm btn-warning"  value="Annuler">
            <!-- <button type="submit"   class="btn btn-sm btn-success"  value="Enregister mes données"></button> -->
        </div>
    
    </div>     
</div>     
@endsection
@section('modal_parpage')
<div class="modal fade modal-front" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        
        <div class="modal-header">
 
        <center><h3 class="modal-title text-center" id="modal-login-label">  Confirmer les données correctes <i class="fa fa-key"></i></h3></center>

          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler <i class="fa fa-unlock"></i></button>
                <button type="button" class="btn btn-success" onclick="soumettre('form_usager_personne_physique')" >Valider </i></button>
              </div>
          </div>
          
                
        </div>
        
      </div>
    </div>
  </div>
@endsection
<div id='addusager'class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Enregistrer un usager</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formusager" action="javascript:void(0)" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
            <div class="row">
                <fieldset style="width:100%">
                    <legend><span class="legend-fieldest">Identification</span></legend>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">                                                                    
                                <label class="form-label" for="nom_usager">Nom</label>
                                    <input type="text" id="nom" name="nom_usager" class="form-control" style="width: 100%;" value="{{old('nom')}}" onchange="this.value = this.value.toUpperCase()" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
                                        @if ($errors->has('nom'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('nom_usager') }}</strong>
                                                </span>
                                        @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                            <label class="form-label" for="example-chosen" >Genre</label>
                            <select id="genre" name="genre_usager" class="form-control" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire" required>
                                    <option></option>
                                    <option value="1" {{ old('genre') == 1 ? 'selected' : '' }}>Féminin</option>
                                    <option value="2" {{ old('genre') == 2 ? 'selected' : '' }}>Masculin</option>
                                </select>    
                            <!-- <input type="text" name="prenom_usager" class="form-control" id="progress-basicpill-vatno-input" >                                                                    -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="val_username">Prénom (s)</label>
                                    <input type="text" id="prenom" name="prenom_usager" class="form-control" value="{{old('prenom')}}"placeholder="Entrez le prenom.." required="Ce champ est obligatoire" onchange="this.value = this.value.charAt(0).toUpperCase()+ this.value.substr(1);">
                            </div>
                        </div>   
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="val_username">Civilité</label>
                                <select id="single-select-field" name="civilite" class="form-control select2"  data-placeholder="Selectionnez la civilité" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                <option></option>
                                    @foreach ($civilites as $civilite )
                                           <option value="{{ $civilite->code }}">{{ $civilite->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="val_username">Date de naissance</label>
                                <input type="text" name="date_de_naissance" value="{{old('date_de_naissance')}}" required class="form-control date_nais_usager" placeholder="dd-mm-yyyy"
                                data-date-format="dd-mm-yyyy">
                            </div>
                        </div>  
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="val_username">Lieu de naissance</label>
                                <input type="text" id="lieu_de_naissance" name="lieu_de_naissance" class="form-control" value="{{old('lieu_de_naissance')}}"placeholder="Entrez le lieu de naissance .." required="Ce champ est obligatoire">
                            </div>
                        </div> 
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="val_username">N° Pièce d'identitié (<font color="red">*</font>)</label>
                            <input type="text" id="" name="numero_piece" class="form-control"  placeholder="Numéro NIP de la CNIB ou N°Passport .." value="{{old('numero_piece')}}" required>
                        </div>
                    </div>
                    </div>
                 </fieldset> <br><br><br>  
                 <fieldset style="width:100%;  margin-top:30px;">
                    <legend><span class="legend-fieldest">Adresse</span></legend>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">                                                                    
                            <label class=" control-label" for="example-chosen">Nationalité (<font color="red">*</font>)</label>
                            <select name="nationalite_usager" id="n2" data-placeholder="Choisir" class="form-control " style="width: 100%;" required >
                                <option></option>
                                    @foreach ($nationalites as $nationalite )
                                        <option value="{{ $nationalite->code }}">{{ $nationalite->libelle }}</option>
                                    @endforeach
                                
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">                                                                    
                            <label class=" control-label" for="example-chosen">Pays de residence (<font color="red">*</font>)</label>
                            <select  name="pays_usager" data-placeholder="Choisir" class="form-control" style="width: 100%;" required onchange="afficherDecoupage();" >
                                <option></option>
                                    @foreach ($pays as $pay )
                                        <option value="{{ $pay->code }}">{{ $pay->libelle }}</option>
                                    @endforeach
                                
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class=" control-label" for="">Adresse (<font color="red">*</font>)</label>
                                    <input type="text" id="adresse" name="adresse" value="{{old('adresse')}}" class="form-control" placeholder="Adresse" required>
                                    @if ($errors->has('adresse'))
                                        <span class="help-block text-danger">
                                            <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class=" control-label" for="">Telephone Mobile 1 <span class="text-danger">*</span></label>
                                    <input type="text" id="telephone_mobile1" name="telephone_mobile1" value="{{old('telephone_mobile1')}}" class="form-control" placeholder="numéro.." required>
                                    @if ($errors->has('telephone_mobile1'))
                                        <span class="help-block text-danger">
                                            <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                           
                        </div>                              
                    </div>
                 </fieldset> <br>  
                  
                
            </div>
            <span class="upload_image"> </span>
            </div>
            <div class="panel-footer text-center">
                <input type="button" data-dismiss="modal"  class="btn btn-sm btn-warning"  value="Fermer">
                <input   type="submit"   class="btn btn-sm btn-success"  value="Enregister">
            </div>
            
        </form>
        </div>
    </div>
</div>
@section('additionnel_script')
<script>
    function afficherDecoupage(){
      var valeur =  $('#code_pays').val();
      if(valeur!='BF'){
        $('.decoupage_administratif').hide();
      }else{
        $('.decoupage_administratif').show();
      }
    } 
    function afficherPj(){
      var valeur =  $('#code').val();
      if(valeur!=37){
        //alert('ok');
        $('.commerce').show();
    }
    else{
        $('.commerce').hide();
    }
} 
</script>
<script type="text/javascript">
        function afficher_conjoint(){
        var val=$('#situation_matrimoniale').val();

            if(val==2){
                $(".usager").show();
                $(".mariage").show();
            }
            else{
                $(".usager").hide();
                $(".mariage").hide();
            }
            }   
</script>
<script type="text/javascript">

    $(document).ready(function(){
       // alert('okok');
        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button2'); //Add button selector
        var wrapper2 = $('.field_wrapper2'); //Input field wrapper
       
        var x = 0; //Initial field counter is 1
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                var desi="desi"+x;
                var cout='cout'+x ;
                var fieldHTML = '<div class="row" style="margin-top:10px;">  <select name="conjoints[]" data-placeholder="Selectionner le conjoint ..."  class="form-control select2 conjoints" style="width: 77%;" required >  <option></option> @foreach ($all_usagers as $all_usager )<option value="{{ $all_usager->id }}">{{ $all_usager->Phone_No_ }}-{{ $all_usager->NomRaisonSociale }}{{ $all_usager->prenom }}</option>@endforeach </select> <a style="width:2%" href="javascript:void(0);" class="remove_button"><span> <i class="fa fa-minus"></i></a> </div>';
                   
                $(wrapper2).append(fieldHTML);
                $(".select2").select2();
            }
        });
       // alert($('#cout1').val());
        $('#cout1').change(function(){
  alert("The text has been changed.");
}); 
        //Once remove button is clicked
        $(wrapper2).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>
@endsection