@extends('backend.adminlte.main')
@section('demandes', 'menu-open')
@section('liste_partenaire', 'active')
@section('content')
<div class="block-title" style="margin-top:-50px;">
    <center><h3><strong>Attente Partenaire</strong></h3></center>                    
</div>
<div class="card">

<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$rccm}}</h3>
                <p>Attente RCCM</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$ifu}}</h3>
                <p>Attente IFU</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$cnss}}</h3>

                <p>Attente CNSS</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$cpc}}</h3>

                <p>Attente CPC</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>          
          <!-- ./col -->
        </div>
                          
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead style="background-color:#0b9e44; color:white">
                  <tr>
                    <th>N°</th>
                    <th>Nom Commercial</th>
                    <th>Ref RCCM</th>
                    <th>Ref IFU</th>
                    <th>Ref CNSS</th>
                    <th>Ref CPC</th>
                    <th>Actions</th> 
                    <th>Numero Demande</th>
                    <th>Promoteur</th>                
                    <th>Dénomination Sociale</th>                
                    <th>Sigle</th>
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
                    <td>{{$demande->commercial_name}}</td>
                    <td style="width:250px;"> {{($demande->RCCM)}} du {{($demande->DateRCCM)}}</td>
                    <td>@if($demande->IFU) {{($demande->DateIFU)}} {{($demande->IFU)}}  @else En Attente de IFU  @endif</td>
                    <td>@if($demande->CNSS) {{($demande->CNSS)}} {{($demande->DateCNSS)}}  @else En Attente de CNSS  @endif</td>
                    <td>@if($demande->avecCPC==1) {{($demande->CPC)}} {{($demande->DateCPC)}}  @elseif($demande->avecCPC==1 && $demande->CPC==null) En Attente de CPC @else Pas de Prestation CPC  @endif</td>
                    <td><a href="{{ route('detail.demande', $demande->id) }}" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
                    <td>{{$demande->numero_demande}}</td>
                    <td>{{$demande->legal_rep_name}}</td>
                    <td>{{$demande->denomination_social}}</td>
                    <td>{{$demande->sigle}}</td>
                    <td>{{$demande->objet_social}}</td>
                    <td>{{$demande->organisation_code}}</td>
                    <td>{{format_date($demande->date_paiement)}}</td>
                    
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>N°</th>
                    <th>Nom Commercial</th>
                    <th>Ref RCCM</th>
                    <th>Ref IFU</th>
                    <th>Ref CNSS</th>
                    <th>Ref CPC</th>
                    <th>Actions</th> 
                    <th>Numero Demande</th>
                    <th>Promoteur</th>                
                    <th>Dénomination Sociale</th>                
                    <th>Sigle</th>
                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    <th>Date Paiement</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
</div>
            <!-- /.card -->
@endsection