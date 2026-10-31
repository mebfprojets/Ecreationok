@extends('backend.adminlte.main')
@section('title', 'Toutes les demandes')
@section('all', 'active')
@section('content')
    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-info">
              <div class="inner">
                <h3>{{$nbr}}</h3>
                <p>Demandes</p>
              </div>
              <i class="small-box-icon fas fa-folder-open" aria-hidden="true"></i>
              <a href="{{ route('list') }}" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-success">
              <div class="inner">
                <h3>{{$nbr_paye}}</h3>
                <p>Demandes Payées</p>
              </div>
              <i class="small-box-icon fas fa-check-circle" aria-hidden="true"></i>
              <a href="{{route('liste.filtre')}}?paye=1" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-warning">
              <div class="inner">
                <h3>{{$nbr_nonpaye}}</h3>

                <p>Attente de Paiement</p>
              </div>
              <i class="small-box-icon fas fa-hourglass-half" aria-hidden="true"></i>
              <a href="{{route('liste.filtre')}}?paye=0" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box text-bg-danger">
              <div class="inner">
                <h3>{{$nbr_rejet}}</h3>

                <p>Demandes Rejétées</p>
              </div>
              <i class="small-box-icon fas fa-times-circle" aria-hidden="true"></i>
              <a href="{{route('list.rejet')}}" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>          
          <!-- ./col -->
        </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <div class="card">
      <div class="card-body">
        {{-- Tableau rempli page par page par le serveur (route all.list.donnees) : recherche et tri portent sur toutes les demandes --}}
        <table id="tableau-toutes-demandes" class="table table-bordered table-striped w-100" data-ajax-url="{{ route('all.list.donnees') }}" data-tri="6,desc" data-non-triables="8">
          <thead>
            <tr>
              <th>N° demande</th>
              <th>Promoteur</th>
              <th>Paiement</th>
              <th>Nom commercial</th>
              <th>Dénomination sociale</th>
              <th>Sigle</th>
              <th>Création</th>
              <th>Activité principale</th>
              <th>Objet social</th>
              <th>CEFORE</th>
              <th>Paiement le</th>
            </tr>
          </thead>
        </table>
        <p class="small text-muted mb-0 mt-2">Les exports (Excel, PDF…) portent sur les lignes affichées : choisissez « 100 lignes par page » ou affinez la recherche avant d’exporter.</p>
      </div>
    </div>
@endsection
