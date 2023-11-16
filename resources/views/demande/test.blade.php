@extends('layouts.frontend')
@section('content')
<!--<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Form Wizard | Nazox - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon 
        <link rel="shortcut icon" href="{{asset('backend/images/favicon.ico')}}">
        <!-- twitter-bootstrap-wizard css 
        <link rel="stylesheet" href="{{asset('backend/libs/twitter-bootstrap-wizard/prettify.css')}}">
        <!-- Bootstrap Css 
        <link href="{{asset('backend/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css 
        <link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css
        <link href="{{asset('backend/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body data-sidebar="dark">
    
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->


    <!-- <style>
fieldset {
  background-color: #eeeeee;
}

legend {
  background-color: gray;
  color: white;
  padding: 5px 10px;
}

input {
  margin: 5px;
}
</style>
</head>
<body>

<h1>The fieldset element + CSS</h1>

<form action="/action_page.php">
 <fieldset>
  <legend>Personalia:</legend>
  <label for="fname">First name:</label>
  <input type="text" id="fname" name="fname"><br><br>
  <label for="lname">Last name:</label>
  <input type="text" id="lname" name="lname"><br><br>
  <label for="email">Email:</label>
  <input type="email" id="email" name="email"><br><br>
  <label for="birthday">Birthday:</label>
  <input type="date" id="birthday" name="birthday"><br><br>
  <input type="submit" value="Submit">
 </fieldset>
</form> -->


                    <div class="container-fluid" id="taille" style="width:90%; margin-top:40px;">
                      <div class="taille">
                        <div class="row" id="choix_demande">
                       
                                                   <center> <h3 class="font-size-14 mb-4">Choisir le type d'Entreprise</h3></center>
                                                   @if($nbr_demande_pp==0)
                                                   <div class="form-check mb-3 col-md-4" id="switch1">
                                                        <input class="form-check-input" type="radio" onchange="changer_demande()" switch="bool" name="formRadios"
                                                            id="formRadios1" checked>
                                                        <label for="formRadios1" data-on-label="Oui" data-off-label="Non"></label>
                                                        <p>Entreprise Individuelle</p>
                                                        
                                                    </div>
                                                    @endif
                                                    <input type="hidden" class="nbr_demande" name="" value="{{$nbr_demande_pp}}">
                                                    <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" onchange="changer_demande()" switch="bool" name="formRadios"
                                                            id="formRadios2">
                                                            <label for="formRadios2" data-on-label="Oui" data-off-label="Non"></label>
                                                            <p>Entreprise Sociétaire</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" onchange="changer_demande()" switch="bool" name="formRadios"
                                                            id="formRadios3">
                                                            <label for="formRadios3" data-on-label="Oui" data-off-label="Non"></label>
                                                            <p>Groupement d'intérêt Economique</p>
                                                    </div>
                                                    <!-- <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="formRadios"
                                                            id="formRadios2">
                                                        <label class="form-check-label" for="formRadios2">
                                                            Form Radio checked
                                                        </label>
                                                    </div> -->
                        </div>
                       @include('demande.personne_physique')
                        <!-- end row -->
                  
                        @include('demande.personne_morale')
                    </div>
                    </div> <!-- container-fluid -->
                
