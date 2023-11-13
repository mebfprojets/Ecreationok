@extends('layouts.frontend')
@section('content')
<div class="block-content payer" style="margin-top: 50px;">
    <div class="row">
    <div class="col-xs-6">
        <!-- Form Validation Example Block -->

            <!-- END Form Validation Example Title -->

            <!-- Form Validation Example Content -->
            <div class="block">
                <!-- Clickable Wizard Title -->
                <div class="block-title">
                    <center><h3><strong>Procéder au Paiement</strong></h3></center>
                </div>
                <center><h5> Informations sur l'entreprise</h5></center>
                <!-- Veuillez renseigner votre code de souscription pour poursuivre votre inscription :<br> -->
               
                <table class="table" style="background-color: #f0f0f0;">
                                <tbody> 
                                            <tr>
                                                <td><strong>Statut</strong></td>
                                                @if($demande->paye==0)
                                                <td>Attente de paiement</td>
                                                @endif                                                                      
                                            </tr>
                                            <tr>
                                                <td><strong>Montant</strong></td>
                                                <td>{{$demande->montant}} FCFA<td>                                                                      
                                            </tr>
                                            <tr>
                                                <td><strong>Nom Commercial</strong></td>
                                                <td>{{$demande->commercial_name}}</td>                                                                        
                                            </tr>
                                                <tr>
                                                    <td><strong>Forme Juridique</strong></td>
                                                    <td>{{$forme_juridique->libelle}}</td>                                                                        
                                                </tr>
                                                <tr>
                                                     <td><strong>Activité Principal</strong></td>
                                                     <td>{{$activites->description}}</td>
                                                </tr>
                                                <tr>
                                                   <td><strong>Objet Social</strong> </td>
                                                   <td>{{$demande->objet_social}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Adresse Entreprise:</strong></td>
                                                    <td>{{$regions->name}} - {{$provinces->name}} - {{$communes->name}} - {{$secteurs->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Dirigeant Entreprise:</strong></td>
                                                    <td>{{$dirigeants->NomRaisonSociale}} {{$dirigeants->Prenom}}</td>
                                                </tr>
                                                <!-- <tr>
                                                    <td><strong>Personne à prévénir en cas de bessoin:</strong></td>
                                                    <td></td>
                                                </tr>                             -->
                                                                  
                                    </tbody>
                          </table> 
                    <!-- <br><input type="text" class="form-control" name="code_inscrit" placeholder="" required> <br><br> -->
                    <!-- <button type="reset" class="btn btn-danger">Annuler</button> -->
                   <center> 
                   <button onclick="calltouchpay('{{$demande->numero_demande}}','{{$demande->montant}}')" class="btn btn-success">Payer</button>
                   <input type="hidden" name="" id="demande_montant" value="{{$demande->montant}}">
                   <input type="hidden" name="" id="demande_id" value="{{$demande->id}}">
                   <input type="hidden" name="" id="numero_demande" value="{{$demande->numero_demande}}">                                                                                           
                    <!-- <button type="submit" class="btn btn-success">Payer</button> -->
                </center>
           
            
            </div>
    </div>
    </div>
</div>
@endsection