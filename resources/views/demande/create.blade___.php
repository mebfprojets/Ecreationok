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


                    <div class="container-fluid" style="width:80%; margin-top:40px;">
                        <div class="row">
                       
                                                   <center> <h3 class="font-size-14 mb-4">Choisir le type d'Entreprise</h3></center>
                                                    <div class="form-check mb-3 col-md-4" id="switch1" >
                                                        <input class="form-check-input" type="radio" switch="bool" name="formRadios"
                                                            id="formRadios1">
                                                        <label for="formRadios1" data-on-label="Oui" data-off-label="Non"></label>
                                                        <p>Entreprise Individuelle</p>
                                                        
                                                    </div>
                                                    <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" switch="bool" name="formRadios"
                                                            id="formRadios2">
                                                            <label for="formRadios2" data-on-label="Oui" data-off-label="Non"></label>
                                                            <p>Entreprise Sociétaire</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <input class="form-check-input" type="radio" switch="bool" name="formRadios"
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
                        
                        <div class="row">
                            

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Création de demande</h4>

                                        <div id="progrss-wizard" class="twitter-bs-wizard">
                                            <ul class="twitter-bs-wizard-nav nav-justified">
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
                                            </ul>

                                            <div id="bar" class="progress mt-4">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                                            </div>
                                            <div class="tab-content twitter-bs-wizard-tab-content">
                                                <div class="tab-pane" id="progress-seller-details">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-firstname-input">First name</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-firstname-input">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-lastname-input">Last name</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-lastname-input">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-phoneno-input">Phone</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-phoneno-input">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-email-input">Email</label>
                                                                    <input type="email" class="form-control" id="progress-basicpill-email-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-address-input">Address</label>
                                                                    <textarea id="progress-basicpill-address-input" class="form-control" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="submit">
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="progress-company-document">
                                                  <div>
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-pancard-input">PAN Card</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-pancard-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">VAT/TIN No.</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-vatno-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-cstno-input">CST No.</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-cstno-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-servicetax-input">Service Tax No.</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-servicetax-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-companyuin-input">Company UIN</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-companyuin-input">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-declaration-input">Declaration</label>
                                                                    <input type="text" class="form-control" id="progress-basicpill-declaration-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                  </div>
                                                </div>
                                                <div class="tab-pane" id="progress-bank-detail">
                                                    <div>
                                                      <form>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-namecard-input">Name on Card</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-namecard-input">
                                                                  </div>
                                                              </div>
  
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label>Credit Card Type</label>
                                                                      <select class="form-select">
                                                                            <option selected>Select Card Type</option>
                                                                            <option value="AE">American Express</option>
                                                                            <option value="VI">Visa</option>
                                                                            <option value="MC">MasterCard</option>
                                                                            <option value="DI">Discover</option>
                                                                      </select>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-cardno-input">Credit Card Number</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-cardno-input">
                                                                  </div>
                                                              </div>
   
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-card-verification-input">Card Verification Number</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-card-verification-input">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-lg-6">
                                                                  <div class="mb-3">
                                                                      <label class="form-label" for="progress-basicpill-expiration-input">Expiration Date</label>
                                                                      <input type="text" class="form-control" id="progress-basicpill-expiration-input">
                                                                  </div>
                                                              </div>
  
                                                          </div>
                                                      </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="progress-confirm-detail">
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
                                                </div>
                                            </div>
                                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
            

        <!-- END layout-wrapper -->

    
        <!-- Right bar overlay-->
       

        <!-- JAVASCRIPT 
        <script src="{{asset('backend/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('backend/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('backend/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('backend/libs/node-waves/waves.min.js')}}"></script>

         twitter-bootstrap-wizard js 
        <script src="{{asset('backend/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>

        <script src="{{asset('backend/libs/twitter-bootstrap-wizard/prettify.js')}}"></script>

        <!-- form wizard init 
        <script src="{{asset('backend/js/pages/form-wizard.init.js')}}"></script>
        <script src="{{asset('backend/js/app.js')}}"></script>
        

    </body>
</html>-->
@endsection