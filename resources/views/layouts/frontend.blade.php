@include('partials.frontend.header')
<div>
        @yield('content')
</div>
        <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        
        <div class="modal-header">
 
        <center><h3 class="modal-title text-center" style="margin-left: 130px" id="modal-login-label">  Connexion <i class="fa fa-key"></i></h3></center>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
          
            <div class="col-md-5 login-left">
                  <img src="{{ 'assets/img/user.png' }}" alt="" style="margin-bottom: 50px" width="150" height="150">
                  <!-- <a  class="btn btn-danger"data-dismiss="modal"  href="#modal-create-compte" data-toggle="modal" style="background-color:rgb(224, 106, 106)"> Creer compte <i class="fa fa-unlock"></i></a> -->

            </div>
              <div class="col-md-7">
          

              <form role="form" action="{{ route('login') }}" method="post" class="login-form">
                  @csrf
                  <div class="form-group">
                    <label class="sr-only" for="form-password">Email</label>
                    <input id="email" placeholder="Entrez Votre Email"class="form-control input-lg" type="email" name="email" :value="old('email')" required autofocus />


                  </div>
                    <div class="form-group">
                      <label class="sr-only" for="form-password">Mot de passe</label>
                      <input id="password" placeholder="Entrez Votre Mot de passe" class="form-control input-lg" type="password" name="password" required autocomplete="current-password" />
                    </div>
                    <div class="col-xs-4">
                      <label class="switch switch-primary" data-toggle="tooltip" title="Remember Me?">
                          <input type="checkbox" id="login-remember-me" name="login-remember-me" checked>
                          <span>Se souvenir de moi</span>
                      </label>
                  </div>
                  <div class="col-xs-6">
                  <a  class="" data-dismiss="modal"  href="#modal-forget-password" data-toggle="modal"> Mot de passe oublié ?</a>

                  </div>
                    <button type="submit" class="btn btn-success">Se Connecter <i class="fa fa-unlock"></i></button>
                    </a>
                </form>   
              </div>
          </div>
          
                
        </div>
        
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-forget-password" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
 
        <center><h3 class="modal-title text-center" id="modal-login-label">  Récupérer le mot de passe <i class="fa fa-key"></i></h3></center>

          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
          
                <form role="form"  method="POST" action="{{ url('/reset_password_without_token') }}" method="post" class="login-form">
                  @csrf
                  <div class="form-group">
                  <label class="control-label login-label" for="val_username">Email:HJ <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="email" placeholder="Entrez email" class="form-control input-lg" type="email" name="email" required autocomplete="current-password" />
                      </div>
                  </div>
                    
                    <button type="submit" class="btn btn-success">Valider <i class="fa fa-unlock"></i></button>
                    </a>
                </form>   
              </div>
          </div>
          
                
        </div>
        
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-verifier-nomCommercial" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        
        <div class="modal-header">
          <h3 class="text-center" style="margin-left: 200px" id="modal-login-label"> Vérification de nom commercial <i class="fa fa-key"></i></h3>
            
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
            
            <div class="col-md-10 form-login">
            <form role="form" class="login-form">
                @csrf
                <div class="form-group" >
                  <label class="control-label login-label" for="val_username">Entrez le nom commercial: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="nom_commercial" placeholder="Entrez le nom commercial" class="form-control input-lg" type="text" name="name" required />
                      </div>
              </div>
                  <p id='pNomdisponible' style="color:green; display:none"> Ce Nom commercial est disponible</p>
                  <p id='pNomindisponible' style="color:red; display:none"> Ce Nom commercial n'est pas disponible</p>
                <div class="text-center">
                  <input type="reset" class="btn btn-danger"  value="Annuler">
                  <input   class="btn btn-success"  value="Valider" onclick="verifier_nom_commercial('nom_commercial');">
                </div>
                        
                  </a>
              </form> 
            </div>
                 
              </div>
      
          
                
        </div>
        
      </div>
    </div>
