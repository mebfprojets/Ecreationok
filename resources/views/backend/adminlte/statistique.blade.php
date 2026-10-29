@extends('backend.adminlte.main')
@section('title', 'Statistiques')
@section('statistique', 'active')
@section('content')
@php
    $nombre = fn ($v) => number_format((float) $v, 0, ',', ' ');
    $pourcentage = fn ($v) => $totaux['total'] > 0 ? round($v * 100 / $totaux['total']) : 0;
@endphp

{{-- Filtres --}}
<div class="card mb-4">
  <div class="card-body">
    <form action="{{ route('statistique') }}" method="get" class="row g-3 align-items-end">
      <div class="col-sm-6 col-lg-3">
        <label class="form-label" for="stat_du">Du</label>
        <input type="date" id="stat_du" name="du" value="{{ $du }}" class="form-control @error('du') is-invalid @enderror" max="{{ now()->format('Y-m-d') }}">
        @error('du')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-sm-6 col-lg-3">
        <label class="form-label" for="stat_au">Au</label>
        <input type="date" id="stat_au" name="au" value="{{ $au }}" class="form-control @error('au') is-invalid @enderror" max="{{ now()->format('Y-m-d') }}">
        @error('au')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      @if ($siege)
        <div class="col-sm-6 col-lg-3">
          <label class="form-label" for="stat_cefore">CEFORE</label>
          <select id="stat_cefore" name="cefore" class="form-select">
            <option value="">Tous les CEFORE</option>
            @foreach ($cefores as $cefore)
              <option value="{{ $cefore->CodeOrganisation }}" @if ($ceforeChoisi === $cefore->CodeOrganisation) selected @endif>{{ $cefore->Ville }}</option>
            @endforeach
          </select>
        </div>
      @endif
      <div class="col-sm-6 col-lg-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1" aria-hidden="true"></i>Afficher</button>
        <a href="{{ route('statistique') }}" class="btn btn-outline-secondary">Réinitialiser</a>
      </div>
    </form>
    <div class="small text-muted mt-2">
      Demandes créées du {{ \Carbon\Carbon::parse($du)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($au)->format('d/m/Y') }}
      — {{ $ceforeChoisi ? ($nomsCefore[$ceforeChoisi] ?? $ceforeChoisi) : 'tous les CEFORE' }}.
    </div>
  </div>
</div>

{{-- Chiffres clés --}}
<div class="row">
  @foreach ([
      ['Demandes', $totaux['total'], 'text-bg-primary', 'fa-folder-open', null],
      ['Payées', $totaux['payees'], 'text-bg-success', 'fa-check-circle', $pourcentage($totaux['payees'])],
      ['À valider', $totaux['a_valider'], 'text-bg-warning', 'fa-hourglass-half', null],
      ['Validées', $totaux['validees'], 'text-bg-info', 'fa-thumbs-up', $pourcentage($totaux['validees'])],
      ['Rejetées', $totaux['rejetees'], 'text-bg-danger', 'fa-times-circle', $pourcentage($totaux['rejetees'])],
  ] as [$libelle, $valeur, $couleur, $icone, $taux])
    <div class="col-6 col-md-4 col-xl">
      <div class="small-box {{ $couleur }}">
        <div class="inner">
          <h3>{{ $nombre($valeur) }}</h3>
          <p class="mb-0">{{ $libelle }}@if ($taux !== null) <small class="d-inline opacity-75">({{ $taux }} %)</small>@endif</p>
        </div>
        <i class="small-box-icon fas {{ $icone }}" aria-hidden="true"></i>
      </div>
    </div>
  @endforeach
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Détail par CEFORE</h3>
    <div class="card-tools small text-muted">Montant encaissé : <strong>{{ $nombre($totaux['montant']) }} FCFA</strong></div>
  </div>
  <div class="card-body">
    @if ($parCefore->isEmpty())
      <p class="text-muted mb-0">Aucune demande sur cette période.</p>
    @else
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>CEFORE</th>
            <th class="text-end">Demandes</th>
            <th class="text-end">Payées</th>
            <th class="text-end">Non payées</th>
            <th class="text-end">À valider</th>
            <th class="text-end">Validées</th>
            <th class="text-end">Rejetées</th>
            <th class="text-end">Montant encaissé (FCFA)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($parCefore as $ligne)
            <tr>
              <td>{{ $nomsCefore[$ligne->organisation_code] ?? $ligne->organisation_code }}</td>
              <td class="text-end">{{ $nombre($ligne->total) }}</td>
              <td class="text-end">{{ $nombre($ligne->payees) }}</td>
              <td class="text-end">{{ $nombre($ligne->non_payees) }}</td>
              <td class="text-end">{{ $nombre($ligne->a_valider) }}</td>
              <td class="text-end">{{ $nombre($ligne->validees) }}</td>
              <td class="text-end">{{ $nombre($ligne->rejetees) }}</td>
              <td class="text-end">{{ $nombre($ligne->montant) }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="fw-bold">
            <td>Total</td>
            <td class="text-end">{{ $nombre($totaux['total']) }}</td>
            <td class="text-end">{{ $nombre($totaux['payees']) }}</td>
            <td class="text-end">{{ $nombre($totaux['non_payees']) }}</td>
            <td class="text-end">{{ $nombre($totaux['a_valider']) }}</td>
            <td class="text-end">{{ $nombre($totaux['validees']) }}</td>
            <td class="text-end">{{ $nombre($totaux['rejetees']) }}</td>
            <td class="text-end">{{ $nombre($totaux['montant']) }}</td>
          </tr>
        </tfoot>
      </table>
    @endif
  </div>
</div>
@endsection
