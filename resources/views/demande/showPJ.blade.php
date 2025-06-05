@extends("backend.adminlte.main")
@section('dashboard', 'active')
@section('content')

  <div class="card card-success col-md-12 col-md-offset-2">
    <div class="card-header">
      <h3 class="card-title">Detail sur la pièce</h3>
    </div>
<div class="row">
    <div class="col-md-4">
      <div class="table-responsive">
        <div class="col-lg-5">
                <!-- Nom document -->
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label>Type de pièce:</label>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label class="fb"> {{ $piecejointe->categorie_piece }}</label>
                  </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                      <label>Créer le:</label>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <label class="fb"> {{  format_date($piecejointe->created_at) }} </label>
                    </div>
               </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label>Dernière modif.:</label>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label class="fb"> {{ format_date($piecejointe->updated_at) }} </label>
                  </div>
                </div>
                <hr>
                <div class="form-group">
        <!-- <button type="button" class="btn btn-outline-danger me-2 cancel" onclick="history.back()"><i class="fas fa fa-ban"></i> Fermer</button> -->
                <a href="{{ route('detail.demande',$piecejointe->demande->id) }}" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>
                </div>
        </div>
      </div>
    </div>
        <div class="col-lg-7 img-bg" style="cursor: pointer;">
                <div style="box-shadow: 1px 2px 5px 1px #999">
                  <embed src= "{{ Storage::disk('local')->url($piecejointe->url) }}" height=600 type='application/pdf' style="width: 100%;" />
            </div>
        </div>
        </div>
      </div>
</div>
@endsection
