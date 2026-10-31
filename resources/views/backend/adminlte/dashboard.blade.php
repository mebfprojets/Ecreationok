@extends('backend.adminlte.main')
@section('title', 'Tableau de bord')
@section('dashboard', 'active')
@section('content')
@php
    $nombre = fn ($v) => number_format((float) $v, 0, ',', ' ');
    $part = fn ($v, $sur) => $sur > 0 ? round($v * 100 / $sur) : 0;
    // Parcours d'une demande : [libellé, clé, couleur, icône, lien éventuel, explication]
    $etapes = [
        ['Attente de paiement', 'attente_paiement', 'secondary', 'fa-credit-card', route('liste.filtre').'?paye=0', 'Demande enregistrée, pas encore payée'],
        ['À valider', 'a_valider', 'warning', 'fa-hourglass-half', route('list').'?etat=0', 'Payée, en attente de la décision du CEFORE'],
        ['Rejetées', 'rejetees', 'danger', 'fa-undo-alt', route('list.rejet'), 'Correction demandée au promoteur'],
        ['Validées', 'validees', 'success', 'fa-check-circle', route('list').'?etat=1', 'Validées par le CEFORE (toutes étapes suivantes)'],
        ['Attente RCCM', 'attente_rccm', 'info', 'fa-stamp', null, 'Validées, numéro RCCM pas encore saisi'],
        ['Attente partenaires', 'attente_partenaires', 'primary', 'fa-handshake', route('list.en_attente_de_partenaire'), 'RCCM obtenu ; IFU, CNSS ou CPC en attente'],
        ['Traitées', 'traitees', 'dark', 'fa-flag-checkered', null, 'Toutes les formalités sont faites'],
    ];
    // Raccourcis de période : [libellé, du, au] (sans date : toute la période)
    $aujourdhui = now()->format('Y-m-d');
    $periodesRapides = [
        ['Aujourd’hui', $aujourdhui, $aujourdhui],
        ['7 derniers jours', now()->subDays(6)->format('Y-m-d'), $aujourdhui],
        ['30 derniers jours', now()->subDays(29)->format('Y-m-d'), $aujourdhui],
        ['Ce mois', now()->startOfMonth()->format('Y-m-d'), $aujourdhui],
        ['Cette année', now()->startOfYear()->format('Y-m-d'), $aujourdhui],
        ['Tout', null, null],
    ];
    $sansDonnees = $periode['active'] ? 'sur cette période' : 'pour le moment';
@endphp

