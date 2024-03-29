@extends("backend.adminlte.main")
@section('administration', 'menu-open')
@section('administration-permission', 'active')
@section('content')
<div class="block-title">
    <center><h2><strong>Liste des Permissions</strong></h2></center>                    
</div>
<div class="card">                           
              <!-- /.card-header -->
              <div class="card-body">
                    @can('user.create', Auth::user()) 
                        <a href="{{ route('permissions.create') }}" class="btn btn-block btn-success col-md-2 mt-2" type="button"><span><i class="fa fa-plus"></i></span>Permission</a>
                    @endcan
                    <br>

    <table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr style="background-color:#0b9e44; color:white">
                    <th>N°</th>
                    <th>Libelle</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>            
            @php
                        $i=0;
                            @endphp
                        @foreach($permissions as $permission)
                        @php
                        $i++;
                        @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$permission->name}}</td>
                    <td class="text-center">
                       
                    <a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a>
                            <a href="{{ route('permissions.edit', $permission) }}" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>                        
                                <a href="#modal-confirm-delete" onclick="delConfirm({{ $permission->id }});" style="background:#3393FF" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>                  
                  <tr>
                    <th>N°</th>
                    <th>Libelle</th>
                    <th>Action</th>                
                  </tr>
                  </tfoot>
    </table>
</div>
</div>
@endsection
@section('modalSection')

{{-- modal de confiramation de suppression  d'un utilisateur --}}
<div id="modal-confirm-delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Confirmation</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                        <input type="hidden" name="id_table" id="id_table">
                            <p>Voulez-vous vraiment Supprimer cette permission ??</p>
                        <div class="form-group form-actions">
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-sm btn-primary" onclick="supp_id();">OUI</button>
                            </div>
                        </div>

                </div>
                <!-- END Modal Body -->
            </div>
        </div>
</div>
    {{-- cette fonction javascript permet de definir l'action du formulaire dynamiquement. l'action route user reinitialise dans le formulaire dont id est reini_user --}}
    <script>

        function delConfirm (id){
            //alert(id);
            $(function(){
                //alert(id);
                document.getElementById("id_table").setAttribute("value", id);
            });

        }

        function supp_id(){
            $(function(){
                var id= $("#id_table").val();

               //alert(id);
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
            });
        }
    </script>
@endsection


