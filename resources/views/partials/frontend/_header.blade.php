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
  <title>Ecreation - Creation entreprise en ligne</title>

  <!-- Mobile Specific Metas
================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name=author content="Themefisher">
  <meta name=generator content="Themefisher Constra HTML Template v1.0">

  <!-- Favicon
================================================== -->
  <link rel="icon" type="image/png" href="frontend/images/favicon.png">

  <!-- CSS
================================================== -->

<!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<link rel="stylesheet" href="assets/css/form-elements.css">

  <!-- Bootstrap -->

  
  <link rel="stylesheet" href="{{asset('frontend/plugins/bootstrap/bootstrap.min.css')}}">
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

<link rel="shortcut icon" href="{{asset('backend/images/favicon.ico')}}">
<link rel="stylesheet" href="{{asset('backend/libs/twitter-bootstrap-wizard/prettify.css')}}">
<!-- fais chnger la couleur de vérifier nomcommercial -->

        <link href="{{asset('backend/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('backend/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

<link href="{{asset('backend/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" /> 
<link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
<!-- Pour accueil pour raison de position -->
<link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
<link rel="stylesheet" href="{{asset('/css/jquery.steps.css')}}">


<!-- Pour la signature -->

    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
</head>
<body>
  
    <!--/ Topbar end -->
<!-- Header start -->
<header id="header" style="margin-top: -30px" class="header-one">
  <div class="bg-white">
    <div class="container">
      <div class="logo-area">
          <div class="row align-items-center">
            <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                <a class="d-block" href="index.html">
                  <img loading="lazy" style="width: 80; height: 80px;" src="{{ asset('frontend/images/MEBF-CEFORE.JPG') }}" alt="Constra">
                </a>
            </div><!-- logo end -->
  
            <div class="col-lg-9 header-right">
                <ul class="top-info-box">
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">Contact</p>
                          <p class="info-box-subtitle">(+226) 02 21 21 21 - 58 80 77 77 - 56 62 02 02</p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">Email</p>
                          <p class="info-box-subtitle">info@me.bf</p>
                      </div>
                    </div>
                  </li>
                  <!-- <li class="last">
                    <div class="info-box last">
                      <div class="info-box-content">
                          <p class="info-box-title">Global Certificate</p>
                          <p class="info-box-subtitle">ISO 9001:2017</p>
                      </div>
                    </div>
                  </li> --> 
                  <li class="header-get-a-quote">
                    <a class="btn btn-primary" data-toggle="modal" href="#modal-verifier-nomCommercial">Vérifier un nom commerical</a>
                  </li>
                </ul><!-- Ul end -->
            </div><!-- header right end -->
          </div><!-- logo area end -->
  
      </div><!-- Row end -->
    </div><!-- Container end -->
  </div>

  <div class="site-navigation">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
              <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div id="navbar-collapse" class="collapse navbar-collapse contenant">
                    <ul class="nav navbar-nav mr-auto">
                     <!-- <li class="nav-item dropdown active">
                          <a href="#" class="nav-link">Accueil <i class="fa fa-angle-down"></i></a>
                           <ul class="dropdown-menu" role="menu">
                            <li class="active"><a href="index.html">Home One</a></li>
                            <li><a href="index-2.html">Home Two</a></li>
                          </ul> 
                      </li>-->
                      <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Accueil</a></li>
                      @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('create.usager') }}">Créer une demande</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Mes demandes</a></li>
                      @endauth
                      <li class="nav-item"><a class="nav-link" target="_blank" href="http://me.bf/fr/annonces-legales">Annonces Légales</a></li>
                      <!--<li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Annonces Légales <i class="fa fa-angle-down"></i></a>
                           <ul class="dropdown-menu" role="menu">
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="team.html">Our People</a></li>
                            <li><a href="testimonials.html">Testimonials</a></li>
                            <li><a href="faq.html">Faq</a></li>
                            <li><a href="pricing.html">Pricing</a></li>
                          </ul> 
                      </li>-->
<!--               
                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Projects <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="projects.html">Projects All</a></li>
                            <li><a href="projects-single.html">Projects Single</a></li>
                          </ul>
                      </li>
              
                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Services <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="services.html">Services All</a></li>
                            <li><a href="service-single.html">Services Single</a></li>
                          </ul>
                      </li>
              
                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Features <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="404.html">404</a></li>
                            <li class="dropdown-submenu">
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown">Parent Menu</a>
                                <ul class="dropdown-menu">
                                  <li><a href="#!">Child Menu 1</a></li>
                                  <li><a href="#!">Child Menu 2</a></li>
                                  <li><a href="#!">Child Menu 3</a></li>
                                </ul>
                            </li>
                          </ul>
                      </li>
              
                      <li class="nav-item dropdown">
                          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">News <i class="fa fa-angle-down"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="news-left-sidebar.html">News Left Sidebar</a></li>
                            <li><a href="news-right-sidebar.html">News Right Sidebar</a></li>
                            <li><a href="news-single.html">News Single</a></li>
                          </ul>
                      </li> -->
                      <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        @guest
          <li id="contenu" class="nav-item dropdown pull-right">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">MON COMPTE</a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">

                <li class="divider"></li>
                <li>
                    <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                    <a href="#modal-login" data-toggle="modal">
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
                  <a href="#modal-create-compte" data-toggle="modal">
                    <i class="fa fa-user"></i>
                     Créer un compte
                  </a>
              </li>
            </ul>
        </li>
       @else 
       <li id="contenu" class="nav-item dropdown pull-right">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}}</a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">

                <li class="divider"></li>
                <li>
                    <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                    <a href="#modal-user-settings" data-toggle="modal">
                        <i class="fa fa-cog fa-fw pull-right"></i>
                        Profil utilisateur
                    </a>
                </li>
                <li class="divider"></li>
                {{-- <li>
                    <a href="page_ready_lock_screen.html"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a>
                </li> --}}
                
              <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"><i class="fa fa-ban fa-fw pull-right"></i>
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