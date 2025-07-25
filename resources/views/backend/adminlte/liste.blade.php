@extends('backend.adminlte.main')
@section('demandes', 'menu-open')
@section($dem, 'active')
@section('content')
<div class="card">
              <div class="card-header">
               <strong><h3 class="card-title">
                Liste des Demandes
              </h3></strong>
              </div>              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead style="background-color:#0b9e44; color:white">
                  <tr>
                    <th>N°</th>
                    <th>Numero Demande</th>
                    <th>Promoteur</th>
                    <th>Statut</th>
                    <th>Nom Commercial</th>
                    <th>Dénomination Sociale</th>
                    <th>Date Création</th>
                    <th>Date Paiement</th>
                    <th>Date Validation</th>                 
                    <th>Actions</th>                                       
                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  @php
                    $i=0; 
                  @endphp
                   @foreach ($demandes as $demande)
                        @php
                        $i++;
                        @endphp
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$demande->numero_demande}}</td>
                    <td>{{$demande->legal_rep_name}}</td>
                    <td>@if($demande->paye==1) Payé @elseif($demande->paye==2) Attente Validation du Paiement @else Non Payé @endif</td>
                    <td>{{$demande->commercial_name}}</td>
                    <td>{{$demande->denomination_social}}</td>
                    <td>{{date("d-m-Y à H:i", strtotime($demande->created_at))}}</td>
                    <td>{{date("d-m-Y à H:i", strtotime($demande->date_paiement))}}</td>
                    <td>{{date("d-m-Y à H:i", strtotime($demande->Date_etat_validation))}}</td>
                    <td><a href="{{ route('detail.demande', $demande->id) }}" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
                    <td>{{$demande->objet_social}}</td>
                    <td>{{$demande->organisation_code}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>N°</th>
                    <th>Numero Demande</th>
                    <th>Promoteur</th>
                    <th>Statut</th>
                    <th>Nom Commercial</th>
                    <th>Dénomination Sociale</th>  
                    <th>Date Création</th>
                    <th>Date Paiement</th>
                    <th>Date Validation</th>                              
                    <th>Actions</th>                    
                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
</div>
            <!-- /.card -->
@endsection