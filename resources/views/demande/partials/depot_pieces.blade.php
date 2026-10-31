{{--
  Dépôt des pièces avant le formulaire de demande (entreprise individuelle, sociétaire ou GIE).
  Variables : $type (ei, es, gie), $documentsParCategorie (pièces déjà déposées, par catégorie), $usager.
  Comportement (choix, contrôle, aperçu, annulation, pièces manquantes) : public/js/depot-pieces.js
--}}
@php
    $pieces = \App\Models\PieceJointe::piecesADeposer($type);
    $titresType = ['ei' => 'Entreprise individuelle', 'es' => 'Entreprise sociétaire', 'gie' => 'Groupement d’intérêt économique'];
    $deposees = collect($pieces)->keys()->filter(fn ($c) => isset($documentsParCategorie[$c]))->count();
    $cnib = $documentsParCategorie['piece_didentite'] ?? null;
@endphp
<div class="container parcours-demande">
  <nav aria-label="Étapes de la demande" class="etapes-parcours">
    <a href="{{ route('type.entreprise') }}" class="etape-parcours faite"><span class="etape-numero"><i class="fas fa-check" aria-hidden="true"></i></span>Type d’entreprise</a>
    <span class="etape-parcours active"><span class="etape-numero">2</span>Pièces à fournir</span>
    <span class="etape-parcours"><span class="etape-numero">3</span>Formulaire</span>
    <span class="etape-parcours"><span class="etape-numero">4</span>Paiement</span>
  </nav>

  <h1 class="titre-parcours">Pièces à fournir <span class="titre-parcours-type">{{ $titresType[$type] ?? '' }}</span></h1>
  <p class="sous-titre-parcours">Déposez chaque pièce dans le bon emplacement. Les pièces déjà déposées sont conservées : remplacez-les seulement si nécessaire.</p>

  @include('demande.partials.promoteur', ['variante' => 'bandeau'])

  @if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <strong>Les pièces n’ont pas été enregistrées :</strong>
      <ul class="mb-0 mt-1">@foreach ($errors->all() as $erreur)<li>{{ $erreur }}</li>@endforeach</ul>
    </div>
  @endif
  {{-- Rempli par le script quand des pièces manquent au moment de l'envoi --}}
  <div class="alert alert-danger d-none" role="alert" tabindex="-1" data-resume-erreurs></div>

  <form action="{{ route('piece.store') }}" method="POST" enctype="multipart/form-data" id="piecesJointesForm" novalidate data-depot-pieces>
    @csrf
    <input type="hidden" name="type_entreprise" value="{{ $type }}">

    <div class="suivi-depot">
      <div class="d-flex justify-content-between align-items-baseline mb-1">
        <span class="fw-semibold">Pièces prêtes</span>
        <span><strong data-compteur-pretes>{{ $deposees }}</strong> sur {{ count($pieces) }}</span>
      </div>
      <div class="progress" role="progressbar" aria-label="Pièces prêtes" aria-valuemin="0" aria-valuemax="{{ count($pieces) }}" aria-valuenow="{{ $deposees }}" data-barre-pretes>
        <div class="progress-bar bg-success" style="width: {{ count($pieces) ? round($deposees * 100 / count($pieces)) : 0 }}%"></div>
      </div>
    </div>

    <div class="row g-3">
      @foreach ($pieces as $categorie => [$libelle, $precision, [$accepte, $libelleFormat], $tailleMax])
        @php $existante = $documentsParCategorie[$categorie] ?? null; @endphp
        <div class="col-lg-6">
          <div class="carte-piece {{ $existante ? 'etat-deposee' : 'etat-vide' }}" data-piece="{{ $categorie }}" data-taille-max="{{ $tailleMax }}"
               data-libelle="{{ $libelle }}" data-existante="{{ $existante ? '1' : '0' }}">
            <div class="carte-piece-entete">
              <span class="carte-piece-statut" aria-hidden="true"><i class="fas fa-check"></i></span>
              <div class="flex-grow-1">
                <label class="carte-piece-titre" for="fichier_{{ $categorie }}">{{ $libelle }} <span class="text-danger" title="Obligatoire">*</span></label>
                <div class="carte-piece-aide">
                  @if ($precision){{ $precision }} · @endif{{ $libelleFormat }}, {{ $tailleMax }} Mo maximum
                </div>
              </div>
            </div>

            {{-- Fichier : déjà déposé, nouveau (choisi) ou absent --}}
            <div class="carte-piece-fichier">
              <i class="fas {{ $libelleFormat === 'PDF' ? 'fa-file-pdf' : 'fa-file-image' }} carte-piece-fichier-icone" aria-hidden="true"></i>
              <div class="flex-grow-1 text-truncate">
                <div class="carte-piece-nom text-truncate" data-nom-fichier
                     data-nom-existant="{{ $existante ? basename($existante->url_local) : '' }}">{{ $existante ? basename($existante->url_local) : 'Aucun fichier' }}</div>
                <div class="carte-piece-etat" data-etat-fichier
                     data-etat-existant="{{ $existante ? 'Déposée le '.optional($existante->updated_at ?? $existante->created_at)->format('d/m/Y') : 'À déposer' }}">{{ $existante ? 'Déposée le '.optional($existante->updated_at ?? $existante->created_at)->format('d/m/Y') : 'À déposer' }}</div>
              </div>
            </div>

            <input type="file" class="d-none" id="fichier_{{ $categorie }}" name="{{ $categorie }}" accept="{{ $accepte }}" data-fichier>
            <div class="carte-piece-actions">
              <button type="button" class="btn btn-sm btn-success" data-choisir>
                <i class="fas fa-upload me-1" aria-hidden="true"></i><span data-libelle-choisir>{{ $existante ? 'Remplacer' : 'Choisir un fichier' }}</span>
              </button>
              <a href="{{ $existante ? route('piecejointe.voir', $existante->id) : '#' }}" target="_blank" rel="noopener"
                 class="btn btn-sm btn-outline-secondary {{ $existante ? '' : 'd-none' }}" data-voir data-voir-existant="{{ $existante ? route('piecejointe.voir', $existante->id) : '' }}">
                <i class="fas fa-eye me-1" aria-hidden="true"></i>Voir
              </a>
              <button type="button" class="btn btn-sm btn-link text-danger d-none" data-annuler>
                <i class="fas fa-undo me-1" aria-hidden="true"></i>{{ $existante ? 'Garder l’ancienne pièce' : 'Retirer' }}
              </button>
            </div>
            <div class="carte-piece-erreur d-none" role="alert" data-erreur></div>

            {{-- Pièce d'identité : références du document --}}
            @if ($categorie === 'piece_didentite')
              <div class="carte-piece-complement">
                @if ($cnib)
                  <div class="row g-2 small">
                    <div class="col-sm-4"><span class="text-muted d-block">Numéro</span><strong>{{ $cnib->numero ?: 'Non renseigné' }}</strong></div>
                    <div class="col-sm-4"><span class="text-muted d-block">Établie le</span><strong>{{ $cnib->date_etablissement ? \Carbon\Carbon::parse($cnib->date_etablissement)->format('d/m/Y') : 'Non renseignée' }}</strong></div>
                    <div class="col-sm-4"><span class="text-muted d-block">Expire le</span><strong>{{ $cnib->date_etablissement ? \Carbon\Carbon::parse($cnib->date_etablissement)->addYears(10)->subDay()->format('d/m/Y') : '—' }}</strong></div>
                  </div>
                @else
                  <div class="row g-2">
                    <div class="col-sm-5">
                      <label for="reference_cnib" class="form-label small mb-1">Numéro de la pièce <span class="text-danger">*</span></label>
                      <input type="text" id="reference_cnib" name="reference" class="form-control form-control-sm" value="{{ old('reference') }}" maxlength="50" data-obligatoire="Saisissez le numéro de la pièce d’identité.">
                    </div>
                    <div class="col-sm-4">
                      <label for="date_etablissement" class="form-label small mb-1">Établie le <span class="text-danger">*</span></label>
                      <input type="date" id="date_etablissement" name="date_etablissement" class="form-control form-control-sm" value="{{ old('date_etablissement') }}" max="{{ now()->format('Y-m-d') }}" data-obligatoire="Saisissez la date d’établissement de la pièce d’identité.">
                    </div>
                    <div class="col-sm-3">
                      <label for="date_expiration" class="form-label small mb-1">Expire le</label>
                      <input type="date" id="date_expiration" name="date_expiration" class="form-control form-control-sm" value="{{ old('date_expiration') }}" readonly tabindex="-1">
                    </div>
                  </div>
                @endif
              </div>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    <div class="actions-parcours">
      <a href="{{ route('type.entreprise') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Changer de type</a>
      <div class="text-end">
        <div class="small text-muted mb-1" data-resume-envoi></div>
        <button type="submit" class="btn btn-success" data-bouton-envoi>
          <span data-texte-envoi>Continuer</span><i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  </form>
</div>
