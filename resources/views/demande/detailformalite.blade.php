@extends("backend.adminlte.main")
@section('dashboard', 'active')
@section('content')

  <div class="card card-success col-md-12 col-md-offset-2">
    <div class="card-header">
      <h3 class="card-title">Detail sur la formalite</h3>
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
                    <label class="fb"> {{ getlibelle($formalite->typepiece) }}</label>
                  </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                      <label>Créer le:</label>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <label class="fb"> {{  format_date($formalite->created_at) }} </label>
                    </div>
               </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label>Dernière modif.:</label>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label class="fb"> {{ format_date($formalite->updated_at) }} </label>
                  </div>
                </div>
                <hr>
                <div class="form-group">
                <a href="{{ route('detail.demande',$formalite->demande_id) }}" class="btn btn-sm btn-success"><i class="fa fa-repeat"></i> Fermer</a>
                </div>
        </div>
      </div>
    </div>
        <div class="col-lg-7 img-bg" style="cursor: pointer;">
                <div style="box-shadow: 1px 2px 5px 1px #999">
                  <embed src= "{{ Storage::disk('local')->url($formalite->url) }}" height=600 type='application/pdf' style="width: 100%;" />
            </div>
        </div>
        </div>
      </div>
</div>
@endsection
