@extends('backend.adminlte.main')
@section('content')
<div class="card">
              <div class="card-header">
               <strong><h3 class="card-title">Liste des Demandes</h3></strong>
              </div>
              <form action="">
                <select name="" id="">
                <option value="" class="form-control">Statut</option>
                <option value="1" class="form-control">Attente de Paiement</option>
                <option value="2" class="form-control">En Traitement</option>
                <option value="3" class="form-control">Traitement Terminé</option>
                <option value="4" class="form-control">Demande Payée</option>
                </select>
                <select name="" id="">
                <option value="" class="form-control">Type</option>
                <option value="1" class="form-control">Personne Physique</option>
                <option value="2" class="form-control">Personne Morale</option>
                </select>
                 <select name="" id="">
                <option value="" class="form-control">Secteur d'activité</option>
                <option value="1" class="form-control">COMMERCE</option>
                <option value="2" class="form-control">INDUSTIRE</option>
                <option value="1" class="form-control">ARTISANAT</option>
                <option value="2" class="form-control">SERVICES</option>
                </select>
              </form>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>N°</th>
                    <th>Numero Demande</th>
                    <th>Promoteur</th>
                    <th>Statut</th>
                    <th>Nom Commercial</th>
                    <th>Dénomination Sociale</th>                
                    <th>Sigle</th>   
                    <th>Actions</th>                
                    <th>Activité Principale</th>
                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    <th>Date Création</th>
                    <th>Date Paiement</th>
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
                    <td>@if($demande->paye==1) Payé @else Non Payé @endif</td>
                    <td>{{$demande->commercial_name}}</td>
                    <td>{{$demande->denomination_social}}</td>
                    <td>{{$demande->sigle}}</td>
                    <td><a href="{{ route('detail.demande', $demande->id) }}" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
                    <td>{{$demande->primary_activity}}</td>
                    <td>{{$demande->objet_social}}</td>
                    <td>{{$demande->organisation_code}}</td>
                    <td>{{$demande->created_at}}</td>
                    <td>{{$demande->date_paiement}}</td>
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
                    <th>Sigle</th>               
                    <th>Actions</th> 
                    <th>Activité Principale</th>
                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    <th>Date Création</th>
                    <th>Date Paiement</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
</div>
            <!-- /.card -->
@endsection