@extends("backend.adminlte.main")
@section('dashboard', 'active')
@section('content')
  <div class="card card-success col-md-12 col-md-offset-2">
    <div class="card-header">
      <h3 class="card-title">Modifier sur la pièce {{ $piecejointe->categorie_piece}}</h3>
    </div>
<div class="card-body">
  <form method="POST"  action="{{route('update.pj', $piecejointe)}}" class="form-horizontal form-bordered" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{-- {{ method_field('PUT') }} --}}
<div class="form-group col-md-6">
    <label class=" control-label" for="">Numéro référence piece</label>
        <div class="input-group" >
            <div class="input-group">
                <input type="text" name="numero_ref"  class="form-control" value="{{$piecejointe->numero}}" required>
            </div>
        </div>
</div>

<div class="form-group col-md-6">
    <label class=" control-label" for="val_username">Date d'établissement</label>
        <div class="input-group" id="datepicker2">
            <input type="text" id="date_etablissement_u" name="date_detablissment" required class="form-control date_piecejointe" placeholder="dd-mm-yyyy"
             data-date-format="dd-mm-yyyy" data-date-container='#datepicker2' data-provide="datepicker" value="{{ format_date($piecejointe->date_etablissement)}}">
        </div>
</div>
<div class="form-group col-md-6">
    <label class=" control-label" for="val_username">Lieu d'établissement</label>
        <div class="input-group" >
            <!-- <input type="date" id="" name="date_detablissment" class="form-control " data-date-format="dd-mm-yyyy" placeholder="Date de naissance .." value="{{old('date_etablissment')}}" required > -->
            <div class="input-group">
                <input type="text" id="lieu_etablissement_u" name="lieu_etablissment" class="form-control"  value="{{$piecejointe->lieu_etablissement}}" required>
            </div>
        </div>
</div>
<div class="form-group{{ $errors->has('piece_jointe') ? ' has-error' : '' }}">
    <label class=" control-label" for="piece_contractuelle">Joindre la piece<span class="text-success">*</span></label>
    <!-- <input class="form-control" type="file" id='piece_jointe_u' name="piece_jointe" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de l'ordre de service" >   -->
    <div class="input-group col-md-6">
        <input class="form-control input_file" type="file" name="piece_jointe_u" id="piece_jointe" accept=".pdf, .jpeg, .png"   placeholder="Joindre une copie de la pièce" required  onchange="VerifyUploadSizeIsOK('piece_jointe_u');" >  
        <span class="input-group-addon"><i class="gi gi-file"></i></span>
    </div>   
    @if ($errors->has('piece_jointe'))
        <span class="help-block">
            <strong>{{ $errors->first('piece_jointe') }}</strong>
        </span>
    @endif
</div>
</div> 

<div class="panel-footer text-center">
<a href="{{ route('detail.demande',$piecejointe->demande->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
<input type="submit"   class="btn btn-sm btn-success"  value="Modifier">
</div>

</form>
  </div>
</div>
</div>
@endsection
