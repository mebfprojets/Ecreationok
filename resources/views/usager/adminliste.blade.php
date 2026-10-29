@extends("backend.adminlte.main")
@section('title', 'Promoteurs')
@section('promoteur', 'active')
@section('content')
<div class="card">
  <div class="card-body">
    {{-- Plus de 14 000 promoteurs : le serveur envoie une page à la fois (route promoteur.liste.donnees) --}}
    <table id="tableau-promoteurs" class="table table-bordered table-striped align-middle w-100"
           data-ajax-url="{{ route('promoteur.liste.donnees') }}" data-tri="3,desc" data-non-triables="5,6">
      <thead>
        <tr>
          <th>Nom et prénom(s)</th>
          <th>Né(e) le</th>
          <th>N° pièce d’identité</th>
          <th>Inscrit le</th>
          <th>Compte e-Création</th>
          <th>Dernière demande</th>
          <th>Demandes</th>
        </tr>
      </thead>
    </table>
    <p class="small text-muted mb-0 mt-2">Recherche par nom, prénom, n° de pièce ou e-mail. Les exports portent sur les lignes affichées.</p>
  </div>
</div>
@endsection
