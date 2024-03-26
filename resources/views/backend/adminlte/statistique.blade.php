@extends('backend.adminlte.main')
@section('statistique', 'active')
@section('content')
<div class="card">
              <div class="card-header">
               <strong><h3 class="card-title">
                Liste des Demandes
              </h3></strong>
              </div>
              <form action="{{route('statistique')}}">
                <select name="cefore" id="">
                    @foreach($cefores as $cefore)
                    <option value="{{$cefore->CodeOrganisation}}">{{$cefore->CodeOrganisation}}</option>
                    @endforeach
                </select>
                <!-- <div class="form-group">
                  <label>Date de début</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="date" name="datedebut" class="form-control float-right" id="reservation">
                  </div>
                  <label>Date de fin</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="date" name="datefin" class="form-control float-right" id="reservation">
                  </div>
                </div> -->
                <input type="submit" value="Valider">
                <a href="{{route('statistique')}}?reset=1">Reset</a>
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
                    <th>Date Création</th>
                    <th>Date Validation</th>
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
                    <td>@if($demande->paye==1) Payé @else Non Payé @endif</td>
                    <td>{{$demande->commercial_name}}</td>
                    <td>{{$demande->denomination_social}}</td>
                    <td>{{$demande->sigle}}</td>
                    <td><a href="{{ route('detail.demande', $demande->id) }}" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a></td>
                    <td>{{format_date($demande->created_at)}}</td>
                    <td>{{format_date($demande->Date_etat_validation)}}</td>
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
                    <th>Date Validation</th>
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
            <!-- /.card -->
<script>
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
</script>
@endsection