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


                    <div class="container-fluid" style="width:80%; margin-top:40px; ">
                        <div class="row"
                       
                                                   <center> <h3 class="font-size-14 mb-4">Choisir le type d'Entreprise</h3></center>
                                                    <div class="form-check mb-3 col-md-4" id="switch1" >
                                                        <input class="form-check-input" type="radio" onchange="changer_demande()" switch="bool" name="formRadios"
                                                            id="formRadios1">
                                                        <label for="formRadios1" data-on-label="Oui" data-off-label="Non"></label>
                                                        <p>Entreprise Individuelles</p>
                                                        
                                                    </div>
                                                    <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" onchange="changer_demande()" switch="bool" name="formRadios"
                                                            id="formRadios2" checked>
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
   
                        <div class="row" id="progrss-wizar" style="display:none" >
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Demande Entreprise Physique</h4>
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
                                         <form action="{{ route('demande.store') }}" method="post"  class='form_individuel'>
                                            @csrf
                                            <div class="tab-content twitter-bs-wizard-tab-content">
                                                <h3>Formalités et piece</h3>
                                                
                                                <section class="tab-pane custom-validation" id="progress-seller-details">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                                      </div>
                                                      
                                                      <br>
                                                    <!-- <form> -->
                                                        <div class="row text-center " style="border: 1px solid rgb(116, 116, 105); margin-bottom:5px; padding:5px;"  class="mb-2">
                                                            <h5 class="font-size-14 mb-4">Formalités Demandées</h5>
                                                            <div class="col-md-3">
                                                        </div>
                                                           <div class="form-check col-md-3 text-center">
                                                               <input class="form-check-input" type="checkbox" id="formCheck1">
                                                               <label class="form-check-label" for="formCheck1">
                                                                   RCCM
                                                               </label>
                                                           </div>
                                                           <div class="form-check col-md-3 ">
                                                               <input class="form-check-input" type="checkbox" id="formCheck2" checked>
                                                               <label class="form-check-label" for="formCheck2">
                                                                   IFU
                                                               </label>
                                                           </div>
                                                        </div>
                                                        <div class="row">
                                                            <h5 class="font-size-14 mb-4 text-center">Pieces Requises</h5>
                                                            <div class="col-lg-6">  
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Déclaration sur l'honneur/Casier</label>
                                                                    @if(returnpieceinfos('declaration'))
                                                                        <div class="input-group">
                                                                            <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration" value="declaration" required >
                                                                            <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration_edit" onclick="editpiecejointe('declaration')" > <i class="fas fa-pen"></i> </a>
                                                                                <a href="{{ route('detaildocument') }}?categoriepiece=declaration" id="declaration_view"  class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                    <div class="input-group">
                                                                        <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration"  required >
                                                                        <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id="declaration"  data-toggle="modal"  class="btn btn-md btn-success declaration"> <i class=" fas fa-plus"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Certification de résidence</label>
                                                                @if(returnpieceinfos('certificat_de_residence'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="certificat_de_residence" id='input_certificat_de_residence' disabled class="form-control col-md-7"  value="certificat_de_residence" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="certificat_de_residence_edit" data-toggle="modal" class="btn btn-md btn-success" onclick="editpiecejointe('certificat_de_residence')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=certificat_de_residence" id="certificat_de_residence_view" class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group">
                                                                    <input type="text" name="certificat_de_residence" id='input_certificat_de_residence' disabled class="form-control col-md-7"  required >
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id='certificat_de_residence' data-toggle="modal" class="btn btn-md btn-success"> <i class=" fas fa-plus"></i> </a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Formulaire de Demande CPC</label>
                                                                    <div class="input-group formulaire_dem_cpc_group_edit" style="display: none">
                                                                        <input type="text" name="formulaire_dem_cpc" id="formulaire_dem_cpc_input" disabled class="form-control col-md-7" value="formulaire de demande CPC" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" data-toggle="modal" id="formulaire_dem_cpc_edit" class="btn btn-md btn-success" onclick="editpiecejointe('formulaire_dem_cpc')"> <i class="fas fa-pen"></i> </a>
                                                                             <a  href="{{ route('detaildocument') }}?categoriepiece=formulaire_dem_cpc" id="formulaire_dem_cpc_view" class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('formulaire_dem_cpc'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="formulaire_dem_cpc" id="formulaire_dem_cpc_input" disabled class="form-control col-md-7" value="formulaire de demande CPC" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" data-toggle="modal" id="formulaire_dem_cpc_edit" class="btn btn-md btn-success" onclick="editpiecejointe('formulaire_dem_cpc')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=formulaire_dem_cpc"  id="formulaire_dem_cpc_view" class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="input-group formulaire_dem_cpc_group_add">
                                                                        <input type="text" name="formulaire_dem_cpc" id="formulaire_dem_cpc_input" disabled class="form-control col-md-7" required >
                                                                        <div class="col-md-5">
                                                                            <a href="#addpiecejointe" id='formulaire_dem_cpc' data-toggle="modal" class="btn btn-md btn-success"   > <i class=" fas fa-plus"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Photo d'identité</label>
                                                                    <div class="input-group photo_didentite_group_edit" style="display: none">
                                                                        <input type="text" name="photo_identite" id="photo_didentite_input" disabled class="form-control col-md-7"  value="photo_didentite" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id='photo_didentite_edit' data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('photo_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=photo_didentite"  id='photo_didentite_view'   class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('photo_didentite'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="photo_identite" id="photo_didentite_input" disabled class="form-control col-md-7"  value="photo_didentite" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id='photo_didentite_edit' data-toggle="modal"  class="btn btn-md btn-success" onclick="editpiecejointe('photo_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=photo_didentite"  id='photo_didentite_view'   class="btn btn-md btn-success"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group photo_didentite_group_add">
                                                                    <input type="text" name="photo_identite" id="photo_didentite_input" disabled class="form-control col-md-7"  required >
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id='photo_didentite' data-toggle="modal" class="btn btn-md btn-success"  > <i class=" fas fa-plus"></i> </a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Piece d'identité</label>
                                                                    <div class="input-group piece_didentite_group_edit " style="display: none">
                                                                        <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input" value="pièce_didentite" >
                                                                        <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success piece_didentite_edit" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=piece_didentite" id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('piece_didentite'))
                                                                        <div class="input-group">
                                                                            <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input" value="pièce_didentite" >
                                                                            <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success piece_didentite_edit" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                                <a  href="{{ route('detaildocument') }}?categoriepiece=piece_didentite"  id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                    <div class="input-group piece_didentite_group_add">
                                                                        <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input" required >
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
                                                                        <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input"  value="titre_de_propriete" >
                                                                        <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="titre_de_propriete_edit" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" onclick="editpiecejointe('titre_de_propriete')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=titre_de_propriete" id="titre_de_propriete_view" class="btn btn-md btn-success titre_de_propriete_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('titre_de_propriete'))
                                                                        <div class="input-group">
                                                                            <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input"  value="{{ returnpieceinfos('titre_de_propriete')->id}}" >
                                                                            <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="titre_de_propriete_edit" data-toggle="modal" class="btn btn-md btn-success titre_de_propriete_edit" onclick="editpiecejointe('titre_de_propriete')"> <i class="fas fa-pen"></i> </a>
                                                                                <a  href="{{ route('detaildocument') }}?categoriepiece=titre_de_propriete" id="titre_de_propriete_view" class="btn btn-md btn-success titre_de_propriete_view"> <i class="fas fa-eye"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="input-group titre_de_propriete_group_add">
                                                                            <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input" value="titre de propriété" >
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
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nomss Commedrcial</label>
                                                                    <input type="text" id="nom_commercial_pp" name="nom_commercial" class="form-control required" id="progress-basicpill-vatno-input"  onchange="alert('ok');" >
                                                                    <!--  -->
                                                                    <!-- <input type="text" name="nom" class="form-control" id="progress-basicpill-pancard-input"> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Enseigne</label>
                                                                    <input type="text" name="enseigne" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                    <!-- <label class="form-label" for="progress-basicpill-vatno-input">Chiffre d'affaire Prévisionnel</label>
                                                                    <input type="text" name="chiffre_daffaire_previsionnel" placeholder="Montant en FCFA" class="form-control" id="progress-basicpill-vatno-input" required> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Sigle</label>
                                                                    <input type="text" name="sigle" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                </div>
                                                            </div>                                     
                                                        </div>
                                                     </fieldset> <br>
                                                   
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Type Entreprise</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Type Etablissement</label>
                                                                    <select id="secteur" name="profession" data-placeholder="Choisir la profession ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="Test">Principal</option>
                                                                            <option value="Test">Sécondaire</option>
                                                                            <option value="Test">Succursale</option>
                                                                    </select>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Régime Fiscal</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Chiffre d'affaire Prévisionnel (FCFA)</label>                                                                    
                                                                    <input type="text" name="chiffre_daffaire_previsionnel" class="form-control" id="progress-basicpill-cstno-input"> 
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
                                                                    <select id="secteur_activite" name="secteur_activite" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select>                                                                 
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Activité Principale (<font color="red">*</font>)</label>
                                                                        <select id="activite_principale" name="activite_principale" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                            <option></option>
                                                                                <option value="principal">Commerce de gros produits</option>
                                                                                <option value="secondaire">Fabrication de savon</option>  
                                                                                <option value="bureau">Services d'ingénierie</option>
                                                                        </select>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Objet Social (<font color="red">*</font>)</label>
                                                                    <textarea type="text" name="objet_social" class="form-control" data-placeholder="Saisir les activités que vous exercez" id="progress-basicpill-vatno-input" required></textarea>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Activités Sécondaires (<font color="red">*</font>)</label>
                                                                    <select id="activite_secondaire" name="activite_secondaire" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                            <option></option>
                                                                            <option value="principal">Principal</option>
                                                                            <option value="secondaire">Sécondaire</option>  
                                                                            <option value="bureau">Succursale</option>
                                                                    </select>                                                                   
                                                                </div>
                                                            </div>                                                           
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Employés</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Permanant</label>                                                                    
                                                                    <input type="text" name="employe_permanant" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Temporaire</label>                                                                    
                                                                    <input type="text" name="employe_temporaire" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Etranger</label>                                                                    
                                                                    <input type="text" name="employe_etranger" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Personne(s) Pouvant engager la responsabilité de l'entreprise</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Nom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Prenom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Fonction (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="fonction_personne_pouvant_engager" class="form-control" id="progress-basicpill-servicetax-input"> -->
                                                                    <select id="activite_secondaire" name="fonction_personne_pouvant_engager" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                            <option></option>
                                                                            <option value="principal">Président</option>
                                                                            <option value="secondaire">Directeur</option>  
                                                                            <option value="bureau">Secrétaire</option>
                                                                    </select>
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
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="secteur_activite" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Province (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Commune ou Département (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Arrondissement</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Secteur ou Village (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Mobile 1 (<font color="red">*</font>)</label>
                                                                    <input type="text" name="mobile_1" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Tel Bureau</label>
                                                                    <input type="text" name="tel_bureau" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Boite Postale</label>
                                                                    <input type="text" name="boite_postale" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Adresse</label>
                                                                    <input type="text" name="adresse" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">E-mail</label>
                                                                    <input type="text" name="boite_postale" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Site Web</label>
                                                                    <input type="text" name="site_web" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                     </fieldset> <br>                                                        
                                                    
                                    
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
                                                          <div  class="row justify-content-center">
                                                                <div class="col-lg-6">
                                                                  <div class="mb-3" id="sign">
                                                                      <!-- <label class="form-label" for="progress-basicpill-namecard-input">Signez dans la case ci-dessous</label> -->
                                                                      <!-- <textarea name="signed" class="form-control" id="signature"></textarea> -->
                                                                      <button class="button-sign" id="clear">Clear Signature</button>
                                                                      <button class="button-sign" id="clear">Save</button>
                                                                      <!-- <textarea type="text" name="email" class="form-control" id="progress-basicpill-namecard-input" cols="30" rows="10"></textarea> -->
                                                                  </div>
                                                              </div>
                                                             
                                                          </div>
                                                      </fieldset><br>

                                                      <fieldset>
                                                        <legend><span class="legend-fieldest">Confirmation</span></legend>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                  <input type="checkbox" id="switch4" switch="success" />
                                                    <label for="switch4" data-on-label="On" data-off-label="Off"></label>

                                                                      <p>
                                                                        Je confirme certifie que les documents joints sont authentiques (absence de faux et usage de faux)
                                                                        et les déclarations sont sincères. Je m'engage à apporter la totalité des dossiers
                                                                        </p>
                                                                        <input type="checkbox" id="switch9" switch="dark" checked />
                                                                  </div>

                                                              </div>
                                                             
                                                          </div>
                                                      </fieldset>
                                                          <!-- <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-cardno-input">Credit Card Number</label>
                                                                      <input type="text" name="number_credit" class="form-control" id="progress-basicpill-cardno-input">
                                                                  </div>
                                                              </div>
   
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-card-verification-input">Card Verification Number</label>
                                                                      <input type="text" name="card_number" class="form-control" id="progress-basicpill-card-verification-input">
                                                                  </div>
                                                              </div>
                                                          </div> -->
                                                          <!-- <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-expiration-input">Expiration Date</label>
                                                                      <input type="date" name="date_expire" class="form-control" id="progress-basicpill-expiration-input">
                                                                  </div>
                                                              </div>
  
                                                          </div> -->
                                                          
                                                    </div>
                                                </section>
                                                <h3>Confirmation</h3>
                                                <section class="tab-pane" id="progress-confirm-detail">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                      </div>
                                                      <br>
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-6">
                                                            <div class="text-center">
                                                                <div class="mb-4">
                                                                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                                </div>
                                                                <div>
                                                                    <h5>Confirm Detail</h5>
                                                                    <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                                                </div>
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
                        <!-- end row -->
                  
                        <div class="row" id="progrss-wizar2" style="">
                            

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Demande Entreprise Morale</h4>
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
                                         <form action="{{ route('demande.store') }}" method="post" class='form_individuel'>
                                            @csrf
                                            <div class="tab-content twitter-bs-wizard-tab-content">
                                            <h3>Formalités et Pieces</h3>
                                                <section class="tab-pane" id="progress-seller-detailss">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                                      </div>
                                                      <br>
                                                <div class="row text-center" style="border: 1px solid rgb(116, 116, 105); margin-bottom:10px; padding:15px;"  class="mb-2">
                                                             <h5 class="font-size-14 mb-4">Formalités Demandées</h5>
                                                            <div class="form-check col-md-3">
                                                                <input class="form-check-input" type="checkbox" id="formCheck1">
                                                                <label class="form-check-label" for="formCheck1">
                                                                    RCCM
                                                                </label>
                                                            </div>
                                                            <div class="form-check col-md-3 ">
                                                                <input class="form-check-input" type="checkbox" id="formCheck2" checked>
                                                                <label class="form-check-label" for="formCheck2">
                                                                    IFU
                                                                </label>
                                                            </div>
                                                        
                                                   
                                                </div>
                                                    <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Déclaration sur l'honneur/Casier</label>
                                                                    <div class="input-group declaration_group_edit" style="display: none" >
                                                                        <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration"  value="Declaration sur l'honneur" >
                                                                        <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration" onclick="editpiecejointe('declaration')" > <i class="fas fa-pen"></i> </a>
                                                                             <a href="{{ route('detaildocument', returnpieceinfos('declaration')->id) }}"  id="declaration_view"   class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                @if(returnpieceinfos('declaration'))
                                                                    <div class="input-group">
                                                                        <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration"  value="Declaration sur l'honneur" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration" onclick="editpiecejointe('declaration')" > <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=declaration" id="declaration_view"   class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group declaration_group_add">
                                                                    <input type="text" id="input_declaration" name="declaration_sur_lhonneur" disabled class="form-control col-md-7 input_declaration"  required >
                                                                     <div class="col-md-5">
                                                                        <a href="#addpiecejointe" id="declaration"  data-toggle="modal"  class="btn btn-md btn-success declaration"  > <i class=" fas fa-plus"></i> </a>
                                                                      
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">Acte de Depot</label>
                                                                    <div class="input-group acte_de_depot_edit" style="display: none">
                                                                        <input type="text" name="acte_de_depot_input" id="acte_de_depot_input" disabled class="form-control col-md-7 acte_de_depot_input"  value="Acte de depot" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="acte_de_depot_edit"   data-toggle="modal"  class="btn btn-md btn-success acte_de_depot" onclick="editpiecejointe('acte_de_depot')"> <i class="fas fa-pen"></i> </a>
                                                                           <a  href="{{ route('detaildocument') }}?categoriepiece=acte_de_depot" id="acte_de_depot_view"   class="btn btn-md btn-success acte_de_depot_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    @if(returnpieceinfos('acte_de_depot'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="acte_de_depot_input" id="acte_de_depot_input" disabled class="form-control col-md-7 acte_de_depot_input"  value="Acte de depot" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="acte_de_depot_edit"   data-toggle="modal"  class="btn btn-md btn-success acte_de_depot" onclick="editpiecejointe('acte_de_depot')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=acte_de_depot" id="acte_de_depot_view"   class="btn btn-md btn-success acte_de_depot_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div class="input-group acte_de_depot_add">
                                                                        <input type="text" name="acte_de_depot_input" id="acte_de_depot_input" disabled class="form-control col-md-7 acte_de_depot_input"   >
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
                                                                        <a href="#updatepiecejointe" id="statut_edit"  data-toggle="modal"  class="btn btn-md btn-success statut" onclick="editpiecejointe('acte_de_depot')"> <i class="fas fa-pen"></i> </a>
                                                                         <a href="{{ route('detaildocument') }}?categoriepiece=statut"  id="statut_view"   class="btn btn-md btn-success statut_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @if(returnpieceinfos('statut'))
                                                                    <div class="input-group" >
                                                                        <input type="text" name="statut" id="statut_input" disabled class="form-control col-md-7 statut_input"  value="staut" >
                                                                         <div class="col-md-5">
                                                                        <a href="#updatepiecejointe" id="statut_edit"  data-toggle="modal"  class="btn btn-md btn-success statut" onclick="editpiecejointe('acte_de_depot')"> <i class="fas fa-pen"></i> </a>
                                                                        <a href="{{ route('detaildocument') }}?categoriepiece=statut"  id="statut_view"   class="btn btn-md btn-success statut_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group add_statut_group">
                                                                    <input type="text" name="statut" id="statut_input" disabled class="form-control col-md-7 statut_input"  >
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
                                                                            <a href="#updatepiecejointe" id="formulaire_rccm_edit"  data-toggle="modal"  class="btn btn-md btn-success formulaire_rccm" onclick="editpiecejointe('formulaire_rccm')"> <i class="fas fa-pen"></i> </a>
                                                                           <a href="{{ route('detaildocument') }}?categoriepiece=formulaire_rccm" id="formulaire_rccm_view"   class="btn btn-md btn-success formulaire_rccm_view"> <i class="fas fa-eye"></i> </a> 
                                                                        </div>
                                                                    </div>
                                                                 @if(returnpieceinfos('formulaire_rccm'))
                                                                    <div class="input-group">
                                                                        <input type="text" name="formulaire_rccm" id="formulaire_rccm_input" disabled class="form-control col-md-7 formulaire_rccm_input"  value="Formulaire RCCM" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="formulaire_rccm_edit"  data-toggle="modal"  class="btn btn-md btn-success formulaire_rccm" onclick="editpiecejointe('formulaire_rccm')"> <i class="fas fa-pen"></i> </a>
                                                                            <a href="{{ route('detaildocument') }}?categoriepiece=formulaire_rccm" id="formulaire_rccm_view"   class="btn btn-md btn-success formulaire_rccm_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                <div class="input-group formulaire_rccm_group_add">
                                                                    <input type="text" name="formulaire_rccm" id="formulaire_rccm_input" disabled class="form-control col-md-7 formulaire_rccm_input"  >
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
                                                                                <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success piece_didentite" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                                 <a href="{{ route('detaildocument') }}?categoriepiece=piece_didentite" id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a> 
                                                                            </div>
                                                                        </div>
                                                                     @if(returnpieceinfos('piece_didentite'))
                                                                        <div class="input-group">
                                                                            <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input" value="Piece d'identité" >
                                                                             <div class="col-md-5">
                                                                                <a href="#updatepiecejointe" id="piece_didentite_edit"  data-toggle="modal"  class="btn btn-md btn-success piece_didentite" onclick="editpiecejointe('piece_didentite')"> <i class="fas fa-pen"></i> </a>
                                                                                <a href="{{ route('detaildocument') }}?categoriepiece=piece_didentite"  id="piece_didentite_view"  class="btn btn-md btn-success piece_didentite_view"> <i class="fas fa-eye"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                    <div class="input-group piece_didentite_group_add">
                                                                        <input type="text" name="piece_didentite" id="piece_didentite_input" disabled class="form-control col-md-7 piece_didentite_input"  >
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
                                                                        <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input"  value="Titre de propriété" >
                                                                         <div class="col-md-5">
                                                                            <a href="#updatepiecejointe" id="titre_de_propriete_edit" data-toggle="modal"  class="btn btn-md btn-success titre_de_propriete" onclick="editpiecejointe('titre_de_propriete')"> <i class="fas fa-pen"></i> </a>
                                                                            <a  href="{{ route('detaildocument') }}?categoriepiece=titre_de_propriete" id="titre_de_propriete_view"  class="btn btn-md btn-success titre_de_propriete_view"> <i class="fas fa-eye"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="input-group titre_de_propriete_group_add">
                                                                        <input type="text" name="titre_de_propriete" id="titre_de_propriete_input" disabled class="form-control col-md-7 titre_de_propriete_input"  required >
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
                                                                    <!-- <label class="form-label" for="progress-basicpill-pancard-input">Type Etablissement</label> -->
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nom Commrecial</label>
                                                                    <input id='nom_commercial_pm' type="text" name="nom_commercial" class="form-control" id="progress-basicpill-vatno-input" required onchange="valider_nom_commercial('nom_commercial_pm');">
                                                                    <!--  -->
                                                                    <!-- <input type="text" name="nom" class="form-control" id="progress-basicpill-pancard-input"> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Enseigne</label>
                                                                    <input type="text" name="enseigne" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                    <!-- <label class="form-label" for="progress-basicpill-vatno-input">Chiffre d'affaire Prévisionnel</label>
                                                                    <input type="text" name="chiffre_daffaire_previsionnel" placeholder="Montant en FCFA" class="form-control" id="progress-basicpill-vatno-input" required> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Dénomination Sociale</label>
                                                                    <input type="text" id="denomination_sociale" name="denomination_sociale" class="form-control required" id="progress-basicpill-vatno-input" required onchange="valider_nom_commercial('denomination_sociale');">
                                                                </div>
                                                            </div>   
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Sigle</label>
                                                                    <input type="text" name="sigle" class="form-control required" id="progress-basicpill-vatno-input" >
                                                                </div>
                                                            </div>                                  
                                                        </div>
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Type Entreprise</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Type Etablissement</label>
                                                                    <select id="secteur" name="type_etablissement" data-placeholder="Choisir le type d'établissement ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="Test">Principal</option>
                                                                            <option value="Test">Sécondaire</option>
                                                                            <option value="Test">Succursale</option>
                                                                    </select>
                                                                </div>                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Forme Juridique</label>
                                                                    <select id="secteur" name="forme_juridique" data-placeholder="Choisir la forme juridique ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="Test">SARL</option>
                                                                            <option value="Test">SA</option>
                                                                            <option value="Test">SNC</option>
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
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Chiffre d'affaire Prévisionnel (FCFA)</label>                                                                    
                                                                    <input type="text" name="chiffre_daffaire_previsionnel" class="form-control" id="progress-basicpill-cstno-input"> 
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
                                                                    <select id="secteur_activite" name="secteur_activite" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select>                                                                 
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Activité Principale (<font color="red">*</font>)</label>
                                                                        <select id="activite_principale" name="activite_principale" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                            <option></option>
                                                                                <option value="principal">Commerce de gros produits</option>
                                                                                <option value="secondaire">Fabrication de savon</option>  
                                                                                <option value="bureau">Services d'ingénierie</option>
                                                                        </select>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Objet Social (<font color="red">*</font>)</label>
                                                                    <textarea type="text" name="objet_social" class="form-control" data-placeholder="Saisir les activités que vous exercez" id="progress-basicpill-vatno-input" required></textarea>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Activités Sécondaires (<font color="red">*</font>)</label>
                                                                    <select id="activite_secondaire" name="activite_secondaire" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                            <option></option>
                                                                            <option value="principal">Principal</option>
                                                                            <option value="secondaire">Sécondaire</option>  
                                                                            <option value="bureau">Succursale</option>
                                                                    </select>                                                                   
                                                                </div>
                                                            </div>                                                           
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Capital</span></legend>
                                                        <div class="row">
                                                        
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Montant</label>
                                                                    <input type="text" name="montant_capital" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Dont Numéraire</label>
                                                                    <input type="text" name="dont_numeraire" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Dont Nature</label>
                                                                    <input type="text" name="dont_nature" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Montant Action ou Montant Part Social</label>
                                                                    <input type="text" name="montant_action" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                </div>
                                                            </div>  
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nombre d'Actions ou De Parts Sociales</label>
                                                                    <input type="text" name="nombre_action" class="form-control" id="progress-basicpill-vatno-input" required>
                                                                </div>
                                                            </div>                                    
                                                        </div>
                                                     </fieldset> <br>                                                     
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Employés</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Permanant</label>                                                                    
                                                                    <input type="text" name="employe_permanant" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Temporaire</label>                                                                    
                                                                    <input type="text" name="employe_temporaire" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Etranger</label>                                                                    
                                                                    <input type="text" name="employe_etranger" class="form-control" id="progress-basicpill-cstno-input"> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset><br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Dirigeant (s)</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Nom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Prenom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Fonction (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="fonction_personne_pouvant_engager" class="form-control" id="progress-basicpill-servicetax-input"> -->
                                                                    <select id="activite_secondaire" name="fonction_personne_pouvant_engager" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                            <option></option>
                                                                            <option value="principal">Président</option>
                                                                            <option value="secondaire">Directeur</option>  
                                                                            <option value="bureau">Secrétaire</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">% Capital (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Liste des Notaires</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Nom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Prenom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </fieldset> <br>
                                                     <fieldset>
                                                        <legend><span class="legend-fieldest">Liste des Commissaires aux comptes</span></legend>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Nom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Prenom (<font color="red">*</font>)</label>
                                                                    <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input">                                                                   
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
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="secteur_activite" data-placeholder="Choisir l'activité ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Province (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                            <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Commune ou Département (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Arrondissement</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">Secteur ou Village (<font color="red">*</font>)</label>
                                                                    <!-- <input type="text" name="cst" class="form-control" id="progress-basicpill-cstno-input"> -->
                                                                     <select id="secteur_activite" name="province_entreprise" data-placeholder="Choisir la province ..." class="form-control select2" style="width: 100%;" required >
                                                                        <option></option>
                                                                            <option value="principal">Commerce de gros produits</option>
                                                                            <option value="secondaire">Fabrication de savon</option>  
                                                                            <option value="bureau">Services d'ingénierie</option>
                                                                    </select> 
                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Mobile 1 (<font color="red">*</font>)</label>
                                                                    <input type="text" name="mobile_1" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Tel Bureau</label>
                                                                    <input type="text" name="tel_bureau" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Boite Postale</label>
                                                                    <input type="text" name="boite_postale" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Adresse</label>
                                                                    <input type="text" name="adresse" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">E-mail</label>
                                                                    <input type="text" name="boite_postale" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Site Web</label>
                                                                    <input type="text" name="site_web" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                            </div>
                                                            
                                
                                                     </fieldset> <br> 
                                                    <!-- </form> -->
                                                   
                                                  </div>
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
                                                                  <div class="mb-3" id="sign">
                                                                      <!-- <label class="form-label" for="progress-basicpill-namecard-input">Signez dans la case ci-dessous</label> -->
                                                                      <!-- <textarea name="signed" class="form-control" id="signature"></textarea> -->
                                                                      <button class="button-sign" id="clear">Clear Signature</button>
                                                                      <button class="button-sign" id="clear">Save</button>
                                                                      <!-- <textarea type="text" name="email" class="form-control" id="progress-basicpill-namecard-input" cols="30" rows="10"></textarea> -->
                                                                  </div>
                                                              </div>
                                                             
                                                          </div>
                                                      </fieldset><br>

                                                      <fieldset class="confirm">
                                                        <legend><span class="legend-fieldest">Confirmation</span></legend>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                        <input type="checkbox" id="switch4" switch="success" />
                                                                        <label for="switch4" data-on-label="On" data-off-label="Off"></label>

                                                                      <p>
                                                                        Je confirme certifie que les documents joints sont authentiques (absence de faux et usage de faux)
                                                                        et les déclarations sont sincères. Je m'engage à apporter la totalité des dossiers
                                                                        </p>
                                                                        <input type="checkbox" id="switch9" switch="dark" checked />
                                                                  </div>

                                                              </div>
                                                             
                                                          </div>
                                                      </fieldset>                                                          
                                                         
                                                    </div>
                                                </section>
                                                <h3>Confirmer</h3>
                                                <section class="tab-pane" id="progress-confirm-details">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                      </div>
                                                      <br>
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-6">
                                                            <div class="text-center">
                                                                <div class="mb-4">
                                                                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                                </div>
                                                                <div>
                                                                    <h5>Confirm Detail</h5>
                                                                    <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                                                </div>
                                                            </div>
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
                        
                    </div> <!-- container-fluid -->

                
@endsection
<div id='updatepiecejointe'class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Modifier une  piece jointe</h5>
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
                    <label class=" control-label" for="piece_contractuelle">Joindre la piece jointe<span class="text-success">*</span></label>
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
<div id='addpiecejointe'class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Enregistrer une nouvelle piece</h5>
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
                        <label class=" control-label" for="example-chosen">Type piece<span class="text-danger">*</span></label>
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
                        <label class=" control-label" for="example-chosen">Type piece <span class="text-danger">*</span></label>
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
                    <label class=" control-label" for="val_username">Numéro référence piece</label>
                        <div class="input-group" >
                            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                            <div class="input-group">
                                <input type="text" id="numero" name="numero_ref" value="{{old('lieu_etablissment')}}" class="form-control" placeholder="Lieu etablissement.." required>
                            </div>
                        </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label class=" control-label" for="val_username">Date d'établissement</label>
                        <div class="input-group" id="datepicker1">
                            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
                            <input type="text" name="date_detablissment" value="{{old('date_detablissment')}}" required class="form-control" placeholder="dd-mm-yyyy"
                             data-date-format="dd-mm-yyyy" data-date-container='#datepicker1' data-provide="datepicker">
                        </div>
                </div>
                <div class="form-group col-md-6">
                    <label class=" control-label" for="val_username">Lieu d'établissment</label>
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
                    <label class=" control-label" for="piece_contractuelle">Joindre la piece jointe<span class="text-success">*</span></label>
                    <input class="form-control" type="file" id='piece_jointe_1' name="piece_jointe" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de l'ordre de service" >  
                    
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

<!-- Pour script -->
@section('additionnel_script')
<script type="javascript/text" src="{{ asset('backend/loaddata.js') }}"></script>
<script>
    
$(document).ready(function() {
    var form = $("#contact");
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
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
});
});
</script>
<script type="javascript/text" src="{{ asset('backend/loaddata.js') }}"></script>
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
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
});
});
</script>
<script>
    var form = $("#progrss-wizar");
