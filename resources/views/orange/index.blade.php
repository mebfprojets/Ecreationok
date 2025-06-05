@extends('layouts.frontend')
@section('content')
@if(session('message'))
                    <center><div class="custom-alert" style="color: white;">
                        {{ session('message') }}
                    </div>
                    </center>
@endif
@if(session('error'))
                    <center><div class="custom-rouge" style="color: white;">
                        {{ session('error') }}
                    </div>
                    </center>
@endif
<div class="block-title align-items-center" style="margin-top: 50px;">
    
                    <center><h3><strong>Paiements</strong></h3></center>
                    <center><p>Choisir le mode de paiement</p>

                    <div class="row" style="display: flex; position: relative; align-items: center; justify-content: center;">                    
                        <div class="col-md-4">                        
                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#orange" data-bs-whatever="">
                                    <img src="{{asset('frontend/images/OM.png')}}" width="100" height="100" alt="">
                                </button><br>
                                <label for="exampleInputEmail1" class="form-label">
                                    <!-- Composer *144*4*6*{{$montant}}# pour générer le code OTP -->
                                    <li>1. Composer <strong><i>*144*4*6*{{$montant}}#</i></strong> Pour générer le code OTP</li>
                                    <li>2. Renseigner le numéro de téléphone ayant généré le code OTP dans le champ <strong><i>Numéro de Paiement</strong></i></li>
                                    <li>3. Renseigner le code OTP dans le champ </i></strong>"Code OTP"</strong></i></li>

                                </label>                                
                            </div>                                          
                        </div>
                        <div class="col-md-4" style="margin-top: -7%;">       
                            <div class="mb-3">
                                <button  onclick="calltouchpay('{{$command}}','{{$montant_telm}}')" class="btn btn-outline-info me-2">
                                    <img src="{{asset('frontend/images/Moov.png')}}" width="100" height="100" alt="">
                                </button><br><br>
                                <!-- <label for="exampleInputEmail1" class="form-label">
                                    Poursuivre
                                </label> -->
                            </div>
                        </div>
                    </div>
                    </center>
<center>            
                    <!-- <button  onclick="calltouchpay('{{$command}}','{{$montant}}')" class="btn btn-outline-info me-2">Moov Money</button> -->

                    <!-- <a href="" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#addformation" data-bs-whatever="">Moov Money</a>                         -->

                    </center>
                    <!-- <form action="">
                      @csrf

                      <div class="row">
                                                        
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Nom Commercial (<font color="red">*</font>)</label>                                    
                                                                    <input type="text" id="nom_commercial_pp" name="nom_commercial" class="form-control" id="progress-basicpill-vatno-input"  required>
                                                                    <input type="hidden" name="type_request" value="P1" class="form-control" id="progress-basicpill-pancard-input">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                <label class="form-label" for="progress-basicpill-vatno-input">Enseigne</label>
                                                                    <input type="text" name="enseigne" class="form-control" id="progress-basicpill-vatno-input" >                                                                  
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">Sigle</label>
                                                                    <input type="text" name="sigle" class="form-control" id="sigle_pp" >
                                                                </div>
                                                            </div>                                     
                                                        </div>

                    </form> -->


</div>
@endsection
<div class="modal fade" id="orange" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Orange Money</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('orange.store')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$demande_id}}">
        <input type="hidden" name="command" value="{{$command}}">
        <input type="hidden" name="montant" value="{{$montant}}">
        

        <div class="modal-body">
            <li>1. Composer <strong><i>*144*4*6*{{$montant}}#</i></strong> Pour générer le code OTP</li>
            <li>2. Renseigner le numéro de téléphone ayant généré le code OTP dans le champ <strong><i>Numéro de Paiement</strong></i></li>
            <li>3. Renseigner le code OTP dans le champ </i></strong>"Code OTP"</strong></i></li>
            <br><br>
                <div class="row g-4">                    
                        <div class="col-md-6">                        
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Numéro de Paiement</label>
                                <input type="text" name="numero" class="form-control" value="{{ old('libelle') }}" id="" required>
                            </div>
                        </div>
                        <div class="col-md-6">                        
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Code OTP</label>
                                <input type="text" name="otp" class="form-control" value="{{ old('libelle') }}" id="" required>
                            </div>
                        </div>                        
                </div>               
        </div>
      <center>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
        <input type="submit" class="btn btn-success" value="Valider">
        <!-- <button type="button" id="saveButton" class="btn btn-success"></button> -->       
      </div>
      </center>
      </form>
    </div>
  </div>
</div>