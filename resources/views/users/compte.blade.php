@extends("backend.adminlte.main")
@section('title', 'Comptes des promoteurs')
@section('compte', 'active')
@section('content')
@include('backend.adminlte.partials.filtre_periode', ['libelleDate' => 'Date de création du compte'])
<div class="card">
  <div class="card-body">
    {{-- Plus de 15 000 comptes : le serveur envoie une page à la fois (route user.compte.donnees) --}}
    <table id="tableau-comptes" class="table table-bordered table-striped align-middle w-100"
           data-ajax-url="{{ route('user.compte.donnees', array_filter(['du' => $periode['du'], 'au' => $periode['au']])) }}" data-tri="2,desc" data-non-triables="3,4">
      <thead>
        <tr>
          <th>Titulaire du compte</th>
          <th>E-mail</th>
          <th>Créé le</th>
          <th>Promoteur rattaché</th>
          <th>Demandes</th>
        </tr>
      </thead>
    </table>
    <p class="small text-muted mb-0 mt-2">
      <i class="fas fa-check-circle text-success" aria-hidden="true"></i> = adresse e-mail vérifiée par code.
      Recherche par nom, prénom ou e-mail. Les exports portent sur les lignes affichées.
    </p>
  </div>
</div>
@endsection
