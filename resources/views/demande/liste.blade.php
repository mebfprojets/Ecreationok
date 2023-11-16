@extends('layouts.frontend')
@section('content')
<div class="block-content" style="margin-top: 50px;">
<div class="block-title">
                    <center><h3><strong>Mes demandes</strong></h3></center>
                    <center><h5>Vous avez {{$c}} demande (s)</h5></center>
                </div>
                @foreach($demandes as $demande)

    <div class="row">
    <div class="col-xs-10">
            <div class="block">
                <h5>Demande N°: {{$demande->numero_demande}}</h5>
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
                                                                 <label class="form-label" style="color:red;" for="progress-basicpill-vatno-input">
                                                                 @if($demande->paye==0)
                                                                 Attente de paiement
                                                                 @elseif($demande->paye==1 && $demande->etat==1 || $demande->etat==0 )
                                                                 Payée, En Traitement
                                                                 @elseif($demande->paye==1 && $demande->etat==2)
                                                                 Demande Rejétée
                                                                 @endif
                                                                </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <div class="mb-3">                                                        
                                                                <a href="{{ route('demande.detail',$demande->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>                                                              
                                                                </div>
                                                            </div>                                               
                                                            <div class="col-lg-1">
                                                                <div class="mb-2"> 
                                                                @if($demande->paye==0)                                                           
                                                                <button  onclick="calltouchpay('{{$demande->numero_demande}}','{{$demande->montant}}')" class="btn btn-success">Payer</button>
                                                                <input type="hidden" name="" id="demande_montant" value="{{$demande->montant}}"> 
                                                                <input type="hidden" name="" id="numero_demande" value="{{$demande->numero_demande}}"> 
                                                                
                                                                @else                                              
                                                                <a href="{{ route('demande.facture',$demande->id)}}" class="btn btn-success">Facture</a>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            
                                                            </div>
                                                            
                                                                                                                                                   
                                                        </div>  
                </div>
    </div>
    </div>
    
    @endforeach
   
    
</div>

@endsection