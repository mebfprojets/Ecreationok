@extends('layouts.frontend')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <center><h4>@if($demandes->company_type=="EI")
                      Entreprise Individuelle
                    @else
                    Entreprise Sociétaire
                    @endif
                    - {{$cefore_code}}</h4></center>
  <form action="{{ route('demande.update',$demandes->id)}}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
        <div class="card card-default">
          <div class="card-header">
            <h2 class="card-title btn btn-tool" data-card-widget="collapse">Entreprise</h2>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nom Commercial</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->commercial_name}}">
                  <input class="form-control save_demande" style="display:none" name="nom_commercial" type="text" value="{{$demandes->commercial_name}}">
                </div>
                <!-- /.form-group -->
                @if($demandes->company_type=="ES")
                <div class="form-group">
                  <label>Dénomination Sociale</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->denomination_social}}">
                  <input class="form-control save_demande" style="display:none" name="denomination_sociale" type="text" value="{{$demandes->denomination_social}}">                  
                </div>
                @endif
                <div class="form-group">
                  <label>Sigle</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->sigle}}">
                  <input class="form-control save_demande" style="display:none" name="sigle" type="text" value="{{$demandes->sigle}}">         
                </div>
                <div class="form-group">
                  <label>Enseigne</label>
                  <input class="form-control edit_demande" disabled="disabled" type="text" value="{{$demandes->enseigne}}">
                  <input class="form-control save_demande"  style="display:none" name="enseigne" type="text" value="{{$demandes->enseigne}}">         
                </div>
                <div class="form-group">
                  <label>Chiffre d'affaire Prévisionnel</label>
                  <input class="form-control edit_demande" disabled="disabled" type="number" value="{{$demandes->chiffre_daffaire_previsionel}}">
                  <input class="form-control save_demande" style="display:none" name="chiffre_daffaire" type="number" value="{{$demandes->chiffre_daffaire_previsionel}}">     

                </div> 
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                
                <div class="form-group">
                  <label>Forme Juridique</label>
                  <textarea class="form-control" disabled="disabled" value="{{$forme_juridiques->libelle}}" rows="2" placeholder="{{$forme_juridiques->libelle}}"></textarea>
                  <!-- <input class="form-control" disabled="disabled" type="text" value="">          -->
                </div>
                <div class="form-group">
                  <label>Activité Principale</label>
                  <textarea class="form-control" disabled="disabled" rows="2" placeholder="{{$activites->description}}"></textarea>
                </div>
                <div class="form-group">
                  <label>Objet Social</label>
                  <textarea class="form-control edit_demande" disabled="disabled" rows="6" value="{{$demandes->objet_social}}" placeholder="{{$demandes->objet_social}}"></textarea>
                  <textarea class="form-control save_demande" name="objet_social" style="display:none" rows="6" value="@php echo $demandes->objet_social @endphp"></textarea>
                  <!-- <input class="form-control" disabled="disabled" type="text" value="{{$demandes->objet_social}}">                   -->
                </div>
                
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Statut</label>
                  @if($demandes->paye==0)
                  <input class="form-control" disabled="disabled" type="text" value="Attente de Paiement">
                  @else                  
                  <input class="form-control" disabled="disabled" type="text" value="En traitement">
                  @endif      
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Date Création</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{ date("d-m-Y à H:i", strtotime($demandes->created_at)) }}">         
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
              <div class="col-md-4">
                
                <div class="form-group">
                  <label>Région</label>
                  <input class="form-control" disabled="disabled" type="textarea" value="{{$regions->name}}">         
                </div>
                <div class="form-group">
                  <label>Province</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$provinces->name}}">         
                </div>
                <div class="form-group">
                  <label>Commune</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$communes->name}}">         
                </div>
                <div class="form-group">
                  <label>Arrondissement</label>
                  <input class="form-control" disabled="disabled" type="text" value="Test">         
                </div>
                <div class="form-group">
                  <label>Secteur/Village</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$secteurs->name}}">         
                </div> 
                               
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">      
                <div class="form-group">
                  <label>Lot</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$terrains->numero_lot}}">                  
                </div>
                <div class="form-group">
                  <label>Section</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$terrains->numero_section}}">         
                </div>
                <div class="form-group">
                  <label>Parcelle</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$terrains->numero_parcelle}}">         
                </div> 
                <div class="form-group">
                  <label>Usage</label>
                  <input class="form-control" disabled="disabled" type="text" value="Test">         
                </div>                    
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              @if($demandes->company_type=="ES")
              <div class="col-md-4"> 
              
                <div class="form-group">
                  <label>Capital Social</label>
                  <input class="form-control" disabled="disabled" type="textarea" value="{{$demandes->capital_social}}">         
                </div> 
                <div class="form-group">
                  <label>Dont en numéraire</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->capital_en_numeraire}}">         
                </div>
                <div class="form-group">
                  <label>Dont en nature</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->capital_en_nature}}">         
                </div>
                <div class="form-group">
                  <label>Montant par action</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->montant_action}}">         
                </div>
                <div class="form-group">
                  <label>Nombre d'action</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$demandes->nbre_actions}}">         
                </div>

              </div>
              @endif 
                         
              <!-- /.col -->
            </div>         <br>   
            <center><a  style="margin-left:10px;" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration edit_demande" onclick="editdemande()" > <i class="fas fa-pen"></i> Corriger </a>
            <button type="submit" style="margin-left:10px;display:none" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success save_demande" > <i class="fas fa-pen"></i> Enregistrer </button>
            <a  style="margin-left:10px;" id="declaration_edit"  data-toggle="modal" style="display:none" class="btn btn-md btn-danger declaration save_demande" onclick="editdemande()" > <i class="fa fa-window-close"></i> Annuler </a>
          </center>

            <!-- /.row -->

           
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         
        </div>
        <!-- /.card -->
