@extends("backend.adminlte.main")
 @section('administration', 'menu-open')
@section('administration-role', 'active')

@section('content')
<div class="block-title">
    <center><h2><strong>Liste des Rôles</strong></h2></center>                    
</div>
<div class="card"> 
 <!-- /.card-header -->
<div class="card-body">
    @can('user.create', Auth::user()) 
     <a href="{{ route('role.create') }}" class="btn btn-success col-md-2 pull-right mt-2"><span><i class="fa fa-plus"></i></span> Rôle</a>
   @endcan
   <br><br>
<table id="example1" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>N°</th>
                    <th>Libelle</th>
                    <th>Action</th>
                </tr>
        </thead>
        <tbody>
        @php
                        $i=0;
                            @endphp
                            @foreach($roles as $role)
                        @php
                        $i++;
                        @endphp
            
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$role->nom}}</td>
                    <td class="text-center">
                             {{-- @can('role.update', Auth::user()) --}}
                            <a href="#" class="btn btn-sm btn-success" style="background:#3393FF" title="Afficher les détais"> <i class="fa fa-eye"></i></a>
                                <a href="{{ route('role.edit',$role) }}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            {{-- @endcan --}}
                            @can('role.delete',Auth::user())
                                <a href="#modal-confirm-delete" data-csp-click="delConfirm" data-csp-click-args="{{ json_encode([($role->id)]) }}" data-toggle="modal" title="Supprimer" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                            @endcan
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>                  
                  <tr>
                    <th>N°</th>
                    <th>Libelle</th>
                    <th >Action</th>                
                  </tr>
                  </tfoot>
    </table>
</div>
</div>
@endsection
@section('modalSection')
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
                                <p>Voulez-vous vraiment Supprimer ce role ??</p>
                            <div class="form-group form-actions">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-sm btn-primary" data-csp-click="supp_id">OUI</button>
                                </div>
                            </div>

                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
    </div>
    <script nonce="{{ $cspNonce ?? '' }}">

    function detailUser(id){
                var id=id;

                $.ajax({
                    url: url,
                    type:'GET',
                    dataType:'json',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(data){
                        $("#nom_user").text(data.nomUser);
                        $("#prenom_user").text(data.prenomUser);
                        $("#email_user").text(data.emailUser);
                        $("#telephone_user").text(data.telephone);
                        $("#login_user").text(data.login);
                    }
                });
        }
        function idstatus (id){
            var id= id;

            $.ajax({
                url: url,
                type:'GET',
                data: {id: id} ,
                error:function(){alert('error');},
                success:function(){
                }

            });
        }
        function delConfirm (id){
            //alert(id);
            $(function(){
                //alert(id);
                document.getElementById("id_table").setAttribute("value", id);
            });

        }

        function recu_id(){
            //var id= document.getElementById('id_table').value;
            $(function(){
                var id= $("#id_table").val();

                //alert(id);
                $.ajax({
                    url: url,
                    type:'GET',
                    data: {id: id} ,
                    error:function(){alert('error');},
                    success:function(){
                        $('#modal-user-reinitialise').hide();
                        location.reload();

                    }
                });
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

