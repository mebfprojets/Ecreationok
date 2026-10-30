<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<!-- 
THEME: Constra - Construction Html5 Template
VERSION: 1.0.0
AUTHOR: Themefisher

HOMEPAGE: https://themefisher.com/products/constra-construction-template/
DEMO: https://demo.themefisher.com/constra/
GITHUB: https://github.com/themefisher/Constra-Bootstrap-Construction-Template

WEBSITE: https://themefisher.com
TWITTER: https://twitter.com/themefisher
FACEBOOK: https://www.facebook.com/themefisher
-->

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
================================================== -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>CEFORE</title>

  <!-- Mobile Specific Metas
================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name=author content="Themefisher">
  <meta name=generator content="Themefisher Constra HTML Template v1.0">

  <!-- Favicon
================================================== -->
  <!-- <link rel="icon" type="image/png" href="{{ asset('frontend/images/MEBF-CEFORE.JPG') }}"> -->
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/images/logo_cefore.ico')}}">

  <!-- CSS
================================================== -->

<!-- Styles -->


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" integrity="sha384-KZO2FRYNmIHerhfYMjCIUaJeGBRXP7CN24SiNSG+wdDzgwvxWbl16wMVtWiJTcMt" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" integrity="sha384-IrMr0LFnIMa9H6HhC5VVqVuWNEIwspnRLKQc0SUyPj4Cy4s02DiWDZEoJOo5WNK6" crossorigin="anonymous" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" integrity="sha384-dHmYdBULIlN1UT/7MFm1UJxGu3C9ZSlZsdfWUpvgCU1wIvwTX2vzDO45ndkHLFgS" crossorigin="anonymous" />
<!-- Scripts -->
<script src="{{ asset('frontend/plugins/jQuery/jquery.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js" integrity="sha384-HCjW0//bc6Gu9bS3OISjenLhzVqjRipLVVj9LZtzKu+FYXXOZVCN7WDv2TYxCfmo" crossorigin="anonymous"></script>

  <!-- Bootstrap : feuille unique backend/css/bootstrap.min.css (v5, thème) chargée plus bas -->
  <!-- FontAwesome -->
  <link rel="stylesheet" href="{{asset('frontend/plugins/fontawesome/css/all.min.css')}}">
  <!-- Animation -->
  <link rel="stylesheet" href="{{asset('frontend/plugins/animate-css/animate.css')}}">
  <!-- slick Carousel -->

  <link rel="stylesheet" href="{{asset('frontend/plugins/slick/slick.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/plugins/slick/slick-theme.css')}}">
  <!-- Colorbox -->
  <link rel="stylesheet" href="{{asset('frontend/plugins/colorbox/colorbox.css')}}">
  <!-- Template styles-->



  <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->

 
  
<!-- Pour test de formulaire demande -->
<link href="{{asset('backend/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">

<!-- <link rel="shortcut icon" href="{{asset('backend/images/favicon.ico')}}"> -->
<link rel="stylesheet" href="{{asset('backend/libs/twitter-bootstrap-wizard/prettify.css')}}">
<!-- fais chnger la couleur de vérifier nomcommercial -->
<!-- Bon endroit -->
        <link href="{{asset('backend/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('backend/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{asset('backend/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" /> 
<link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

<!-- Pour accueil pour raison de position -->
<link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
<link rel="stylesheet" href="{{asset('/css/jquery.steps.css')}}">

  <!--  -->
<link rel="stylesheet" href="{{asset('vendor/fontawesome-free-5.15.4/css/all.min.css')}}"> 