{{-- Période : actualise l'ensemble du tableau de bord --}}
<div class="card mb-4 filtre-periode">
  <div class="card-body py-3">
    <form action="{{ route('dashboard') }}" method="get" class="row g-2 align-items-end">
      <div class="col-12 col-xl">
        <div class="form-label small fw-semibold mb-1"><i class="fas fa-calendar-alt me-1 text-secondary" aria-hidden="true"></i>Période</div>
        <div class="d-flex flex-wrap gap-1" role="group" aria-label="Périodes prédéfinies">
          @foreach ($periodesRapides as [$libelle, $du, $au])
            @php $choisie = $periode['du'] === $du && $periode['au'] === $au; @endphp
            <a href="{{ route('dashboard', array_filter(['du' => $du, 'au' => $au])) }}"
               class="btn btn-sm {{ $choisie ? 'btn-success' : 'btn-outline-success' }}" @if ($choisie) aria-current="true" @endif>{{ $libelle }}</a>
          @endforeach
        </div>
      </div>
      <div class="col-6 col-sm-4 col-xl-auto">
        <label class="form-label small fw-semibold mb-1" for="periode_du">Du</label>
        <input type="date" id="periode_du" name="du" value="{{ $periode['du'] }}" max="{{ $aujourdhui }}" class="form-control form-control-sm">
      </div>
      <div class="col-6 col-sm-4 col-xl-auto">
        <label class="form-label small fw-semibold mb-1" for="periode_au">Au</label>
        <input type="date" id="periode_au" name="au" value="{{ $periode['au'] }}" max="{{ $aujourdhui }}" class="form-control form-control-sm">
      </div>
      <div class="col-12 col-sm-4 col-xl-auto">
        <button type="submit" class="btn btn-sm btn-success w-100"><i class="fas fa-sync-alt me-1" aria-hidden="true"></i>Actualiser</button>
      </div>
    </form>
    @if ($periode['erreur'])
      <div class="alert alert-warning py-2 mt-2 mb-0 small">{{ $periode['erreur'] }}</div>
    @endif
    <div class="small text-muted mt-2">
      <i class="fas fa-info-circle me-1" aria-hidden="true"></i><strong class="text-body">{{ $periode['libelle'] }}</strong>
      @if ($periode['active'])
        — demandes créées sur la période (avec leur état actuel), décisions et actions des agents sur la période.
      @else
        — toutes les demandes et toutes les actions enregistrées.
      @endif
    </div>
  </div>
</div>

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
    <div class="small-box boite-vert-nuit">
      <div class="inner">
        <h3>{{ $nombre($nbr) }}</h3>
        <p class="mb-0">Demandes au total<small class="opacity-75">dont {{ $nombre($nbr_paye) }} payées</small></p>
      </div>
      <i class="small-box-icon fas fa-folder-open" aria-hidden="true"></i>
      <a href="{{ route('all.list') }}" class="small-box-footer">Toutes les demandes <i class="fas fa-arrow-circle-right" aria-hidden="true"></i></a>
    </div>
  </div>
</div>

{{-- Types d'entreprise et parcours des demandes --}}
<div class="row">
  <div class="col-xl-4">
    <div class="card mb-4">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-building me-2 text-secondary" aria-hidden="true"></i>Type d’entreprise</h3></div>
      <div class="card-body">
        @foreach ([['Personnes physiques', 'physique', 'success', 'fa-user', 'Entreprises individuelles'], ['Personnes morales', 'morale', 'warning', 'fa-building', 'Sociétés']] as [$libelle, $cle, $couleur, $icone, $aide])
          <div class="d-flex align-items-center gap-3 {{ $loop->first ? 'mb-4' : '' }}">
            <span class="icone-indicateur text-bg-{{ $couleur }}"><i class="fas {{ $icone }}" aria-hidden="true"></i></span>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-baseline">
                <span class="fw-semibold">{{ $libelle }}</span>
                <span class="fs-4 fw-bold">{{ $nombre($totaux[$cle]) }}</span>
              </div>
              <div class="progress mt-1" role="progressbar" aria-label="{{ $libelle }}" aria-valuenow="{{ $part($totaux[$cle], $totaux['total']) }}" aria-valuemin="0" aria-valuemax="100" style="height: 8px;">
                <div class="progress-bar bg-{{ $couleur }}" style="width: {{ $part($totaux[$cle], $totaux['total']) }}%"></div>
              </div>
              <div class="small text-muted mt-1">{{ $aide }} · {{ $part($totaux[$cle], $totaux['total']) }} % des demandes</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="col-xl-8">
    <div class="card mb-4">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-route me-2 text-secondary" aria-hidden="true"></i>Parcours des demandes</h3>
        <div class="card-tools small text-muted">{{ $siege ? 'Tous les CEFORE' : 'Votre CEFORE' }} · {{ $nombre($totaux['total']) }} demandes</div>
      </div>
      <div class="card-body">
        <div class="grille-etapes">
          @foreach ($etapes as [$libelle, $cle, $couleur, $icone, $lien, $aide])
            @php $contenu = '<div class="d-flex justify-content-between align-items-start"><span class="small fw-semibold text-body-secondary">'.e($libelle).'</span>'
                .'<i class="fas '.$icone.' text-'.$couleur.'" aria-hidden="true"></i></div>'
                .'<div class="fs-4 fw-bold text-body">'.$nombre($totaux[$cle]).'</div>'
                .'<div class="small text-muted">'.$part($totaux[$cle], $totaux['total']).' %</div>'; @endphp
            @if ($lien)
              <a href="{{ $lien }}" class="etape etape-lien border-{{ $couleur }}" title="{{ $aide }}">{!! $contenu !!}</a>
            @else
              <div class="etape border-{{ $couleur }}" title="{{ $aide }}">{!! $contenu !!}</div>
            @endif
          @endforeach
        </div>
        <div class="small text-muted mt-2"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>Les validées se répartissent entre attente RCCM, attente partenaires et traitées.</div>
      </div>
    </div>
  </div>
</div>

{{-- Situation par CEFORE --}}
<div class="card mb-4">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-map-marked-alt me-2 text-secondary" aria-hidden="true"></i>Situation par CEFORE</h3>
  </div>
  <div class="card-body">
    @if ($parCefore->isEmpty())
      <p class="text-muted mb-0">Aucune demande {{ $sansDonnees }}.</p>
    @else
      <table id="example1" class="table table-bordered table-striped table-sm align-middle tableau-cefore">
        <thead>
          <tr>
            <th>CEFORE</th>
            <th class="text-end">Total</th>
            <th class="text-end">Physiques</th>
            <th class="text-end">Morales</th>
            <th class="text-end">Attente paiement</th>
            <th class="text-end">Payées</th>
            <th class="text-end">À valider</th>
            <th class="text-end">Rejetées</th>
            <th class="text-end">Validées</th>
            <th class="text-end">Attente RCCM</th>
            <th class="text-end">Attente partenaires</th>
            <th class="text-end">Traitées</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($parCefore as $ligne)
            <tr>
              <td class="fw-semibold text-nowrap">{{ $nomsCefore[$ligne->organisation_code] ?? $ligne->organisation_code }}</td>
              @foreach (array_keys($totaux) as $cle)
                <td class="text-end" data-order="{{ (int) $ligne->$cle }}">
                  @if (in_array($cle, ['a_valider', 'attente_rccm', 'attente_partenaires'], true) && $ligne->$cle > 0)
                    <span class="badge text-bg-{{ ['a_valider' => 'warning', 'attente_rccm' => 'info', 'attente_partenaires' => 'primary'][$cle] }}">{{ $nombre($ligne->$cle) }}</span>
                  @else
                    {{ $nombre($ligne->$cle) }}
                  @endif
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
        @if ($parCefore->count() > 1)
          <tfoot>
            <tr class="fw-bold">
              <td>Total</td>
              @foreach ($totaux as $valeur)
                <td class="text-end">{{ $nombre($valeur) }}</td>
              @endforeach
            </tr>
          </tfoot>
        @endif
      </table>
    @endif
  </div>
</div>

{{-- Validations et rejets par agent --}}
<div class="card mb-4">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-user-check me-2 text-secondary" aria-hidden="true"></i>Décisions par agent</h3>
    <div class="card-tools small text-muted">{{ $siege ? 'Tous les CEFORE' : 'Agents de votre CEFORE' }} · validations et rejets · {{ $periode['libelle'] }}</div>
  </div>
  <div class="card-body">
    @if ($statsAgents->isEmpty())
      <p class="text-muted mb-0">Aucune décision enregistrée {{ $sansDonnees }}.</p>
    @else
      <table class="table table-bordered table-striped table-sm align-middle tableau-export w-100">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom(s)</th>
            <th>CEFORE</th>
            <th class="text-end">Validations</th>
            <th class="text-end">Rejets</th>
            <th class="text-end">Total</th>
            <th>Répartition</th>
            <th>Dernière décision</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($statsAgents as $agent)
            <tr>
              <td class="fw-semibold">{{ $agent->nom }}</td>
              <td>{{ $agent->prenom }}</td>
              <td class="text-nowrap">{{ $agent->organisation === '001000' ? 'Siège' : ($nomsCefore[$agent->organisation] ?? $agent->organisation) }}</td>
              <td class="text-end" data-order="{{ $agent->validations }}"><span class="text-success fw-semibold">{{ $nombre($agent->validations) }}</span></td>
              <td class="text-end" data-order="{{ $agent->rejets }}"><span class="text-danger fw-semibold">{{ $nombre($agent->rejets) }}</span></td>
              <td class="text-end fw-bold" data-order="{{ $agent->total }}">{{ $nombre($agent->total) }}</td>
              <td data-order="{{ $agent->taux_rejet }}" style="min-width: 140px;">
                <div class="progress" style="height: 8px;" role="progressbar" aria-label="Part des rejets" aria-valuenow="{{ $agent->taux_rejet }}" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-success" style="width: {{ 100 - $agent->taux_rejet }}%"></div>
                  <div class="progress-bar bg-danger" style="width: {{ $agent->taux_rejet }}%"></div>
                </div>
                <div class="small text-muted mt-1">{{ $agent->taux_rejet }} % de rejets</div>
              </td>
              <td class="text-nowrap" data-order="{{ optional($agent->derniere_action)->timestamp }}">{{ optional($agent->derniere_action)->format('d/m/Y H:i') ?? '—' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>

{{-- Journal : les 50 dernières actions des agents, 25 par page --}}
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-history me-2" aria-hidden="true"></i>Dernières actions des agents</h3>
    <div class="card-tools small text-muted">{{ $siege ? 'Tous les CEFORE' : 'Votre CEFORE' }} · 50 dernières actions · {{ $periode['libelle'] }}</div>
  </div>
  <div class="card-body">
    @if ($actions->isEmpty())
      <p class="text-muted mb-0">Aucune action enregistrée {{ $sansDonnees }}.</p>
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
