@extends("backend.adminlte.home")
{{-- @section('administration', 'active')
@section('administration-user', 'active') --}}
{{-- @section('blank')
    <li>Accueil</li>
    <li>Utilisateurs</li>
    <li><a href="">Creer</a></li>
@endsection --}}
@section('content')
<div class="container">
    <div class="row">
                <div class="card card-success col-md-12 col-md-offset-2">
                    <div class="card-header">
                      <h3 class="card-title">Créer un utilisateur</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-validation" method="POST"  action="{{route('user.store')}}" class="form-horizontal form-bordered">
                            {{ csrf_field() }}
                        <fieldset>
                            <legend><i class="fa fa-angle-right"></i> Informations personnelles</legend>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="val_username">Nom<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                            <input id="nome" type="text" class="form-control" name="nom" value="{{ old('nom') }}" required autofocus>
                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    </div>
                                    @if ($errors->has('nom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('prename') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="prenom">Prenom <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                                <input id="prenom" type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required autofocus>
                                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                        </div>
                                        @if ($errors->has('prenom'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('prenom') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                            </div>
                             <div class="form-group{{ $errors->has('organisation') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="organisation">Cefore </label>
                                    <div class="col-md-6">
                                            <div class=" col-md-12 input-group ">
                                                <select  id="organisation" name="organisation" class="form-control">
                                                <option value="">Sélectionner une zone</option>
                                                    <option value="001000">Central</option>
                                                        @foreach ($organisations as $organisation)
                                                            <option value="{!!old('organisation') ?? $organisation->id!!}">{{ $organisation->libelle}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                            </div>
                                                @if ($errors->has('organisation'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('organisation') }}</strong>
                                                </span>
                                                @endif
    
                                    </div>
                                </div>
                           
                            
                                
                               
                            <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="masked_phone">Telephone<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" id="masked_phone" name="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="(+226) 99-99-99-99" required autofocus>
                                            <span class="input-group-addon"><i class="gi gi-earphone"></i></span>
                                        </div>
                                    </div>
                                    @if ($errors->has('telephone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="email">Email <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                        <div class="input-group">
                                                <input id="email" name="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="test@example.com">
                                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                        </div>
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div>
    
                        </fieldset>
                        <fieldset>
                            <legend><i class="fa fa-angle-right"></i> Roles</legend>
    
                            <div class="form-group">
                                @foreach ($roles as $role)
                                    <div class="col-lg-3 checkbox">
                                       <label><input type="checkbox" name='roles[]' value="{{ $role->id }}"> {{ $role->nom }}</label>
                                    </div>
                                @endforeach
                            </div>
    
                        </fieldset>
                        <div class="form-group form-actions">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Submit</button>
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                            </div>
                        </div>
    
                    </form>
                    </div>
                    <!-- /.card-body -->
                  </div>
                
                <!-- END Form Validation Example Content -->

    </div>
</div>
@endsection