@endsection
<div id='updatepiecejointe'class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" >Modifier <span id="piece_name_update"></span> </h5>
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
                        <label class=" control-label" for="example-chosen">Type piece<span class="text-danger">*</span></label>
                            <select  name="type_document" class="form-control type_document" data-placeholder="selection le type de document" style="width: 100%;">
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
                        <label class="control-label" for="example-chosen">Type piece <span class="text-danger">*</span></label>
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
                    <label class=" control-label" for="val_username">Numéro référence piece</label>
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
                            <input type="text" id="date_etablissement_u" name="date_detablissment" required class="form-control date_piecejointe" placeholder="dd-mm-yyyy"
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
                    <!-- <input class="form-control" type="file" id='piece_jointe_u' name="piece_jointe" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de l'ordre de service" >   -->
                    <div class="input-group col-md-8">
                        <input class="form-control input_file" type="file" id='piece_jointe_u' name="piece_jointe_u" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de la pièce" required  onchange="VerifyUploadSizeIsOK('piece_jointe_u');" >  
                        <span class="input-group-addon"><i class="gi gi-file"></i></span>
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('input_file')">Vider le champ</a></span>
                    </div>   
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
<div id='addpiecejointe'class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" >Enregistrer  <span id="piece_name_create"></h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fileUploadForm" action="javascript:void(0)" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" class='categorie_piece' name="categorie_piece"  value=""> 
                    <input type="hidden" class='type_doc' name="type_doc"  value=""> 
            <div class="row">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" id='type_piece_declaration' >
                    <div class="form-group" >
                        <label class=" control-label" for="example-chosen">Type pièce<span class="text-danger">*</span></label>
                            <select id="type_document" name="type_document" class="form-control " data-placeholder="selection le type de document" style="width: 100%;">
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
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6" id='type_piece_identite' style="display: none">
                    <div class="form-group" >
                        <label class=" control-label" for="example-chosen">Type pièce <span class="text-danger">*</span></label>
                            <select  name="type_document_identite" class="form-control " data-placeholder="selection le type de document" style="width: 100%;"  >
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
                                <input type="text" id="numero" name="numero_ref" value="{{old('lieu_etablissment')}}" class="form-control" placeholder="numéro.." required>
                            </div>
                        </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label class=" control-label" for="val_username">Date d'établissement</label>
                        <div class="input-group" id="datepicker1">
                            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                            <input type="text" name="date_detablissment" value="{{old('date_detablissment')}}" required class="form-control date_piecejointe" placeholder="dd-mm-yyyy"
                             data-date-format="dd-mm-yyyy" data-date-container='#datepicker1' data-provide="datepicker">
                        </div>
                </div>
                <div class="form-group col-md-6">
                    <label class=" control-label" for="val_username">Lieu d'établissement</label>
                        <div class="input-group" >
                            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                            <div class="input-group">
                                <input type="text" id="lieu_etablissment" name="lieu_etablissment" value="{{old('lieu_etablissment')}}" class="form-control" placeholder="Lieu etablissement.." required>
                            </div>
                        </div>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('piece_jointe') ? ' has-error' : '' }}">
                    <label class=" control-label" for="piece_contractuelle">Joindre la piece<span class="text-success">*</span></label>
                    <!-- <input class="form-control" type="file" id='piece_jointe_1' name="piece_jointe" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de l'ordre de service" >   -->
                    <div class="input-group col-md-8">
                        <input class="form-control input_file" type="file" id='piece_jointe_1' name="piece_jointe" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre la pièce" required  onchange="VerifyUploadSizeIsOK('piece_jointe_1');" >  
                        <span class="input-group-addon"><i class="gi gi-file"></i></span>
                        <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('input_file')">Vider le champ</a></span>
                    </div>
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
                                <!-- <input type="text" name="prenom_usager" class="form-control" id="progress-basicpill-vatno-input" > -->
                            </div>
                        </div>   
                        {{-- <div class="col-lg-6">
                            <div class="mb-3" id="datepicker1">
                                <label class="form-label" for="progress-basicpill-vatno-input">Date de naissance</label>
                                <input type="text" name="date_de_naissance" value="{{old('date_de_formalisation')}}" required class="form-control" placeholder="dd-mm-yyyy"
                                    data-date-format="dd-mm-yyyy" data-date-container='#datepicker1' data-provide="datepicker">
                            </div>
                        </div> --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="val_username">Civilités</label>
                                <select id="single-select-field" name="civilite" class="form-control"  data-placeholder="Selectionnez la civilité" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
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
                                    <input type="text" id="prenom" name="lieu_de_naissance" class="form-control" value="{{old('lieu_de_naissance')}}"placeholder="Entrez le lieu de naissance.." required="Ce champ est obligatoire" onchange="this.value = this.value.charAt(0).toUpperCase()+ this.value.substr(1);">
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
                            <label class=" control-label" for="example-chosen">Nationalité<span class="text-danger">*</span></label>
                            <select name="nationalite_usager" data-placeholder="Choisir type identite" class="form-control " style="width: 100%;" required >
                                <option></option>
                                    @foreach ($pays as $pay )
                                        <option value="{{ $pay->code }}">{{ $pay->libelle }}</option>
                                    @endforeach
                                
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">                                                                    
                            <label class=" control-label" for="example-chosen">Pays de residence<span class="text-danger">*</span></label>
                            <select  name="pays_usager" data-placeholder="Choisir la pays de residence" class="form-control" style="width: 100%;" required onchange="afficherDecoupage();" >
                                <option></option>
                                    @foreach ($pays as $pay )
                                        <option value="{{ $pay->code }}">{{ $pay->libelle }}</option>
                                    @endforeach
                                
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class=" control-label" for="">Adresse <span class="text-danger">*</span></label>
                                    <input type="text" id="adresse" name="adresse" value="{{old('adresse')}}" class="form-control" placeholder="adresse.." required>
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

<!-- Pour script -->
@section('additionnel_script')
<script type="javascript/text" src="{{ asset('backend/loaddata.js') }}"></script>

<script>

$( document ).ready(function() {
$(document).on("click", ".declaration", function(){
    console.log('okok');
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("la déclaration sur l'honneur et casier judiciaire");
      $('.categorie_piece').val('declaration')
        //$('#type_piece_declaration').show();
        $('#type_piece_declaration').show();
       $('#type_piece_identite').hide();
     });
     
     $(document).on("click", "#certificat_de_residence", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("le certificat de résidence");
        $('.categorie_piece').val('certificat_de_residence')
         $('.type_doc').val('certificat_de_residence')
         //console.log($('#type_doc').val());
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
});  
$(document).on("click", ".formulaire_dem_cpc", function(){
        
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("le formulaire de demande CPC");
        $('.categorie_piece').val('formulaire_dem_cpc')
        $('.type_doc').val('formulaire_dem_cpc') 
        $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
$(document).on("click", ".piece_didentite", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("la pièce d'identité");
         $('.categorie_piece').val('piece_didentite')
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').show();

    });
$(document).on("click", ".titre_de_propriete", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("le titre de propiété");
         $('.categorie_piece').val('titre_de_propriete')
         $('.type_doc').val('titre_de_propriete') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
$(document).on("click", ".photo_didentite", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("la photo d'identité");
         $('.categorie_piece').val('photo_didentite');
         $('.type_doc').val('photo_didentite') 
        $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
$(document).on("click", ".formulaire_dem_cpc", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("le formulaire de demande CPC");
         $('.categorie_piece').val('formulaire_dem_cpc')
         $('.type_doc').val('formulaire_dem_cpc') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
 $(document).on("click", ".formulaire_rccm", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("le formulaire RCCM");
         $('.categorie_piece').val('formulaire_rccm');
         $('.type_doc').val('formulaire_rccm');
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
$(document).on("click", ".statut", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("le statut");
         $('.categorie_piece').val('statut')
         $('.type_doc').val('statut') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
     $(document).on("click", ".acte_de_depot", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("l'acte de dépôt");
         $('.categorie_piece').val('acte_de_depot')
         $('.type_doc').val('acte_de_depot') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
     $(document).on("click", ".formulaire_cpc_es", function(){
        $('#fileUploadForm')[0].reset();
        $('.upload_image').html(' ');
        $('#piece_name_create').html("le formulaire de demande CPC");
         $('.categorie_piece').val('formulaire_dem_cpc')
         $('.type_doc').val('formulaire_cpc_es') 
        // alert($('.type_doc').val());
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
});
</script>
<script>
$( document ).ready(function() {
var form = $(".form_individuel");
form.validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        confirm: {
            equalTo: "#password"
        }
    }
});
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        if( !$('.piece_declaration').val() || !$('.piece_cpc').val() || !$('.piece_identite').val() || !$('.piece_certificat').val()
        || !$('.piece_photo').val() || !$('.piece_propriete').val()) {
        //alert('completez');
        $('.alerte_piece').show();
        // console.log($('.piece_photo').val());
        // alert('photo');
        return form.invalid();
        }
       else{
        $('.alerte_piece').hide();
        return form.valid();
       }

        //  if(!$('.piece_photo').val()) {
        //     $('.alerte_piece').show();
        //  console.log($('.piece_photo').val());
        //  alert('photo');
        //  }
        //  else{
        //  $('.alerte_piece').hide();
        //  return form.valid();
        // }


        // if(!$('.piece_cpc').val()){
        // alert('completez cpc');
        // return form.invalid();
        // }   
        
        // if(!$('.piece_photo').val()){
        // $('.piece_photo').show();
        // //alert('completez cpc');
        // return form.invalid();
        // }  
        
        //return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {        
        document.getElementById("physique").submit();              
        
    }
});
});
</script>
<script>
$( document ).ready(function() {
var form = $(".moral");
form.validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        confirm: {
            equalTo: "#password"
        }
    }
});
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        if( !$('.piece_declaration').val() || !$('.piece_acte_depot').val() || !$('.piece_statut').val()
        || !$('.piece_rccm').val() || !$('.piece_identite').val() || !$('.piece_propriete').val()) {
        //alert('completez');
        $('.alerte_piece_pm').show();
        // console.log($('.piece_photo').val());
        // alert('photo');
        return form.invalid();
        }
       else{
        $('.alerte_piece').hide();
        return form.valid();
       }
        //return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {        
        
        document.getElementById("morale").submit();              
        
    }
});
});
</script>
<script>
    function hidemodal(){
        $.ajax({
          url: 'http://localhost:4000/tour',
          type: "get",
          success: function (response) {
            $('#modal-confirm-devis').modal('hide');
      }
    });
    }
