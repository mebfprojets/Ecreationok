@extends("backend.adminlte.main")
@section('administration', 'menu-open')
@section('administration-valeur', 'active')
@section('content')
<div class="block-title">
    <center><h2><strong>Liste des Valeurs</strong></h2></center>                    
</div>
    <div class="form-group mt-2 row" >
            <label  class="col-md-4 control-label" for="parametre">Parametre concerné <span class="text-danger">*</span> :</label>
            <div class="col-md-8">
                <select   id="parametre" name="parametre"  class="form-control select-select2" onchange="changelistevale();">
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
            <a href="{{ route('valeurs.create') }}" class="btn btn-success col-md-2 pull-right mt-2"><span><i class="fa fa-plus"></i></span>Valeur</a>
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
                            <a href="{{ route('valeurs.edit',$valeur) }}" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>

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
<script>
    function delConfirm(id){
            //alert(id);
            document.getElementById("id_table").setAttribute("value", id);

    }
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
                             options +='<tr> <td  width="5%" > ' + x + '</td><td width="20%" > ' + data[x]['libelle'] + '</td><td  width="40%"> ' + data[x]['description'] + '  </td> <td  width="15%"><div class="btn-group"><a  onclick="detailvaleur(' + data[x]['id'] + ' );" href="#modal-voir-detail" data-toggle="modal" title="Voir details" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a><a href="'+rout+'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a><a href="#modal-confirm-delete" onclick="delConfirm(' + data[x]['id'] + ');" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a></div></td></tr>';
                              }
                        $('#tbadys').html(options);
                     }
             });
         }
    </script>

