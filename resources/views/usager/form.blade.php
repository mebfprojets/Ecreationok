@extends('layouts.frontend')
@section('content')
<div class="container" style="">
    <div class="alert-warning">
        <p>Les champs en étoile rouge <span style="color: red">(*)</span> sont obligatoires</p>
    </div>
    <div class="content-form">
        <form role="form" action="{{ route('login') }}" method="post" class="form-horizontal form-bordered">
            @csrf
    <div class="block-style">
                <div class="panel-heading">
                    <p> Mon Identité </legend>
                </div>
             
        <div class="row">
           
            <div class="col-md-6">

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
       
            </div>
            <div class="col-md-6">
               
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
                    <label class=" control-label" for="example-chosen">Situation Matrimoniale<span class="text-danger">*</span></label>

                        <select id="situation_matrimoniale" name="situation_matrimoniale" class="select-select2" data-placeholder="Choisir le situation matrimoniale" style="width: 100%;" required="Ce champ est obligatoire" title="Ce champ est obligatoire">
                            <option></option>
                            <option value="1" {{ old('situation_matrimoniale') == 1 ? 'selected' : '' }}>Celibataire</option>
                            <option value="2" {{ old('situation_matrimoniale') == 2 ? 'selected' : '' }}>Marié</option>
                            <option value="3" {{ old('situation_matrimoniale') == 3 ? 'selected' : '' }}>Divorcé</option>
                        </select>

                </div>
          
            </div>
        
        </div>
</div>

<div class="block-style">
            <div class="panel-heading">
                <p> Mon Adresse </legend>
            </div>
            
        <div class="row">

            <div class="col-lg-6">
                <div class="form-group select-list">
                    <label class=" control-label" for="example-chosen">Pays/Nationalité<span class="text-danger">*</span></label>
                        <select id="" name="nationalite_usager" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required onchange="changeValue('region_usager', 'province_usager', 'provinces','region_usager');">
                            <option></option>
                            @foreach ($regions as $region )
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                            
                        </select>
                </div>
                    <div class="form-group select-list">
                        <label class=" control-label" for="example-chosen">Region<span class="text-danger">*</span></label>
                            <select id="region_usager" name="region_usager" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required onchange="changeValue('region_usager', 'province_usager', 'provinces','region_usager');">
                                <option></option>
                                @foreach ($regions as $region )
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                                
                            </select>

            </div>
                    <div class="form-group select-list">
                        <label class=" control-label" for="example-chosen">Province<span class="text-danger">*</span></label>
                            <select id="province_usager" name="province_usager" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required  onchange="changeValue('province_usager', 'commune_usager', 'communes','region_usager');">
                                <option></option>
                               
                            </select>

                    </div>
                    <div class="form-group select-list">
                        <label class=" control-label" for="example-chosen">Commune<span class="text-danger">*</span></label>
                            <select id="commune_usager" name="commune_usager" data-placeholder="Choisir la commune de l'usager" class="select-select2" style="width: 100%;" required  onchange="changeValue('commune_usager', 'arrondissement_usager', 'arrondissements','province_usager');">
                                <option></option>
                            </select>

                    </div>
                    <div class="form-group select-list">
                        <label class=" control-label" for="example-chosen">Arrondissement<span class="text-danger">*</span></label>
                            <select id="arrondissement_usager" name="type_identite_promoteur" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required onchange="changeValue('arrondissement_usager', 'secteur_usager', 'secteur_villages','commune_usager');">
                                <option> -- Selectionner --</option>
                            </select>
                    </div>
                    <div class="form-group select-list">
                        <label class=" control-label" for="example-chosen"> Secteur/Village<span class="text-danger">*</span></label>
                            <select id="secteur_usager" name="secteur_usager" data-placeholder="Choisir type identite" class="select-select2" style="width: 100%;" required >
                                <option> -- Selectionner --</option>
                            </select>
                    </div>
             </div>
                <div class=" col-lg-6">
                    <div class="form-group">
                        <label class=" control-label" for="">Boite Postale <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="boite_postale" name="boite_postale" value="{{old('boite_postale')}}" class="form-control" placeholder="numéro.." required>
                        </div>
                        @if ($errors->has('boite_postale'))
                            <span class="help-block text-danger">
                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="">Telephone Mobile 1 <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="telephone_mobile1" name="telephone_mobile1" value="{{old('telephone_mobile1')}}" class="form-control" placeholder="numéro.." required>
                        </div>
                        @if ($errors->has('telephone_mobile1'))
                            <span class="help-block text-danger">
                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="">Telephone Bureau <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="telephone_bureau" name="telephone_bureau" value="{{old('telephone_bureau')}}" class="form-control" placeholder="numéro.." required>
                        </div>
                        @if ($errors->has('telephone_bureau'))
                            <span class="help-block text-danger">
                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="">Adresse <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="adresse" name="adresse" value="{{old('adresse')}}" class="form-control" placeholder="numéro.." required>
                        </div>
                        @if ($errors->has('adresse'))
                            <span class="help-block text-danger">
                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class=" control-label" for="">Téléphone Mobile 2 <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="telephone_mobile_2" name="telephone_mobile_2" value="{{old('telephone_mobile_2')}}" class="form-control" placeholder="numéro.." required>
                        </div>
                        @if ($errors->has('telephone_mobile_2'))
                            <span class="help-block text-danger">
                                <strong>Une personne a déja été enregistrée avec ce numéro d'identité</strong>
                            </span>
                        @endif
                    </div>
                </div>
        </div>
</div>
            <div class="panel-footer text-center">
                        <input type="reset" class="btn btn-sm btn-warning"  value="Annuler">
                        <input type="submit"   class="btn btn-sm btn-success"  value="Enregister mes données">
            </div>
        </form>
    
</div>     
</div>       
@endsection