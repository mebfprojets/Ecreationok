@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="content-form">
        <form role="form" action="{{ route('login') }}" method="post" class="form-horizontal form-bordered">
            @csrf
        <div class="row">

            <div class="col-md-6">
                <fieldset>
                    <legend>Informations sur le compte</legend>
                <div class="form-group">
                    <label class="control-label" for="val_username">Email (s) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Renseignez l'email" required="Ce champ est obligatoire" >
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="val_username">Mot de passe <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Entrez le mot de passe" required="Ce champ est obligatoire" >
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="val_username">Confirmez Mot de passe <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Retapper le même le mot de passe" required="Ce champ est obligatoire" >
                        </div>
                </div>
            </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset>
                    <legend>Informations générales</legend>
                <div class="form-group">
                    <label class="control-label" for="val_username">Email (s) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Entrez le prenom.." required="Ce champ est obligatoire" >
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="val_username">Mot de passe <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Entrez le mot de passe" required="Ce champ est obligatoire" >
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="val_username">Confirmez Mot de passe <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" id="prenom_promoteur" name="prenom_promoteur" class="form-control" value="{{old('prenom_promoteur')}}"placeholder="Entrez le mot de passe" required="Ce champ est obligatoire" >
                        </div>
                </div>
            </fieldset>
            </div>

        </div>
        <hr>
        <fieldset>
            <legend>Informations générales sur l'usager</legend>
            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class=" control-label" for="example-chosen">Civilité<span class="text-danger">*</span></label>

                            <select id="single-select-field" name="civilite" class="select-select2"  data-placeholder="Selectionnez la civilité" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                <option></option>
                                <option value="1" {{ old('civilite') == 1 ? 'selected' : '' }}>Monsieur</option>
                                <option value="2" {{ old('civilite') == 1 ? 'selected' : '' }}>Madame</option>
                                <option value="3" {{ old('civilite') == 2 ? 'selected' : '' }}>Mademoiselle</option>
                            </select>

                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="nom_promoteur">Nom <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="nom" name="nom" class="form-control" style="width: 100%;" value="{{old('nom')}}" onchange="this.value = this.value.toUpperCase()" placeholder="Entrez votre nom" title="Ce champ est obligatoire" required >
                                            @if ($errors->has('nom'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('nom') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="val_username">Prénom (s) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="prenom" name="prenom" class="form-control" value="{{old('prenom')}}"placeholder="Entrez le prenom.." required="Ce champ est obligatoire" onchange="this.value = this.value.charAt(0).toUpperCase()+ this.value.substr(1);">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class=" control-label" for="example-chosen">Genre<span class="text-danger">*</span></label>

                                        <select id="genre" name="genre" class="select-select2" data-placeholder="Choisir le genre" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                            <option></option>
                                            <option value="1" {{ old('genre') == 1 ? 'selected' : '' }}>Féminin</option>
                                            <option value="2" {{ old('genre') == 2 ? 'selected' : '' }}>Masculin</option>
                                        </select>

                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="val_username">Profession: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="profession" name="profession" class="form-control" value="{{old('profession')}}"placeholder="Entrez la profession.." required="Ce champ est obligatoire">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="val_username">Date de naissance<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="date_de_naissance" name="date_de_naissance" value="{{old('date_de_naissance')}}" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Entrer votre date de naissance.." required="Ce champ est obligatoire">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="val_username">Lieu de naissance: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="profession" name="profession" class="form-control" value="{{old('profession')}}"placeholder="Entrez la profession.." required="Ce champ est obligatoire">
                                        </div>
                                </div>

                                <div class="form-group">
                                    <label class=" control-label" for="example-chosen">Situation Matrimoniale<span class="text-danger">*</span></label>

                                        <select id="situation_matrimoniale" name="situation_matrimoniale" class="select-select2" data-placeholder="Choisir le situation matrimoniale" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                                            <option></option>
                                            <option value="1" {{ old('situation_matrimoniale') == 1 ? 'selected' : '' }}>Celibataire</option>
                                            <option value="2" {{ old('situation_matrimoniale') == 2 ? 'selected' : '' }}>Marié</option>
                                            <option value="3" {{ old('situation_matrimoniale') == 3 ? 'selected' : '' }}>Divorcé</option>
                                        </select>

                                </div>
                               
                                
            
                          </div>
                            <div class=" col-lg-6">
                                    
                                        <div class="form-group select-list">
                                            <label class=" control-label" for="example-chosen">Region<span class="text-danger">*</span></label>
                                                <select id="region_usager" name="region_usager" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required>
                                                    <option></option>
                                                    <option value="1" {{ old('region_usager') == 1 ? 'selected' : '' }} >CNIB</option>
                                                    <option value="2" {{ old('region_usager') == 2 ? 'selected' : '' }}>Passeport</option>
                                                </select>

                                        </div>
                                        <div class="form-group select-list">
                                            <label class=" control-label" for="example-chosen">Province<span class="text-danger">*</span></label>
                                                <select id="province_usager" name="province_usager" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required  onchange="changeValue('region_usager', 'province_usager', 'provinces';">
                                                    <option></option>
                                                   
                                                </select>

                                        </div>
                                        <div class="form-group select-list">
                                            <label class=" control-label" for="example-chosen">Commune<span class="text-danger">*</span></label>
                                                <select id="type_identite_promoteur" name="type_identite_promoteur" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required>
                                                    <option></option>
                                                    <option value="1" {{ old('type_identite_promoteur') == 1 ? 'selected' : '' }} >CNIB</option>
                                                    <option value="2" {{ old('type_identite_promoteur') == 2 ? 'selected' : '' }}>Passeport</option>
                                                </select>

                                        </div>
                                        <div class="form-group select-list">
                                            <label class=" control-label" for="example-chosen">Arrondissement<span class="text-danger">*</span></label>
                                                <select id="type_identite_promoteur" name="type_identite_promoteur" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required>
                                                    <option></option>
                                                    <option value="1" {{ old('type_identite_promoteur') == 1 ? 'selected' : '' }} >CNIB</option>
                                                    <option value="2" {{ old('type_identite_promoteur') == 2 ? 'selected' : '' }}>Passeport</option>
                                                </select>

                                        </div>
                                    
                                            <div class="form-group select-list">
                                                <label class=" control-label" for="example-chosen">Secteur/village<span class="text-danger">*</span></label>
                                                    <select id="type_identite_promoteur" name="type_identite_promoteur" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required>
                                                        <option></option>
                                                        <option value="1" {{ old('type_identite_promoteur') == 1 ? 'selected' : '' }} >CNIB</option>
                                                        <option value="2" {{ old('type_identite_promoteur') == 2 ? 'selected' : '' }}>Passeport</option>
                                                    </select>

                                            </div>
                                        
                                        
                                            <div class="form-group">
                                                <label class=" control-label" for="">Numéro <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" id="numero_identite" name="numero_identite" value="{{old('numero_identite')}}" class="form-control" placeholder="numéro.." required>
                                                </div>
                                                @if ($errors->has('numero_identite'))
                                                    <span class="help-block text-danger">
                                                        <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                                                    </span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="">Date d'établissement <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="date_identification" value="{{old('date_identification')}}" name="date_identification" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="mm/dd/yy"required>
                                        </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('docidentite') ? ' has-error' : '' }}">
                                            <label class=" control-label" for="docidentite">Joindre une copie<span class="text-danger">*</span></label>
                                                <input class="form-control" type="file" name="docidentite" id="docidentite" accept=".pdf, .jpeg, .png"   onchange="VerifyUploadSizeIsOK('docidentite');"  placeholder="Charger une copie du document d'identification" required>
                                            @if ($errors->has('docidentite'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('docidentite') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                        
                    
                </div>
                </fieldset>
            <div class="panel-footer text-center">
                        <input type="reset" class="btn btn-sm btn-warning"  value="Annuler">
                        <i class="fa fa-check-square-o"></i> <input type="submit"   class="btn btn-sm btn-success"  value="Enregister">
            </div>
        </form>
    </div>
       
</div>       
@endsection