</div>
  <div class="modal fade" id="modal-create-compte" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        
        <div class="modal-header">
          <h3 class="text-center" style="margin-left: 250px" id="modal-login-label">  Créer un compte <i class="fa fa-key"></i></h3>
            
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <img src="{{ 'assets/img/user.png' }}" alt="" width="150" height="150">
            </div>
            <div class="col-md-9 form-login">
            <form role="form" action="{{ route('register') }}" method="post" class="login-form">
                @csrf
                <div class="form-group" >
                  <label class="control-label login-label" for="val_username">Nom Complet: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="name" placeholder="Entrez Votre nom complet" class="form-control input-lg" type="text" name="name" required autocomplete="current-password" />
                      </div>
              </div>
                <div class="form-group">
                  <label class="control-label login-label" for="val_username">Email: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="email_cc" placeholder="Entrez email" class="form-control input-lg" type="email" name="email" required autocomplete="current-password" onchange="email_existe()"/>
                      </div>
                      <p style="background-color: red; display:none" id='email_existe'>Adresse email déjà utilisée!! </p>
              </div>
                <div class="form-group">
                  <label class="control-label login-label" for="val_username">Mot de passe: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="password" placeholder="Entrez Votre Mot de passe" class="form-control input-lg password" type="password" name="password" onchange="verifier_password();" required autocomplete="current-password" />
                      </div>
                      <p style="background-color: red; display:none" id='mot_de_passe'>Le mot de passe doit contenir au moins 8 caractères </p>
              </div>
              <div class="form-group">
                <label class="control-label login-label" for="val_username">Retaper le mot de passe: <span class="text-danger">*</span></label>
                    <div class="input-group">
                    <input id="password" placeholder="Retaper le même Mot de passe" class="form-control input-lg" type="password" name="password_confirmation" required autocomplete="current-password" />
                    </div>
              </div>
                <div class="text-center">
                  <input type="reset" class="btn btn-danger"  value="Annuler">
                  <input type="submit"   class="btn btn-success"  value="Enregister">
                </div>
                        
                  </a>
              </form> 
            </div>
                 
              </div>
      
          
                
        </div>
        
      </div>
    </div>
</div>

<div class="modal fade" id="kkmodal-create-compte" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        
        <div class="modal-header">
          <h3 class="modal-title text-center" id="modal-login-label">  Créer un compte <i class="fa fa-key"></i></h3>
            
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <img src="{{ 'assets/img/user.jpg' }}" alt="" width="110%" height="100%">
            </div>
            <div class="col-md-9">
              <form role="form" action="{{ route('register') }}" method="post" class="login-form">
                @csrf
                <div class="form-group">
                  <label class="control-label login-label" for="val_username">Nom Complet: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="name" placeholder="Entrez Votre nom complet" class="form-control input-lg" type="text" name="name" required autocomplete="current-password" />
                      </div>
              </div>
                <div class="form-group">
                  <label class="control-label login-label" for="val_username">Email: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="email" placeholder="Entrez email" class="form-control input-lg" type="email" name="email" required autocomplete="current-password" />
                      </div>
              </div>
                <div class="form-group">
                  <label class="control-label login-label" for="val_username">Mot de passe: <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input id="password" placeholder="Entrez Votre Mot de passe" class="form-control input-lg" type="password" name="password" required autocomplete="current-password" />
                      </div>
              </div>
              <div class="form-group">
                <label class="control-label login-label" for="val_username">Retaper le mot de passe: <span class="text-danger">*</span></label>
                    <div class="input-group">
                    <input id="password" placeholder="Retaper le même Mot de passe" class="form-control input-lg" type="password" name="password_confirmation" required autocomplete="current-password" />
                    </div>
              </div>
                <div class="panel-footer text-center">
                  <input type="reset" class="btn btn-md btn-warning"  value="Annuler">
                  <input type="submit"   class="btn btn-md btn-success"  value="Enregister">
                </div>
                        
                  </a>
              </form> 
            </div>
                 
              </div>
      
          
                
        </div>
        
      </div>
    </div>
</div>
@yield('modal_parpage')
@include('partials.frontend.footer') 
