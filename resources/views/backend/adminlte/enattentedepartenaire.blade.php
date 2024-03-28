@extends('backend.adminlte.main')
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

                    <th>Nom Commercial</th>
                    <th>Dénomination Sociale</th>                
                    <th>Sigle</th>   
                    <th>Actions</th>       

                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    <th>Date Paiement</th>
                    <th>Ref RCCM</th>
                    <th>Ref IFU</th>
                    <th>Ref CNSS</th>
                    <th>Ref CPC</th>
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
                    <td>{{$demande->commercial_name}}</td>
                    <td>{{$demande->denomination_social}}</td>
                    <td>{{$demande->sigle}}</td>
                    <td><a href="{{ route('detail.demande', $demande->id) }}" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
                    <td>{{$demande->objet_social}}</td>
                    <td>{{$demande->organisation_code}}</td>
                    <td>{{format_date($demande->date_paiement)}}</td>
                    <td> {{($demande->RCCM)}} du{{($demande->DateRCCM)}}</td>
                    <td>@if($demande->IFU) {{($demande->DateIFU)}} du{{($demande->IFU)}}  @else En Attente de IFU  @endif</td>
                    <td>@if($demande->CNSS) {{($demande->CNSS)}} du{{($demande->DateCNSS)}}  @else En Attente de CNSS  @endif</td>
                    <td>@if($demande->CPC) {{($demande->CPC)}} du{{($demande->DateCPC)}}  @else En Attente de CPC  @endif</td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>N°</th>
                    <th>Numero Demande</th>
                    <th>Promoteur</th>

                    <th>Nom Commercial</th>
                    <th>Dénomination Sociale</th>                
                    <th>Sigle</th>   
                    <th>Actions</th>       

                    <th>Objet Social</th>
                    <th>CEFORE</th>
                    <th>Date Paiement</th>
                    <th>Ref RCCM</th>
                    <th>Ref IFU</th>
                    <th>Ref CNSS</th>
                    <th>Ref CPC</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
</div>
            <!-- /.card -->
@endsection