<!-- Pour la signature -->
<link rel="stylesheet" href="{{asset('backend/css/signature.css')}}"> 
<style>
  .custom-alert {
        background-color: green;
        color: white;
        width: 40%;
        text-align: center;
        padding: 5px;
        border-radius: 10px;
        margin: 5px 0;
    }
    .custom-rouge {
        background-color: red;
        color: white;
        width: 40%;
        text-align: center;
        padding: 5px;
        border-radius: 10px;
        margin: 5px 0;
    }
    /* .uppercase {
    text-transform: uppercase;
} */
</style>
<style>
                
         .inline-warning {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .warning-icon {
            flex-shrink: 0;
            color: #d32f2f;
            font-size: 20px;
            margin-right: 20px;
            background-color: #ffebee;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .warning-content {
            flex-grow: 1;
        }
        
        .warning-content h3 {
            color: #d32f2f;
            margin-bottom: 8px;
            font-size: 20px;
        }
        
        .warning-content p {
            color: #856404;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .warning-note {
            background-color: #fff;
            padding: 12px 15px;
            border-radius: 6px;
            border-left: 4px solid #4caf50;
            margin-top: 12px;
            font-size: 14px;
        }
    </style>
    <!-- <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> -->
</head>
<body @auth data-inactivite-minutes="{{ Auth::user()->isadmin != null ? config('session.inactivite_agents', 30) : config('session.lifetime', 120) }}" @endauth>
  
    <!--/ Topbar end -->
<!-- Header start -->
<header id="header" style="margin-top: -30px" class="header-one">
  <div class="bg-white">
    <div class="container">
      <div class="logo-area">
          <div class="row align-items-center">
            <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                <a class="d-block" href="{{ route('index') }}">
                  <img loading="lazy" style="height: 80px;" src="{{ asset('frontend/images/MEBF-CEFORE.JPG') }}" alt="CEFORE">
                </a>
            </div><!-- logo end -->
  
            <div class="col-lg-9 header-right">
                <ul class="top-info-box">
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">Contacts</p>
                          <p class="info-box-subtitle">(+226) 02 21 21 21 - 58 80 77 77 - 56 62 02 02</p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">E-mail</p>
                          <p class="info-box-subtitle"><a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#105;&#110;&#102;&#111;&#64;&#109;&#101;&#46;&#98;&#102;">&#105;&#110;&#102;&#111;&#64;&#109;&#101;&#46;&#98;&#102;</a></p>
                      </div>
                    </div>
                  </li>                  
                  <li class="header-get-a-quote">
                    <a class="btn btn-primary" data-bs-toggle="modal" href="#modal-verifier-nomCommercial">Vérifier un nom commerical</a>
                  </li>
                </ul><!-- Ul end -->
            </div><!-- header right end -->
          </div><!-- logo area end -->

          
          <!-- <center><h3 style="color:#FFF; background:#FF0000;">EN RAISON DE LA MAUVAISE QUALITE DE LA CONNEXION INTERNET,
              LA PLATEFORME EST TEMPORAIREMENT SUSPENDUE JUSQU'A NOUVEL ORDRE.          
          </h3>
          </center> -->
      </div><!-- Row end -->

      <div class="page-container">
        <!-- Message d'avertissement en ligne -->
        @if(config('app.maintenance_banner'))
<div class="alerte-maintenance" role="alert">
  <div class="container">
    <i class="fas fa-tools"></i>
    <strong>Maintenance en cours :</strong>
    des perturbations peuvent survenir. Merci de votre compréhension.
  </div>
</div>
<style>
  .alerte-maintenance {
      background: #fff3cd;
      color: #664d03;
      border-bottom: 2px solid #ffc107;
      padding: 12px 0;
      text-align: center;
      font-size: 16px;
  }
  .alerte-maintenance i {
      margin-right: 8px;
  }
</style>
@endif


    </div><!-- Container end -->
  </div>

  <div class="site-navigation">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
              <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div id="navbar-collapse" class="collapse navbar-collapse contenant">
                    <ul class="nav navbar-nav mr-auto">                     
                      <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Accueil</a></li>
                      @auth
                        @if (Auth::user()->isadmin != null)
                          {{-- Agents : accès direct à l'espace agents (tableau de bord, ou administration pour un compte sans accès aux demandes) --}}
                          @php $lienEspaceAgents = Auth::user()->can('lister.demande') || !Auth::user()->can('user.create') ? route('dashboard') : route('user.index'); @endphp
                          <li class="nav-item">
                            <a class="nav-link fw-bold px-3" href="{{ $lienEspaceAgents }}" style="background:#0b9e44; border-radius:4px;" title="Espace agents">
                              <i class="fas fa-tachometer-alt me-1" aria-hidden="true"></i>Tableau de bord
                            </a>
                          </li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ route('create.usager') }}">Créer une demande</a></li>
                        @if(nbr_demande()>0)
                        <li class="nav-item"><a class="nav-link" href="{{route('demande.liste')}}">Mes demandes</a></li>
                        @endif
                      @endauth
                      <li class="nav-item"><a class="nav-link" target="_blank" href="http://me.bf/fr/annonces-legales">Annonces Légales</a></li>
                      
                      <li class="nav-item"><a class="nav-link" href="#">Contacts</a></li>
        @guest
          <li id="contenu" class="nav-item dropdown pull-right">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">MON COMPTE</a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right dropdown-menu-end">

                <li class="divider"></li>
                <li>
                    <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                    <a href="#modal-login" data-bs-toggle="modal">
                      <i class="fa fa-sign-in"></i>
                       Se Connecter
                    </a>
                </li>
                <li class="divider"></li>
                {{-- <li>
                    <a href="page_ready_lock_screen.html"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a>
                </li> --}}
                <li>
                  <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                 <a href="#modal-create-compte" data-bs-toggle="modal">
                    <i class="fa fa-user"></i>
                     Créer un compte
                  </a> 
              </li> 
            </ul>
        </li>
       @else 
       <li id="contenu" class="nav-item dropdown pull-right">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{Auth::user()->name}}</a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right dropdown-menu-end">

                <li class="divider"></li>
                <li>
                    <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                    <!-- <a href="#modal-user-settings" data-bs-toggle="modal">
                        <i class="fa fa-cog fa-fw pull-right"></i>
                        Profil utilisateur
                    </a> -->
                </li>
                <li class="divider"></li>
                {{-- <li>
                    <a href="page_ready_lock_screen.html"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a>
                </li> --}}
                @if (Auth::user()->isadmin != null)
                  <li>
                    <a href="{{ $lienEspaceAgents }}"><i class="fas fa-tachometer-alt fa-fw pull-right" aria-hidden="true"></i> Tableau de bord</a>
                  </li>
                @endif
              <li>
                    <a href="{{ route('logout') }}"
                    data-csp-click="__deconnexion"><i class="fa fa-ban fa-fw pull-right"></i>
                    Se Deconnecter
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
            </li>
            </ul>
        </li>
        @endguest
        <!-- END User Dropdown -->
    </ul>
                      </li>
                      
                    </ul>

                </div>
              </nav>
          </div>
          <!--/ Col end -->
        </div>
        <!--/ Row end -->

        {{-- <div class="nav-search">
          <span id="search"><i class="fa fa-search"></i></span>
        </div><!-- Search end --> --}}

        <div class="search-block" style="display: none;">
          <label for="search-field" class="w-100 mb-0">
            <input type="text" class="form-control" id="search-field" placeholder="Type what you want and enter">
          </label>
          <span class="search-close">&times;</span>
        </div><!-- Site search end -->
    </div>
    <!--/ Container end -->

  </div>
  <!--/ Navigation end -->
</header>
<!--/ Header end -->