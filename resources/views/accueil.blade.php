@extends('layouts.frontend')
@section('content')

<div class="banner-carousel banner-carousel-1 mb-0">
  <div class="banner-carousel-item" style="background-image:url(frontend/images/slider-main/bg1.jpeg); height: 300px;">
    <div class="slider-content">
        <div class="container h-100">
          <div class="row align-items-center h-100">
              <div class="col-md-12 text-center">
              <!-- <h3 style="color:#FFF; margin-top: 30px;">             
              LES DEMANDES DE CREATION D'ENTREPRISE REPRENDRONT LE 02 AVRIL 2024</h3>                 -->
                @auth
                <p data-animation-in="slideInLeft" data-duration-in="1.2">
                    <a href="{{ route('create.usager') }}" class="slider btn btn-primary">Créer mon entreprise</a>
                    <!-- <a href="contact.html" class="slider btn btn-primary border">Contact Now</a> -->
                </p>
                @endauth
              </div>
          </div>
        </div>
    </div>
  </div>


</div>
<div class="row" style="margin-top:30px;">

<div class="col-md-3 col-sm-6" >
                <div class="service text-center">
                    <img src="frontend/images/customer-service.png" alt="" width="100" height="100">
                    <h4 class="service-title">Avant de commencer</h4>
                    <br class="mt-4">
                    <p>Avant de créer votre entreprise, vous devez d'abord vérifier la disponibilité du nom commercial...</p>
                    <a class="btn btn-success btn-block" data-toggle="modal" href="#modal-infos">Lire Plus</a>
                    <!-- <a href="/contacter-le-centre-de-formalites-des-entreprises-cfe-togo.html" class="btn btn-success btn-block">Lire Plus</a> -->
                </div><!-- End .service -->
            </div><!-- End .col-md-3 -->

<div class="col-md-3 col-sm-6" >
                <div class="service text-center">
                    <img src="frontend/images/PP.png" alt="" width="100" height="100">
                    <h4 class="service-title">Personne Physique</h4>
                    <h5 class="service-title">(Entreprise Individuelle)</h5>
                    <br class="mt-5"><br>
                    <p>
                        <!-- <br class="mt-5"><br> -->
                        <a class="btn btn-success btn-block" data-toggle="modal" href="#modal-piece_pp">Pièces à fournir</a>
                        <a class="btn btn-success btn-block" target="_blank" href="https://www.me.bf/wp-content/uploads/2024/01/Formalite-personne-physique.pdf">Formulaire de renseignement</a>
                        <!-- <a class="btn btn-success btn-block"  target="_blank" href="/documents/download-renseignements_po">Pièces à fournir</a> -->
                        <!-- <a class="btn btn-success btn-block"  href="http://me.bf/fr/file/2967/download?token=kziektSF">Déclaration sur honneur</a>
                        <a class="btn btn-success btn-block"  href="http://me.bf/fr/file/2893/download?token=P7jVe3E4">Démande de localisation</a> -->
                    </p>
                </div><!-- End .service -->
            </div><!-- End .col-md-3 -->
<div class="col-md-3 col-sm-6">
                <div class="service text-center">
                    <img src="frontend/images/entreprise.png" alt="" width="100" height="100">
                    <h4 class="service-title"> Personne Morale</h4>
                    <h5 class="service-title">(Entreprise Sociétaire)</h5>
                    <br class="mt-5"><br>
                    <p>
                        <a class="btn btn-success btn-block" data-toggle="modal" href="#modal-piece_pm">Pièces à fournir</a>
                        <a class="btn btn-success btn-block" target="_blank" href="https://www.me.bf/wp-content/uploads/2024/01/Formalite-personne-morale.pdf">Formulaire de renseignement</a>
                        <!-- <a class="btn btn-success btn-block" target="_blank" href="/documents/download-renseignements_mo" style="margin-top: 22px;">Pièces à fournir</a> -->
                        <!-- <a class="btn btn-success btn-block"  href="http://me.bf/fr/file/3481/download?token=avSak-TP">Formulaire RCCM</a>
                        <a class="btn btn-success btn-block"  href="http://me.bf/fr/file/132/download?token=_Sx15V_e">Modèle Acte de dépôt</a> -->
                      </p>
                </div><!-- End .service -->
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="service text-center">
                    <img src="frontend/images/Video.png" alt="" width="100" height="100">
                    <h4 class="service-title">Pour vous</h4>
                    <br class="mt-5"><br>
                    <p>Le site web de la MEBF est reconnu comme support d'annonces légales</p>
                    <a href="/annonces-legales/les-10-dernieres-annonces.html" class="btn btn-success btn-block">Consulter</a>
                </div><!-- End .service -->
            </div>