</script>
<script>
    if($('.piece').val()==null){
        console.log('test');
    }
</script>
<script>
    

    function changer_demande(){
        if($('#formRadios2').is(':checked')){
            $('#progrss-wizar').hide();
            $('#progrss-wizar2').show();
            $('#formjuridiquees').show();
            $('#formjuridiquegie').hide();
            $('#type_demande').val('M1');
            //$('#choix_demande').hide();
        }  
       else if($('#formRadios1').is(':checked')){
            $('#progrss-wizar').show();
            $('#progrss-wizar2').hide();
            //$('#choix_demande').hide();
        }
        else if($('#formRadios3').is(':checked')){
            $('#progrss-wizar').hide();
            $('#progrss-wizar2').show();
            $('#formjuridiquees').hide();
            $('#formjuridiquegie').show();
            $('#type_demande').val('G1');
           // $('#choix_demande').hide();
        }
    }
    var nbr_demande= $('.nbr_demande').val();
        
        if(nbr_demande>0){
            $('#formRadios2').prop("checked", true);
        }
    $(document).ready(function(){
        changer_demande();
    })

      // Pour la signature Personne Physique
     
    
</script>
<script>
    //alert('signa');
    $(document).ready(function()
      {var sign_pp='';
        sign_pp= $('#sign_pp').signature({ syncField: '#signature_pp', syncFormat:'PNG'});
    $('#clear_pp').click(function(e){
        e.preventDefault();
        sign_pp.signature('clear');
        $('#signature_pp').val('');
    });
});


