@extends("backend.adminlte.main")
@section('administration', 'menu-open')
@section('administration-parametre', 'active')
@section('content')
<div class="block-title">
    <center><h2><strong>Liste des Paramètres</strong></h2></center>                    
</div>
<div class="card"> 
<div class="card-body">
      <a href="{{ route('parametres.create') }}" class="btn btn-success col-md-2 pull-right"><span><i class="fa fa-plus"></i></span>Parametres</a>
   
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>libelle</th>
                    <th>Description</th>
                    <th>Actions</th>
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
                        <td>{{ $i }}</td>
                        <td>{{ $parametre->libelle }} </td>
                        <td>{{ $parametre->description }}</td>
                        <td class="text-center">   
                                <a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a>
                                <a href="{{ route('parametres.edit',$parametre) }}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                <a  href="#modal-confirm-delete" data-csp-click="delConfirm" data-csp-click-args="{{ json_encode([($parametre->id)]) }}" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                    <th>N°</th>
                    <th>libelle</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection
<script nonce="{{ $cspNonce ?? '' }}">
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