</div>
<hr>
<section id="ts-features" style="margin-top: -60px;" class="ts-features">
  <div class="container">
    <div class="row">
    <div class="col-lg-6 mt-4 mt-lg-0">
          <h3 class="into-sub-title">Type D'entreprise</h3>
          <!-- <p>Minim Austin 3 wolf moon scenester aesthetic, umami odio pariatur bitters. Pop-up occaecat taxidermy street art, tattooed beard literally.</p> -->

          <div class="accordion accordion-group" id="our-values-accordion">
              <div class="card">
                <div class="card-header p-0 bg-transparent" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Entreprise Indviduelle
                      </button>
                    </h2>
                </div>
              
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#our-values-accordion">
                    <div class="card-body">
                    Une entreprise individuelle est une forme simplifiée d’entreprise créée par une personne physique. 
                    Toute personne de plus de 20 ans peut créer ce type d’entreprise et devient alors entrepreneur individuel. 
                    L’entrepreneur individuel est indéfiniment responsable des dettes de l’entreprise.
                    </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header p-0 bg-transparent" id="headingTwo">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Entreprise Sociétaire
                      </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#our-values-accordion">
                    <div class="card-body">
                    La société commerciale est créée par deux (2) ou plusieurs personnes qui conviennent, par un contrat,
                    d'affecter à une activité des biens en numéraire ou en nature, ou en industrie, dans le but de partager
                    le bénéfice ou de profiter de l'économie qui peut en résulter.
La société commerciale peut être également créée par une seule personne, dénommée « associé unique ». 
Il existe plusieurs formes de sociétés commerciales :
  <ul>-Société à responsabilité limitée (SARL)</ul>
  <ul>-Société anonyme (SA)</ul>
  <ul>-Société par actions simplifiées (SAS)</ul>
  <ul>-Sociétés en nom collectif (SNC)</ul>
  <ul>-Société à commandites simples (SCS) </ul> 
                    </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header p-0 bg-transparent" id="headingThree">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Groupement d'intérêt Economique
                      </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#our-values-accordion">
                    <div class="card-body">
                    Organisation qui a pour but exclusif de mettre en œuvre pour une durée déterminée, tous les moyens propres 
                    à faciliter ou à développer l’activité économique de ses membres, à améliorer ou à accroître les résultats de cette activité.
Les membres sont solidairement et indéfiniment responsables des dettes du groupement.
Il peut être créé sans capital social.
Le GIE est géré par un ou plusieurs administrateurs.
                    </div>
                </div>
              </div>
          </div>
          <!--/ Accordion end -->

        </div><!-- Col end -->
        <div class="col-lg-6">
          <div class="ts-intro">
          <div class="row">
              <div class="col-md-6">
          <img src="frontend/images/aide_cefore.jpeg" width="500" height="350" alt="">
</div>
</div>
              <!-- <h2 class="into-title">About Us</h2> 
              <h3 class="into-sub-title">Avant de commencer</h3>
              <p>Avant de créer votre entreprise, vous devez d'abord vérifier la disponibilité du nom commercial/dénomination sociale et/ou le sigle que vous envisagez.

Vous pouvez aussi réserver le nom commercial et/ou la dénomination sociale choisi(s) pour votre entreprise, contre remise d'une Attestation de Disponibilité et de Réservation qui sera jointe aux statuts pour la numérisation. L'Attestation de Disponibilité et de Réservation s'obtient auprès :

de l'Administrateur du FN-RCCM sis à la MEBF si vous résidez Ã  Ouagadougou ;
du Chef de greffe du Tribunal compétent si vous résidez dans une localité ne disposant pas d'un bureau CEFORE ;
du Conseiller CEFORE si vous êtes dans une localité disposant d'un bureau CEFORE autre que Ouagadougou.</p>
          </div><!-- Intro box end 

          <div class="gap-20"></div>

          <div class="row">
              <div class="col-md-6">
                <div class="ts-service-box">
                    <span class="ts-service-icon">
                      <i class="fas fa-trophy"></i>
                    </span>
                    <div class="ts-service-box-content">
                      <h3 class="service-box-title">We've Repution for Excellence</h3>
                    </div>
                </div><!-- Service 1 end 
              </div><!-- col end 

              <div class="col-md-6">
                <div class="ts-service-box">
                    <span class="ts-service-icon">
                      <i class="fas fa-sliders-h"></i>
                    </span>
                    <div class="ts-service-box-content">
                      <h3 class="service-box-title">We Build Partnerships</h3>
                    </div>
                </div><!-- Service 2 end -->
              </div><!-- col end -->
          </div><!-- Content row 1 end 

          <div class="row">
              <div class="col-md-6">
                <div class="ts-service-box">
                    <span class="ts-service-icon">
                      <i class="fas fa-thumbs-up"></i>
                    </span>
                    <div class="ts-service-box-content">
                      <h3 class="service-box-title">Guided by Commitment</h3>
                    </div>
                </div><!-- Service 1 end 
              </div><!-- col end 

              <div class="col-md-6">
                <div class="ts-service-box">
                    <span class="ts-service-icon">
                      <i class="fas fa-users"></i>
                    </span>
                    <div class="ts-service-box-content">
                      <h3 class="service-box-title">A Team of Professionals</h3>
                    </div>
                </div><!-- Service 2 end 
              </div><!-- col end 
          </div><!-- Content row 1 end 
        </div><!-- Col end -->

        
    </div><!-- Row end -->
  </div><!-- Container end -->