$(document).ready(function()
      { var sign='';
        sign= $('#sign_pm').signature({ syncField: '#signature_pm', syncFormat:'PNG'});
    $('#clear_pm').click(function(e){
        e.preventDefault();
        sign.signature('clear');
        $('#signature_pm').val('');
    });
});
    </script>
<script>
    $(document).ready(function(){
        $('#type_piece_declaration').hide();
         $('#type_piece_identite').hide();
         $('#type_piece_declaration').hide();
         $('#type_piece_didentite').hide();

     });
    
</script>
<script type="text/javascript">

    $(document).ready(function(){
       // alert('okok');
        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add-line'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
       
        var x = 0; //Initial field counter is 1
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                var desi="desi"+x;
                var cout='cout'+x ;
                var fieldHTML = 
               // '<div class="row" style="margin-top:10px;">  <select name="conjoints[]" data-placeholder="Selectionner le conjoint ..."  class="form-control select2 conjoints" style="width: 77%;" required >  <option></option> @foreach ($all_usagers as $all_usager )<option value="{{ $all_usager->id }}">{{ $all_usager->Phone_No_ }}-{{ $all_usager->NomRaisonSociale }}{{ $all_usager->prenom }}</option>@endforeach </select> <a style="width:2%" href="javascript:void(0);" class="remove_button"><span> <i class="fa fa-minus"></i></a> </div>';
                '<div class="row"><div class="col-md-4"> <div class="mb-3" > <label class="form-label" for="progress-basicpill-vatno-input">Associé</label> <select  name="associes[]" data-placeholder="Selectionner associé ..." class="form-control select conjoints" style="width: 100%;" required > <option></option> @foreach ($all_usagers as $all_usager ) <option value="{{ $all_usager->id }}">{{ $all_usager->Phone_No_ }}-{{ $all_usager->NomRaisonSociale }}{{ $all_usager->prenom }}</option> @endforeach </select> </div> </div> <div class="col-lg-4"> <div class="mb-3"> <label class="form-label" for="progress-basicpill-vatno-input">Fonction</label> <select  name="fonction_associes[]" data-placeholder="Choisir lactivité ..." class="form-control select" style="width: 100%;"><option></option> @foreach ($fonctions as $fonction ) <option value="{{ $fonction->id }}">{{ $fonction->libelle }}</option>  @endforeach </select> </div> </div> <div class="col-lg-2"> <div class="mb-3"> <label class="form-label" for="progress-basicpill-vatno-input">% Capital (<font color="red">*</font>)</label> <input type="text" name="capital_associes[]" class="form-control" id="progress-basicpill-cstno-input"> </div> </div> <a href="javascript:void(0);" style="margin-top: 30px; margin-left:7px; width: 40px; height:30px;" class="btn btn-md btn-success remove_button col-md-2"> <i class="fas fa-minus"></i> </a> </div>'
                $(wrapper).append(fieldHTML);
                $(".select").select2();
            }
        });
       // alert($('#cout1').val());
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>
    
