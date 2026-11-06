@extends('backend.adminlte.main')
@section('title'){{ $dem === 'demande_a_valider' ? 'Demandes à valider' : 'Demandes validées' }}@endsection
@section($dem, 'active')
@section('content')
@include('backend.adminlte.partials.filtre_periode', ['libelleDate' => 'Date de dépôt'])
<div class="card">
  <div class="card-header">
    <h3 class="card-title">{{ $dem === 'demande_a_valider' ? 'Demandes à valider' : 'Demandes validées' }}</h3>
  </div>
  <div class="card-body">
    {{-- Rempli page par page par DemandeController::liste_demande_donnees (recherche et tri côté serveur, même période) --}}
    <table id="tableau-liste-demandes" class="table table-bordered table-striped w-100"
           data-ajax-url="{{ route('list.donnees', ['etat' => $etat] + array_filter(['du' => $periode['du'], 'au' => $periode['au']])) }}"
           data-tri="6,desc" data-non-triables="0,3,8,9">
      <thead>
        <tr>
          <th>N°</th>
          <th>Numéro demande</th>
          <th>Promoteur</th>
          <th>Statut</th>
          <th>Nom commercial</th>
          <th>Date création</th>
          <th>Date paiement</th>
          <th>Date validation</th>
          <th>Validée par</th>
          <th>Objet social</th>
          <th>CEFORE</th>
        </tr>
      </thead>
    </table>
    <p class="small text-muted mt-2 mb-0"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
      Les lignes surlignées ont déjà été rejetées une fois. La recherche porte aussi sur le nom de l’agent qui a validé.
      Les exports (Excel, PDF…) portent sur les lignes affichées : choisissez « 100 lignes par page » ou une période avant d’exporter.</p>
  </div>
</div>
@endsection
