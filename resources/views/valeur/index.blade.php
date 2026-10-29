@extends("backend.adminlte.main")
@section('title', 'Valeurs')
@section('administration', 'menu-open')
@section('administration-valeur', 'active')
@section('content')
    <div class="form-group mt-2 row" >
            <label  class="col-md-4 control-label" for="parametre">Parametre concerné <span class="text-danger">*</span> :</label>
            <div class="col-md-8">
                <select   id="parametre" name="parametre"  class="form-control select-select2" data-csp-change="changelistevale">
                    <option></option>

                    @foreach($parametres as $parametre)
                    <option value="{{ $parametre->id }}">{{ $parametre->libelle }}</option>
                    @endforeach
                </select>
            </div>
        
    </div>
<div class="card">                           
              <!-- /.card-header -->
              <div class="card-body">
              @can('user.create', Auth::user())
            <a href="{{ route('valeurs.create') }}" class="btn btn-success col-md-2 float-end mt-2"><span><i class="fa fa-plus"></i></span>Valeur</a>
            @endcan<br><br>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style="background-color:#0b9e44; color:white">
                  
                    <th>N°</th>
                    <th>Libéllé</th>
                    <th>Description</th>
                    <th >Action</th>
                
                  </tr>
                  </thead>
                  <tbody>
                  @php
                  $i=0;
                @endphp
                @foreach ($valeurs as $valeur)
                        @php
                           $i++;
                        @endphp
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{ $valeur->libelle }} </td>
                    <td>{{$valeur->description}}</td>                                     
                    <td class="text-center">
                         @can('user.update',Auth::user())

                            <a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a>
                            <a href="{{ route('valeurs.edit',$valeur) }}" data-bs-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>

                         @endcan 
                    </td>                
                    
                  </tr>
            @endforeach
                  </tbody>
                  <tfoot>                  
                  <tr>
                    <th>N°</th>
                    <th>Libéllé</th>
                    <th>Description</th>
                    <th >Action</th>              
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
    </div>

@endsection
<script nonce="{{ $cspNonce ?? '' }}">
    function delConfirm(id){
            //alert(id);
            document.getElementById("id_table").setAttribute("value", id);

    }
    // Les libellés viennent de la base : on les échappe avant de les insérer dans le tableau
    function echapperHtml(texte) { return $('<div>').text(texte == null ? '' : String(texte)).html(); }
    function changelistevale()
         {   var idparent_val = $("#parametre").val();
         var url = '{{ route('valeur.listeval') }}';
             $.ajax({
                     url: url,
                     type: 'GET',
                     data: {idparent_val: idparent_val},
                     dataType: 'json',
                     error:function(data){alert("Erreur");},
                     success: function (data) {


                         var options = '';

                         for (var x = 1; x < data.length; x++) {
                             var rout= '{{ route("valeurs.edit",":id")}}';
                             var rout = rout.replace(':id', data[x]['id']);
                             options +='<tr> <td  width="5%" > ' + x + '</td><td width="20%" > ' + echapperHtml(data[x]['libelle']) + '</td><td  width="40%"> ' + echapperHtml(data[x]['description']) + '  </td> <td  width="15%"><div class="btn-group"><a  data-csp-click="detailvaleur" data-csp-click-args="[' + parseInt(data[x]['id'], 10) + ']" href="#modal-voir-detail" data-bs-toggle="modal" title="Voir details" class="btn btn-xs btn-outline-secondary"><i class="fa fa-eye"></i></a><a href="'+rout+'" data-bs-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a><a href="#modal-confirm-delete" data-csp-click="delConfirm" data-csp-click-args="[' + parseInt(data[x]['id'], 10) + ']" data-bs-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></div></td></tr>';
                              }
                        $('#tbadys').html(options);
                     }
             });
         }
    </script>

