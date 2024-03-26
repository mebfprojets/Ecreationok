@extends("backend.adminlte.main")
@section('administration', 'menu-open')
@section('administration-parametre', 'active')
@section('content')
<div class="card card-success col-md-12 col-md-offset-2">
    <div class="card-header">
      <h3 class="card-title">Créer un paramètres</h3>
    </div>
      <a href="{{ route('parametres.create') }}" class="btn btn-success col-md-2 pull-right"><span><i class="fa fa-plus"></i></span>Parametres</a>
   


    <div class="table-responsive">
        <table id="" class="table table-vcenter table-condensed table-bordered listepdf">
            <thead>
                <tr>
                    <th class="text-center">Numéro</th>
                    <th class="text-center">libelle</th>
                    <th class="text-center" >Description</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                  $i=0;
                @endphp
                @foreach ($parametres as $parametre)
                        @php
                           $i++;
                        @endphp
                    <tr>
                        <td class="text-center" style="width: 10%">{{ $i }}</td>
                        <td class="text-center">{{ $parametre->libelle }} </td>
                        <td class="text-center">{{ $parametre->description }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('parametres.edit',$parametre) }}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                <a  href="#modal-confirm-delete" onclick="delConfirm({{ $parametre->id }});" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
<script>
    function delConfirm(id){
            //alert(id);
            document.getElementById("id_table").setAttribute("value", id);

    }
    function supp_id(){
            var id= $("#id_table").val();

            $.ajax({
                url: url,
                type:'GET',
                data: {id: id} ,
                error:function(){alert('error');},
                success:function(){
                    $('#modal-confirm-delete').hide();
                    location.reload();

                }
            });
    }
    </script>