<script type="text/javascript">

    $(document).ready(function(){
       // alert('okok');
        var maxField = 2; //Input fields increment limitation
        var addButton = $('.add-com'); //Add button selector
        var wrapper = $('.com_wrapper'); //Input field wrapper
       
        var x = 0; //Initial field counter is 1
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                var desi="desi"+x;
                var cout='cout'+x ;
                var fieldHTML =                
                '<div class="row"><div class="col-md-4"> <div class="mb-3" > <label class="form-label" for="progress-basicpill-vatno-input">Nom et Prénom</label> <select id=""  name="commissaire[]" data-placeholder="Selectionner le commissaire" class="form-control select conjoints" style="width: 100%;" required ><option></option> @foreach ($all_usagers as $all_usager ) <option value="{{ $all_usager->id }}">{{ $all_usager->Phone_No_ }}-{{ $all_usager->NomRaisonSociale }}{{ $all_usager->prenom }}</option> @endforeach </select> </div> </div> <div class="col-lg-4"> <div class="mb-3"> <label class="form-label" for="progress-basicpill-vatno-input">Qualité</label> <select id="" name="qualite_commissaire[]" data-placeholder="Choisir Qualite" class="form-control select" style="width: 100%;"> <option></option> <option value="Titulaire">Titulaire</option> <option value="Supléant">Supléant</option> </select> </div> </div> <a href="javascript:void(0);" style="margin-top: 30px; margin-left:7px; width: 40px; height:30px;" class="btn btn-md btn-success remove_button col-md-2"> <i class="fas fa-minus"></i> </a> </div>'
                
                $(wrapper).append(fieldHTML);
                $(".select").select2();
            }
        });
       // alert($('#cout1').val());
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>
    <script>
        function montantCapital(){
            //alert('ok');
            //dont_numeraire
           var dont_numeraire= $('#dont_numeraire').val();
          // var dont_industrie= $('#dont_industrie').val();
           var dont_nature= $('#dont_nature').val();
           var total=parseInt(dont_nature)+parseInt(dont_numeraire);
            $('#montant_capital').val(total);
           
        }

        function montantAction(){
           var montant_action=$('#montant_action').val();
           var montant_capital=$('#montant_capital').val();
           var nbreactions=parseInt(montant_capital)/parseInt(montant_action);
           var nbreaction=parseInt(nbreactions);
           $('#nbre_action').val(nbreaction);
        }
    </script>
    <script>
        data(){
            return {
                load: false,
            }
        }
    </script>
<script>
    function chiffre_daffaire(){
        var val_pm=$('#chiffre_daffaire_prev_pm').val();
        var val_pp=$('#chiffre_daffaire_prev_pp').val();
        if(val_pm<1000000){
            $('.chiffre_pm').show();
        }
        else{
            $('.chiffre_pm').hide();
        }
        if(val_pp<1000000){
            $('.chiffre_pp').show();
        }
        else{
            $('.chiffre_pp').hide();
        }
    }
</script>
@endsection