</section><!-- Feature are end -->

<center><u><h3 class="into-sub-title">Coût des Formalités</h3></u></center>
<hr>
<center>
<div class="container">
  
    <div class="row" style="margin-top:30px;">

        <div class="col-md-4 col-sm-5" >
                <div class="service text-center">
                    <div class="cout-formalite">
                    <p  style="color:#fafafa; margin-bottom: -10px;font-size: 18px;">Personne Physique (PP)</p><hr>
                    <p class="montant" style="margin-bottom:-20px; font-weight:700;font-size: 21px;">44.880 FCFA</p><hr>
                    <p class="montant" style="margin-bottom:-20px; font-weight:700;font-size: 21px;">RCCM + IFU + CNSS + CPC</p>
                    </div>
                </div><!-- End .service -->
          </div><!-- End .col-md-3 -->

        <div class="col-md-4 col-sm-6" >
                <div class="service text-center">
                    <div class="cout-formalite">
                    <p style="color:#fafafa; margin-bottom: -10px;font-size: 18px;">Personne Morale (PM)</p><hr>
                    <p style="margin-top: -20px; font-weight:700;font-size: 21px; margin-bottom:-20px;">RCCM + IFU + CNSS : 53.040 F CFA</p><hr>
                    <p style="margin-top: -20px; font-weight:700;font-size: 18px; margin-bottom:-20px;">RCCM + IFU + CNSS + CPC: 70.890 F CFA</p>
                    </div>
                </div><!-- End .service -->
          </div><!-- End .col-md-3 -->

          <div class="col-md-4 col-sm-6" >
                <div class="service text-center">
                    <div class="cout-formalite">
                    <p style="color:#fafafa; margin-bottom: -10px; font-size: 18px;">Groupement d'Intérêt Economique (GIE)</p><hr>
                    <p style="margin-top: -20px; font-weight:700;font-size: 21px; margin-bottom:-20px;">RCCM + IFU + CNSS : 53.040 F CFA</p><hr>
                    <p style="margin-top: -20px; font-weight:700;font-size: 18px; margin-bottom:-20px;">RCCM + IFU + CNSS + CPC: 70.890 F CFA</p>
                    </div>
                </div><!-- End .service -->
            </div><!-- End .col-md-3 -->
            
      </div>
  </center>
  <!--/ Container end -->


<center><u><h3 class="into-sub-title" style="margin-top: 50px">STATISTIQUES </h3></u></center><hr>
<section id="facts" class="facts-area dark-bg">

  <div class="container">
    
    <div class="facts-wrapper">
        <div class="row">
          <div class="col-md-3 col-sm-6 ts-facts">
              <div class="ts-facts-img">
                <img loading="lazy" src="frontend/images/icon-image/fact1.png" alt="facts-img">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count="{{$total}}">0</span></h2>
                <h3 class="ts-facts-title">Entreprises créées</h3>
              </div>
          </div><!-- Col end -->

          <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-sm-0">
              <div class="ts-facts-img">
                <img loading="lazy" src="frontend/images/icon-image/fact2.png" alt="facts-img">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count="{{$nbr_pp}}">0</span></h2>
                <h3 class="ts-facts-title">Entreprises Individuelles</h3>
              </div>
          </div><!-- Col end -->

          <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-md-0">
              <div class="ts-facts-img">
                <img loading="lazy" src="frontend/images/icon-image/service-icon1.png" alt="facts-img">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count="{{$nbr_pm}}">0</span></h2>
                <h3 class="ts-facts-title">Entreprises Sociétaires</h3>
              </div>
          </div><!-- Col end -->

          <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-md-0">
              <div class="ts-facts-img">
                <img loading="lazy" src="frontend/images/icon-image/fact3.png" alt="facts-img">
              </div>
              <div class="ts-facts-content">
                <h2 class="ts-facts-num"><span class="counterUp" data-count="{{$nbr_mois}}">0</span></h2>
                <h3 class="ts-facts-title">Créations du mois</h3>
              </div>
          </div><!-- Col end -->

        </div> <!-- Facts end -->
    </div>
    <!--/ Content row end -->
  </div>
  <!--/ Container end -->
