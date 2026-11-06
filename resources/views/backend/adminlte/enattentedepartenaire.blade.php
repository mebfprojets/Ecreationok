@extends('backend.adminlte.main')
@section('title', 'En attente des partenaires')
@section('liste_partenaire', 'active')
@section('content')
@include('backend.adminlte.partials.filtre_periode', ['libelleDate' => 'Date de dépôt'])
<div class="card">

<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-info">
              <div class="inner">
                <h3>{{$rccm}}</h3>
                <p>Attente RCCM</p>
              </div>
              <i class="small-box-icon fas fa-folder-open" aria-hidden="true"></i>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-success">
              <div class="inner">
                <h3>{{$ifu}}</h3>
                <p>Attente IFU</p>
              </div>
              <i class="small-box-icon fas fa-check-circle" aria-hidden="true"></i>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-warning">
              <div class="inner">
                <h3>{{$cnss}}</h3>

                <p>Attente CNSS</p>
              </div>
              <i class="small-box-icon fas fa-hourglass-half" aria-hidden="true"></i>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-danger">
              <div class="inner">
                <h3>{{$cpc}}</h3>

                <p>Attente CPC</p>
              </div>
              <i class="small-box-icon fas fa-times-circle" aria-hidden="true"></i>
              <a href="#" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>          
          <!-- ./col -->
        </div>
                          
              <div class="card-body">
                {{-- Rempli page par page par DemandeController::liste_partenaires_donnees (recherche et tri côté serveur, même période) --}}
                <table id="tableau-partenaires" class="table table-bordered table-striped w-100"
                       data-ajax-url="{{ route('list.partenaires.donnees', array_filter(['du' => $periode['du'], 'au' => $periode['au']])) }}"
                       data-tri="12,desc" data-non-triables="0,10">
                  <thead>
                  <tr>
                    <th>N°</th>
                    <th>Nom commercial</th>
                    <th>Réf. RCCM</th>
                    <th>Réf. IFU</th>
                    <th>Réf. CNSS</th>
                    <th>Réf. CPC</th>
                    <th>Numéro demande</th>
                    <th>Promoteur</th>
                    <th>Dénomination sociale</th>
                    <th>Sigle</th>
                    <th>Objet social</th>
                    <th>CEFORE</th>
                    <th>Date paiement</th>
                  </tr>
                  </thead>
                </table>
                <p class="small text-muted mt-2 mb-0"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
                  La recherche porte aussi sur les numéros RCCM, IFU, CNSS et CPC.
                  Les exports (Excel, PDF…) portent sur les lignes affichées : choisissez « 100 lignes par page » ou une période avant d’exporter.</p>
              </div>
</div>
            <!-- /.card -->
@endsection