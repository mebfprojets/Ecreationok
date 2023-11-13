@extends('layouts.frontend')
@section('content')
<div class="block-content" style="margin-top: 50px;">
<div class="block-title">
                    <center><h3><strong>Mes démandes</strong></h3></center>
                </div>
                @foreach($demandes as $demande)

    <div class="row">
    <div class="col-xs-10">
            <div class="block">
                <h5>Demande N°: </h5>
                <div class="row">
                      
                                                            <div class="col-lg-8">
                                                                <div class="mb-3">
                                                                    <!-- <label class="form-label" for="progress-basicpill-pancard-input">Type Etablissement</label> -->
                                                                    <label class="form-label" for="progress-basicpill-vatno-input">
                                                                    @if($demande->company_type=="EI")
                                                                            Entreprise Individuelle
                                                                            @else
                                                                            Entreprise Sociétaire
                                                                            @endif                                                                        
                                                                    </label>
                                                                    <label style="margin-left:40px" class="form-label" for="progress-basicpill-vatno-input">
                                                                    {{$demande->commercial_name}}
                                                                    </label>
                                                                    <label style="margin-left:40px" class="form-label" for="progress-basicpill-vatno-input">Créé le : {{ date("d-m-Y", strtotime($demande->created_at))}}</label> <br>
                                                                    <label class="form-label" style="color:#008000;" for="progress-basicpill-vatno-input">{{$demande->organisation_code}}</label>
                                                                    <label class="form-label" style="margin-left:40px" for="progress-basicpill-vatno-input">{{$demande->commercial_name}}</label> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <div class="mb-3">
                                                                 <label class="form-label" style="color:red;" for="progress-basicpill-vatno-input">Attente de paiement</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <div class="mb-3">                                                                
                                                                <button type="submit" href="{{ route('demande.detail',$demande->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></button>                                                              
                                                                </div>
                                                            </div>                                               
                                                            <div class="col-lg-1">
                                                                <div class="mb-2">                                                              
                                                                <button  onclick="calltouchpay()" class="btn btn-success">Payer</button>
                                                                </div>
                                                            </div>     
                                                            <input type="hidden" name="" id="demande_montant" value="{{$demande->montant}}">                                                                                           
                                                        </div>  
                </div>
    </div>
    </div>
    
    @endforeach
   
    
</div>

@endsection
<script src=https://api.gutouch.net/touchpayv2/script/touchpaynr/prod_touchpay-0.0.1.js  type='text/javascript'>
</script>
  <script type="text/javascript">
  function calltouchpay(){
    var order_number='hjhkj';
    var agence_code='MSENT2793';
    var secure_code='suzYy19U3ev2TIsabnK6JtKaFG75oZjc1zD36Mc4QPgcVXRZAM';
    var domaine='maison.com';
    var url_redirection_success="{{route('valider.paiement')}}";
    var url_redirection_failed="{{route('index')}}";
    var amount=100;
    var city='hjj';
    var email='test@gmail.com';
    var clientFirstName='kk';
    var clientLastName='jhkk';
    //var clientPhone='65678787';
    sendPaymentInfos(order_number, agence_code, secure_code,
       domaine, url_redirection_success, url_redirection_failed,
       amount, 'dakar', email, 'firstname', 'lastname'
    );
    
  }
</script>