</form>
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Dirigeant</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button> -->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nom</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->NomRaisonSociale}}">
                </div>
                <div class="form-group">
                  <label>Prénom</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->Prenom}}">
                </div>
                <div class="form-group">
                  <label>Genre</label>
                  <input class="form-control" disabled="disabled" type="text" value="@if($usager->Gender==1) Féminin @else Masculin @endif">                  
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Date de naissance</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->DateNaissance}}">                  
                </div>
                <div class="form-group">
                  <label>Lieu de naissance</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->LieuNaissance}}">                  
                </div>
                <div class="form-group">
                  <label>Téléphone mobile</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->Phone_No_}}">         
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Téléphone bureau</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->Tel_Bureau}}">         
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Civilité</label>
                  <input class="form-control" disabled="disabled" type="text" value="@if($usager->Civility==1)Monsieur @elseif($usager->Civility==2)Madame @else Mademoiselle @endif">         
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Genre</label>
                  <input class="form-control" disabled="disabled" type="text" value="@if($usager->Gender==1) Féminin @else Masculin @endif">         
                </div>
                <div class="form-group">
                  <label>Profession</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{getlibelle($usager->IdFonction)}}"> 
                </div>
                <div class="form-group">
                  <label>Nationalité</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{getpays($usager->Nationality_No_)}}">         
                </div>   
                <div class="form-group">
                  <label>Situation matrimoniale</label>
                  <input class="form-control" disabled="disabled" type="text" value=" @if($usager->SituationMatrimoniale==1) Célibataire @elseif($usager->SituationMatrimoniale==2) Marié @else Divorcé @endif">         
                </div>   
                <div class="form-group">
                  <label>Boite Postale</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->Boite_postale}}">         
                </div>  
                <div class="form-group">
                  <label>E-mail</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->E_Mail}}">         
                </div>          
                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Région</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$regions->name}}">         
                </div>
                <div class="form-group">
                  <label>Province</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$provinces->name}}">         
                </div>
                <div class="form-group">
                  <label>Commune</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$communes->name}}">         
                </div>
                <div class="form-group">
                  <label>Arrondissement</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$usager->Civility}}">         
                </div>
                <div class="form-group">
                  <label>Secteur/Village</label>
                  <input class="form-control" disabled="disabled" type="text" value="{{$secteurs->name}}">         
                </div>
                <div class="form-group">
                  <label>Site Web</label>
                  <input class="form-control" disabled="disabled" type="text" value="test">         
                </div>
                <!-- /.form-group -->
                
                <!-- /.form-group -->
              </div>       
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          
          <!-- /.card-body -->
          
        </div>

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Pièces Jointes</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button> -->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
            @foreach($piecejointes as $piecejointe)
              <div class="col-md-3" style="padding:5px;">
                <div class="input-group">
                <!-- <label>Nom Pièce</label> -->
                <input class="form-control"  disabled="disabled" type="text" value="{{$piecejointe->type_piece}}">
                <a href="#updatepiecejointe" style="margin-left:10px;" id="declaration_edit"  data-toggle="modal" class="btn btn-md btn-success declaration" onclick="editpiecejointe('declaration')" > <i class="fas fa-pen"></i> </a>
                <a href="{{ route('detaildocument') }}?categoriepiece=declaration" style="margin-left:10px;" id="declaration_view"   class="btn btn-md btn-success declaration_view"> <i class="fas fa-eye"></i> </a>
                
                <!-- <a href="{{ route('detaildocument',$piecejointe->id)}}"title="Visualiser le document" class="btn btn-xs btn-default" ><i class="fa fa-eye"></i> </a> -->
                  <!-- <label>Nom et Prénom</label>
                  <input class="form-control" disabled="disabled" type="text" value="Test"> -->
                </div>
                <!-- /.form-group -->
                <!-- <div class="form-group">
                  <label>Date de naissance</label>
                  <input class="form-control" disabled="disabled" type="text" value="Test">                  
                </div> -->
                <!-- /.form-group -->
              </div>
            @endforeach
              <!-- /.col -->
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          
          <!-- /.card-body -->
          
        </div>
        <!-- /.card -->

      
        <!-- /.card -->

      
        <!-- /.row -->
       
        <!-- /.row -->
     
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection