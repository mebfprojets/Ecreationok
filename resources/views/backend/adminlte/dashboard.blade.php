@extends('backend.adminlte.main')
@section('dashboard', 'active')
@section('content')
    <!-- Main content -->
    <div class="block-title" style="margin-top:-50px;">
                    <center><h2><strong>Tableau de Board</strong></h2></center>
                    
                </div>

    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$nbr}}</h3>
                <p>Demandes</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ route('list') }}" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$nbr_paye}}</h3>
                <p>Demandes Payées</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('liste.filtre')}}?paye=1" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$nbr_nonpaye}}</h3>

                <p>Attente de Paiement</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('liste.filtre')}}?paye=0" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$nbr_rejet}}</h3>

                <p>Demandes Rejétées</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('list.rejet')}}" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>          
          <!-- ./col -->
        </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <div class="card">                           
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style="background-color:#0b9e44; color:white">
                    <th>N°</th>
                    <th>Numero Demande</th>
                    <th>Promoteur</th>
                    <th>Statut</th>
                    <th>Nom Commercial</th>
                    <th>Dénomination Sociale</th>                
                    <th>Sigle</th>   
                    <th>Actions</th>  
                    <th>Date Création</th>              
                    <th>Activité Principale</th>
                    <th>Objet Social</th>
                    <th>CEFORE</th>                  
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
                    <td>@if($demande->paye==1) Payé @elseif($demande->paye==2) Attente Validation du Paiement @else Non Payé @endif</td>
                    <td>{{$demande->commercial_name}}</td>
                    <td>{{$demande->denomination_social}}</td>
                    <td>{{$demande->sigle}}</td>
                    <td><a href="{{ route('detail.demande', $demande->id) }}" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
                    <td>{{format_date($demande->created_at)}}</td>
                    <td>{{$demande->primary_activity}}</td>
                    <td>{{$demande->objet_social}}</td>
                    <td>{{$demande->organisation_code}}</td>                    
                    <td>{{format_date($demande->date_paiement)}}</td>
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
                    <th>Date Création</th>
                    <th>Activité Principale</th>
                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    <th>Date Paiement</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
</div>
    <!-- /.content -->
  @endsection