form.validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        confirm: {
            equalTo: "#password"
        }
    }
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
    function changer_demande(){
        if($('#formRadios2').is(':checked')||$('#formRadios3').is(':checked')){
            $('#progrss-wizar').hide();
            $('#progrss-wizar2').show();
        } 
       else if($('#formRadios1').is(':checked')){
            $('#progrss-wizar').show();
            $('#progrss-wizar2').hide();
        }
    }
    // Pour la signature
    var sign= $('#sign').signature({ syncField: '#signature', syncFormat:'PNG'});
    $('#clear').click(function(e){
        e.preventDefault();
        sign.signature('clear');
        $('#signature').val('');
    });
     $('.declaration').click(function(e){
        $('#fileUploadForm')[0].reset();
      $('.categorie_piece').val('declaration')
        //$('#type_piece_declaration').show();
        $('#type_piece_declaration').show();
       $('#type_piece_identite').hide();
     });
     $('#certificat_de_residence').click(function(e){
        $('#fileUploadForm')[0].reset();
        $('.categorie_piece').val('certificat_de_residence')
         $('.type_doc').val('certificat_de_residence')
         //console.log($('#type_doc').val());
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
    });
    $('#formulaire_dem_cpc').click(function(e){
        $('#fileUploadForm')[0].reset();
        $('.categorie_piece').val('formulaire_dem_cpc')
        $('.type_doc').val('formulaire_dem_cpc') 
        $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
    
    $('.piece_didentite').click(function(e){
        $('#fileUploadForm')[0].reset();
         $('.categorie_piece').val('piece_didentite')
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').show();

    });
     $('.titre_de_propriete').click(function(e){
        $('#fileUploadForm')[0].reset();
         $('.categorie_piece').val('titre_de_propriete')
         $('.type_doc').val('titre_de_propriete') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
    
     $('.photo_didentite').click(function(e){
        $('#fileUploadForm')[0].reset();
         $('.categorie_piece').val('photo_didentite');
         $('.type_doc').val('photo_didentite') 
        $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
    
     $('.formulaire_dem_cpc').click(function(e){
        $('#fileUploadForm')[0].reset();
         $('.categorie_piece').val('formulaire_dem_cpc')
         $('.type_doc').val('formulaire_dem_cpc') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
     $('.formulaire_rccm').click(function(e){
        $('#fileUploadForm')[0].reset();
         $('.categorie_piece').val('formulaire_rccm');
         $('.type_doc').val('formulaire_rccm');
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
     $('.statut').click(function(e){
        $('#fileUploadForm')[0].reset();
         $('.categorie_piece').val('statut')
         $('.type_doc').val('statut') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
     $('.acte_de_depot').click(function(e){
        $('#fileUploadForm')[0].reset();
         $('.categorie_piece').val('acte_de_depot')
         $('.type_doc').val('acte_de_depot') 
         $('#type_piece_declaration').hide();
        $('#type_piece_identite').hide();
     });
    $(document).ready(function(){
        $('#type_piece_declaration').hide();
         $('#type_piece_identite').hide();
         $('#type_piece_declaration').hide();
         $('#type_piece_didentite').hide();

     });
    
</script>
<script>
      
</script>

@endsection