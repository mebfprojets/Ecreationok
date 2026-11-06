{{--
  Filtre par période (date de début, date de fin) au-dessus d'une liste de l'espace agents.
  Paramètres : $periode (Controller::periodeTableau), $libelleDate (date filtrée, ex. « Date de dépôt »).
  Les autres paramètres de l'adresse (etat, paye...) sont conservés.
--}}
@php
    $libelleDate = $libelleDate ?? 'Date de dépôt';
    $autresParametres = collect(request()->query())->except(['du', 'au'])->filter(fn ($v) => is_scalar($v))->all();
    $lienPeriode = fn ($du, $au) => url()->current().'?'.http_build_query($autresParametres + array_filter(['du' => $du, 'au' => $au]));
    $aujourdhui = now()->format('Y-m-d');
    $raccourcis = [
        ['Aujourd’hui', $aujourdhui, $aujourdhui],
        ['7 jours', now()->subDays(6)->format('Y-m-d'), $aujourdhui],
        ['Ce mois', now()->startOfMonth()->format('Y-m-d'), $aujourdhui],
        ['Cette année', now()->startOfYear()->format('Y-m-d'), $aujourdhui],
        ['Tout', null, null],
    ];
@endphp
<div class="card mb-3 filtre-periode-liste">
  <div class="card-body py-2">
    <form method="get" action="{{ url()->current() }}" class="d-flex flex-wrap align-items-end gap-2">
      @foreach ($autresParametres as $nom => $valeur)
        <input type="hidden" name="{{ $nom }}" value="{{ $valeur }}">
      @endforeach
      <div class="me-auto">
        <div class="small fw-semibold text-body-secondary mb-1"><i class="fas fa-calendar-alt me-1" aria-hidden="true"></i>{{ $libelleDate }}</div>
        <div class="d-flex flex-wrap gap-1" role="group" aria-label="Périodes prédéfinies">
          @foreach ($raccourcis as [$libelle, $du, $au])
            @php $choisie = $periode['du'] === $du && $periode['au'] === $au; @endphp
            <a href="{{ $lienPeriode($du, $au) }}" class="btn btn-sm {{ $choisie ? 'btn-success' : 'btn-outline-success' }}" @if ($choisie) aria-current="true" @endif>{{ $libelle }}</a>
          @endforeach
        </div>
      </div>
      <div>
        <label class="form-label small mb-1" for="filtre_du">Du</label>
        <input type="date" id="filtre_du" name="du" value="{{ $periode['du'] }}" max="{{ $aujourdhui }}" class="form-control form-control-sm">
      </div>
      <div>
        <label class="form-label small mb-1" for="filtre_au">Au</label>
        <input type="date" id="filtre_au" name="au" value="{{ $periode['au'] }}" max="{{ $aujourdhui }}" class="form-control form-control-sm">
      </div>
      <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-filter me-1" aria-hidden="true"></i>Filtrer</button>
    </form>
    @if ($periode['erreur'])
      <div class="alert alert-warning py-1 px-2 mt-2 mb-0 small">{{ $periode['erreur'] }}</div>
    @endif
    @if ($periode['active'])
      <div class="small mt-2">
        <span class="badge text-bg-success"><i class="fas fa-filter me-1" aria-hidden="true"></i>{{ $periode['libelle'] }}</span>
        <span class="text-muted ms-1">{{ mb_strtolower($libelleDate) }} comprise dans cette période</span>
        <a href="{{ $lienPeriode(null, null) }}" class="ms-2 small">Retirer le filtre</a>
      </div>
    @endif
  </div>
</div>
