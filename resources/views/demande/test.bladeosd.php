@extends('layouts.frontend')

@section('content')

<form id="contact1" action="#">
    <div>
        <h3 > <span class="step-title">Account </span></h3>
        <section>
            <label for="userName">User name *</label>
            <input id="userName" name="userName" type="text" class="required">
            <label for="password">Password *</label>
            <input id="password" name="password" type="text" class="required">
            <label for="confirm">Confirm Password *</label>
            <input id="confirm" name="confirm" type="text" class="required">
            <p>(*) Mandatory</p>
        </section>
        <h3>Profile</h3>
        <section>
            <label for="name">First name *</label>
            <input id="name" name="name" type="text" class="required">
            <label for="surname">Last name *</label>
            <input id="surname" name="surname" type="text" class="required">
            <label for="email">Email *</label>
            <input id="email" name="email" type="text" class="required email">
            <label for="address">Address</label>
            <input id="address" name="address" type="text">
            <p>(*) Mandatory</p>
        </section>
        <h3>Hints</h3>
        <section>
            <ul>
                <li>Foo</li>
                <li>Bar</li>
                <li>Foobar</li>
            </ul>
        </section>
        <h3>Finish</h3>
        <section>
            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
        </section>
    </div>
</form>


                
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

<script>


    var form = $("#contact1");
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

</script>
<script type="javascript/text" src="{{ asset('backend/loaddata.js') }}"></script>
<script>
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