</section><!-- Facts end -->
<!--
<section id="ts-service-area" class="ts-service-area pb-0">
  <div class="container">
    <div class="row text-center">
        <div class="col-12">
          <!-- <h2 class="section-title">We Are Specialists In</h2> 
          <h3 class="section-sub-title">Nos Services</h3>
        </div>
    </div>
    <!--/ Title row end 

    <div class="row">
        <div class="col-lg-4">
          <div class="ts-service-box d-flex">
              <div class="ts-service-box-img">
                <img loading="lazy" src="frontend/images/icon-image/service-icon1.png" alt="service-icon">
              </div>
              <div class="ts-service-box-info">
                <h3 class="service-box-title"><a href="#">Formation GERME</a></h3>
                <p>Une formation qui vous permettra de mieux gerer votre entreprise</p>
              </div>
          </div><!-- Service 1 end 

          <div class="ts-service-box d-flex">
              <div class="ts-service-box-img">
                <img loading="lazy" src="frontend/images/icon-image/service-icon2.png" alt="service-icon">
              </div>
              <div class="ts-service-box-info">
                <h3 class="service-box-title"><a href="#">Séminaire de management</a></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Integer adipiscing erat</p>
              </div>
          </div><!-- Service 2 end 

          <div class="ts-service-box d-flex">
              <div class="ts-service-box-img">
                <img loading="lazy" src="frontend/images/icon-image/service-icon3.png"  alt="service-icon">
              </div>
              <div class="ts-service-box-info">
                <h3 class="service-box-title"><a href="#">SME_Loop</a></h3>
                <p>Formation des Coach en developpement personnel</p>
              </div>
          </div><!-- Service 3 end 

        </div><!-- Col end 

        <div class="col-lg-4 text-center">
          <img loading="lazy" class="img-fluid" src="frontend/images/services/service-center.jpg" alt="service-avater-image">
        </div><!-- Col end 

        <div class="col-lg-4 mt-5 mt-lg-0 mb-4 mb-lg-0">
          <div class="ts-service-box d-flex">
              <div class="ts-service-box-img">
                <img loading="lazy" src="frontend/images/icon-image/service-icon4.png" alt="service-icon">
              </div>
              <div class="ts-service-box-info">
                <h3 class="service-box-title"><a href="#">Permis de Construire</a></h3>
                <p>Procurez-vous votre permis en 72h de jour ouvrable</p>
              </div>
          </div><!-- Service 4 end 

          <div class="ts-service-box d-flex">
              <div class="ts-service-box-img">
                <img loading="lazy" src="frontend/images/icon-image/service-icon5.png" alt="service-icon">
              </div>
              <div class="ts-service-box-info">
                <h3 class="service-box-title"><a href="#">Renovation</a></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Integer adipiscing erat</p>
              </div>
          </div><!-- Service 5 end 

          <div class="ts-service-box d-flex">
              <div class="ts-service-box-img">
                <img loading="lazy" src="frontend/images/icon-image/service-icon6.png" alt="service-icon">
              </div>
              <div class="ts-service-box-info">
                <h3 class="service-box-title"><a href="#">Safety Management</a></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Integer adipiscing erat</p>
              </div>
          </div><!-- Service 6 end 
        </div><!-- Col end 
    </div><!-- Content row end 

  </div>
  <!--/ Container end 
</section>Service end
<!--  
<!-- Project area end -->


<!--/ subscribe end -->
<!--/

<!--/ News end -->
@endsection

@section('modal')
      <div class="modal fade" id="modal-loginès" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-header">

              <h3 class="modal-title text-center" id="modal-login-label">  Connexion <i class="fa fa-key"></i></h3>
      
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
              </button>
            </div>
            
            <div class="modal-body">
              
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
                              <span>Se Souvenir de moi</span>
                          </label>
                      </div>
                        <button type="submit" class="btn btn-success">Se Connecter <i class="fa fa-unlock"></i></button>
                  
                              
                        </a>
                    </form>   
            </div>
            
          </div>
        </div>
      </div>
@endsection