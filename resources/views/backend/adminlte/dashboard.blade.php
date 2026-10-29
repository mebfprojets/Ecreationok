@extends('backend.adminlte.main')
@section('title', 'Tableau de bord')
@section('dashboard', 'active')
@section('content')
@php $nombre = fn ($v) => number_format((float) $v, 0, ',', ' '); @endphp

{{-- Chiffres clés : ce qui attend une action en premier --}}
<div class="row">
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-warning">
      <div class="inner">
        <h3>{{ $nombre($nbr_a_valider) }}</h3>
        <p class="mb-0">À valider</p>
      </div>
      <i class="small-box-icon fas fa-hourglass-half" aria-hidden="true"></i>
      <a href="{{ route('list') }}?etat=0" class="small-box-footer">Traiter <i class="fas fa-arrow-circle-right" aria-hidden="true"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-danger">
      <div class="inner">
        <h3>{{ $nombre($nbr_rejet) }}</h3>
        <p class="mb-0">En attente de correction</p>
      </div>
      <i class="small-box-icon fas fa-undo-alt" aria-hidden="true"></i>
      <a href="{{ route('list.rejet') }}" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right" aria-hidden="true"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-success">
      <div class="inner">
        <h3>{{ $nombre($nbr_validees) }}</h3>
        <p class="mb-0">Validées</p>
      </div>
      <i class="small-box-icon fas fa-check-circle" aria-hidden="true"></i>
      <a href="{{ route('list') }}?etat=1" class="small-box-footer">Consulter <i class="fas fa-arrow-circle-right" aria-hidden="true"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-primary">
      <div class="inner">
        <h3>{{ $nombre($nbr) }}</h3>
        <p class="mb-0">Demandes au total<small class="opacity-75">dont {{ $nombre($nbr_paye) }} payées</small></p>
      </div>
      <i class="small-box-icon fas fa-folder-open" aria-hidden="true"></i>
      <a href="{{ route('all.list') }}" class="small-box-footer">Toutes les demandes <i class="fas fa-arrow-circle-right" aria-hidden="true"></i></a>
    </div>
  </div>
</div>

{{-- Journal : les 50 dernières actions des agents, 25 par page --}}
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-history me-2" aria-hidden="true"></i>Dernières actions des agents</h3>
    <div class="card-tools small text-muted">{{ $siege ? 'Tous les CEFORE' : 'Votre CEFORE' }} · 50 dernières actions</div>
  </div>
  <div class="card-body">
    @if ($actions->isEmpty())
      <p class="text-muted mb-0">Aucune action enregistrée pour le moment.</p>
    @else
      <table id="journal-actions" class="table table-hover align-middle w-100">
        <thead>
          <tr>
            <th>Date</th>
            <th>Agent</th>
            <th>Action</th>
            <th>Demande</th>
            <th>Détail</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($actions as $action)
            <tr>
              <td class="text-nowrap" data-order="{{ optional($action->created_at)->timestamp }}">
                {{ optional($action->created_at)->format('d/m/Y') }}<br>
                <span class="small text-muted">{{ optional($action->created_at)->format('H:i') }}</span>
              </td>
              <td>
                @if ($action->agent)
                  {{ trim($action->agent->prenom.' '.$action->agent->name) }}
                  @if ($siege)<br><span class="small text-muted">{{ $action->organisation === '001000' ? 'Siège' : $action->organisation }}</span>@endif
                @else
                  <span class="text-muted">Agent supprimé</span>
                @endif
              </td>
              <td>
                <span class="badge text-bg-{{ $action->couleur() }}">
                  <i class="fas {{ $action->icone() }} me-1" aria-hidden="true"></i>{{ $action->libelle() }}
                </span>
              </td>
              <td>
                @if ($action->demande)
                  <a href="{{ route('detail.demande', $action->demande->id) }}" class="fw-semibold text-decoration-none">
                    {{ $action->demande->commercial_name ?: $action->demande->denomination_social }}
                  </a>
                  <br><span class="small text-muted">{{ $action->demande->numero_demande }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td class="small">
                @if ($action->detail)
                  <span title="{{ $action->detail }}">{{ \Illuminate\Support\Str::limit($action->detail, 90) }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
@endsection
