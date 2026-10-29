@extends('backend.adminlte.main')
@section('title', 'Traitement de la demande')
@section('demandes', 'menu-open')
@section('content')
@php
    $date = fn ($d, $format = 'd/m/Y') => $d ? \Carbon\Carbon::parse($d)->format($format) : null;
    // Une ligne « libellé / valeur » de fiche, valeur échappée ; « Non renseigné » quand elle est vide
    $champ = fn ($libelle, $valeur, $classe = '') => '<div class="'.$classe.'"><dt>'.e($libelle).'</dt><dd>'
        .(blank($valeur) ? '<span class="vide">Non renseigné</span>' : nl2br(e($valeur))).'</dd></div>';
    $montant = fn ($v) => blank($v) ? null : number_format((float) $v, 0, ',', ' ').' FCFA';
    $typeEntreprise = ['EI' => 'Personne physique', 'GIE' => 'Groupement d’intérêt économique'][$demandes->company_type] ?? 'Personne morale';
    $civilite = optional($civilites->firstWhere('code', $usager->Civility))->libelle
        ?? (['M.' => 'Monsieur', 'MME' => 'Madame', 'MLLE' => 'Mademoiselle'][$usager->Civility] ?? $usager->Civility);
    $situation = [1 => 'Célibataire', 2 => 'Marié(e)', 3 => 'Divorcé(e)'][$usager->SituationMatrimoniale] ?? null;
    $usage = optional($usage_terrains->firstWhere('Code', optional($terrains)->id_usage_terrain))->Libelle ?? optional($terrains)->id_usage_terrain;
    $nomPromoteur = trim($usager->Prenom.' '.$usager->NomRaisonSociale);
    $telephone = preg_replace('/[^0-9+]/', '', (string) $usager->Phone_No_);
    $couleursHistorique = ['creation' => 'secondary', 'paiement' => 'info', 'validation' => 'success', 'rejet' => 'danger',
        'renvoi' => 'warning', 'piece_modifiee' => 'primary', 'demande_corrigee' => 'primary', 'dirigeant_corrige' => 'primary'];
    $etatAutre = fn ($d) => (int) $d->paye !== 1 ? ['Non payée', 'secondary'] : ([1 => ['Validée', 'success'], 2 => ['Rejetée', 'danger']][(int) $d->etat] ?? ['À valider', 'warning']);
@endphp

<div class="mb-3">
  <button type="button" class="btn btn-sm btn-outline-secondary" data-csp-click="__retour"><i class="fas fa-arrow-left me-1" aria-hidden="true"></i>Retour</button>
</div>

{{-- ===== Synthèse du dossier ===== --}}
<div class="card mb-3 dossier-entete">
  <div class="card-body">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
      <div>
        <div class="small text-muted mb-1">{{ $typeEntreprise }} · N° {{ $demandes->numero_demande ?: '—' }} · {{ $cefore_code }}</div>
        <h2 class="h4 mb-0">{{ $demandes->commercial_name ?: $demandes->denomination_social }}</h2>
        @if ($demandes->company_type !== 'EI' && $demandes->denomination_social && $demandes->denomination_social !== $demandes->commercial_name)
          <div class="text-muted">{{ $demandes->denomination_social }}</div>
        @endif
      </div>
      <span class="badge fs-6 text-bg-{{ $statut[1] }}"><i class="fas {{ $statut[2] }} me-1" aria-hidden="true"></i>{{ $statut[0] }}</span>
    </div>

    <div class="row g-3 mt-2 dossier-faits">
      <div class="col-sm-6 col-xl-3">
        <div class="fait-libelle">Demande créée</div>
        <div class="fait-valeur">{{ $date($demandes->created_at, 'd/m/Y à H:i') }}</div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="fait-libelle">Paiement</div>
        <div class="fait-valeur">
          @if ((int) $demandes->paye === 1)
            {{ $montant($demandes->montant_total) ?? 'Payé' }}
            <div class="small text-muted">le {{ $date($demandes->date_paiement, 'd/m/Y à H:i') ?? '—' }}</div>
          @elseif ((int) $demandes->paye === 2)
            À confirmer
          @else
            <span class="text-muted">Non payée</span>
          @endif
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="fait-libelle">Promoteur</div>
        <div class="fait-valeur">
          {{ $nomPromoteur }}
          <div class="small">
            @if ($telephone)<a href="tel:{{ $telephone }}" class="me-2"><i class="fas fa-phone-alt me-1" aria-hidden="true"></i>{{ $usager->Phone_No_ }}</a>@endif
            @if (optional($compte)->email)<a href="mailto:{{ $compte->email }}" class="text-break"><i class="fas fa-envelope me-1" aria-hidden="true"></i>{{ $compte->email }}</a>@endif
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="fait-libelle">Autres demandes du promoteur</div>
        <div class="fait-valeur">
          @if ($autresDemandes->isEmpty())
            <span class="text-muted">Aucune</span>
          @else
            <a href="#autres-demandes">{{ $autresDemandes->count() }} autre{{ $autresDemandes->count() > 1 ? 's' : '' }} demande{{ $autresDemandes->count() > 1 ? 's' : '' }}</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ===== Décision ===== --}}
@if ($peutTraiter)
  <div class="card mb-3 barre-decision">
    <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
      <div>
        <div class="fw-semibold"><i class="fas fa-clipboard-check me-1 text-warning" aria-hidden="true"></i>Cette demande attend votre décision</div>
        <div class="small text-muted">
          Vérifiez les informations et chaque pièce. Cochez « À corriger » sur les pièces non conformes : elles seront reprises dans le motif.
          <span class="badge text-bg-danger ms-1 d-none" data-compteur-corrections></span>
        </div>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-confirm"><i class="fas fa-check-circle me-1" aria-hidden="true"></i>Valider la demande</button>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm-rejet"><i class="fas fa-undo-alt me-1" aria-hidden="true"></i>Demander une correction</button>
      </div>
    </div>
  </div>
@elseif ((string) $demandes->etat === '1' && (int) $demandes->paye === 1)
  <div class="alert alert-success mb-3"><i class="fas fa-check-circle me-1" aria-hidden="true"></i>
    Demande validée le {{ $date($demandes->Date_etat_validation, 'd/m/Y à H:i') ?? '—' }}@if ($validateur) par <strong>{{ trim($validateur->prenom.' '.$validateur->name) }}</strong>@endif.
    Le promoteur doit déposer le dossier physique au CEFORE.
  </div>
@elseif ((string) $demandes->etat === '2')
  <div class="alert alert-danger mb-3">
    <div class="fw-semibold"><i class="fas fa-undo-alt me-1" aria-hidden="true"></i>Correction demandée le {{ $date($demandes->Date_etat_validation, 'd/m/Y à H:i') ?? '—' }}@if ($validateur) par {{ trim($validateur->prenom.' '.$validateur->name) }}@endif</div>
    @if ($demandes->motif)<div class="mt-1" style="white-space: pre-line;">{{ $demandes->motif }}</div>@endif
    <div class="small mt-2">Le promoteur doit corriger sa demande puis la renvoyer : elle reviendra alors dans « À valider ».</div>
  </div>
@elseif ((int) $demandes->paye === 0)
  <div class="alert alert-secondary mb-3"><i class="fas fa-credit-card me-1" aria-hidden="true"></i>Le promoteur n’a pas encore payé : la demande ne peut pas encore être traitée.</div>
@elseif ((int) $demandes->paye === 2)
  <div class="alert alert-info mb-3"><i class="fas fa-hourglass-start me-1" aria-hidden="true"></i>Le paiement est en cours de confirmation par l’opérateur.</div>
@elseif ((string) $demandes->etat === '0')
  <div class="alert alert-light border mb-3"><i class="fas fa-lock me-1" aria-hidden="true"></i>Vous pouvez consulter cette demande, mais vous n’avez pas le droit de la valider ou de la rejeter.</div>
@endif

<div class="row g-3">
  {{-- ===== Informations ===== --}}
  <div class="col-xl-7">

    <div class="card mb-3">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-building me-2 text-secondary" aria-hidden="true"></i>Entreprise</h3></div>
      <div class="card-body">
        <dl class="fiche">
          {!! $champ('Nom commercial', $demandes->commercial_name) !!}
          @if ($demandes->company_type !== 'EI'){!! $champ('Dénomination sociale', $demandes->denomination_social) !!}@endif
          {!! $champ('Sigle', $demandes->sigle) !!}
          {!! $champ('Enseigne', $demandes->enseigne) !!}
          {!! $champ('Forme juridique', optional($forme_juridiques)->libelle) !!}
          {!! $champ('Secteur d’activité', $demandes->activity_sector) !!}
          {!! $champ('Activité principale', optional($activites)->description) !!}
          {!! $champ('Chiffre d’affaires prévisionnel', $montant($demandes->chiffre_daffaire_previsionel)) !!}
          {!! $champ('Objet social', $demandes->objet_social, 'pleine-largeur') !!}
        </dl>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-map-marker-alt me-2 text-secondary" aria-hidden="true"></i>Siège de l’entreprise</h3></div>
      <div class="card-body">
        <dl class="fiche">
          {!! $champ('Région', optional($regions)->name) !!}
          {!! $champ('Province', optional($provinces)->name) !!}
          {!! $champ('Commune', optional($communes)->name) !!}
          @if ($arrondissements){!! $champ('Arrondissement', $arrondissements->name) !!}@endif
          {!! $champ('Secteur / village', optional($secteurs)->name) !!}
          {!! $champ('Quartier', $demandes->quartier) !!}
          {!! $champ('Adresse', trim(implode(' ', array_filter([$demandes->avenue, $demandes->rue, $demandes->porte ? 'porte '.$demandes->porte : null, $demandes->adress])))) !!}
          {!! $champ('Boîte postale', $demandes->boite_postale) !!}
          {!! $champ('Lot · section · parcelle', $terrains ? trim(implode(' · ', array_filter([$terrains->numero_lot, $terrains->numero_section, $terrains->numero_parcelle]))) : null) !!}
          {!! $champ('Usage du terrain', $usage) !!}
        </dl>
      </div>
    </div>

    @if ($demandes->company_type === 'ES')
      <div class="card mb-3">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-coins me-2 text-secondary" aria-hidden="true"></i>Capital</h3></div>
        <div class="card-body">
          <dl class="fiche">
            {!! $champ('Capital social', $montant($demandes->capital_social)) !!}
            {!! $champ('Dont en numéraire', $montant($demandes->capital_en_numeraire)) !!}
            {!! $champ('Dont en nature', $montant($demandes->capital_en_nature)) !!}
            {!! $champ('Montant par action', $montant($demandes->montant_action)) !!}
            {!! $champ('Nombre d’actions', $demandes->nbre_actions) !!}
          </dl>
        </div>
      </div>
    @endif

    <div class="card mb-3">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-user-tie me-2 text-secondary" aria-hidden="true"></i>Dirigeant</h3></div>
      <div class="card-body">
        <dl class="fiche">
          {!! $champ('Civilité', $civilite) !!}
          {!! $champ('Nom', $usager->NomRaisonSociale) !!}
          {!! $champ('Prénom(s)', $usager->Prenom) !!}
          {!! $champ('Genre', (int) $usager->Gender === 1 ? 'Féminin' : 'Masculin') !!}
          {!! $champ('Date de naissance', $date($usager->DateNaissance)) !!}
          {!! $champ('Lieu de naissance', $usager->LieuNaissance) !!}
          {!! $champ('N° CNIB / pièce d’identité', $usager->CIN) !!}
          {!! $champ('Situation matrimoniale', $situation) !!}
          {!! $champ('Profession', getfonction($usager->IdFonction)) !!}
          {!! $champ('Nationalité', getpays($usager->Nationality_No_)) !!}
          {!! $champ('Pays de résidence', getpays($usager->Country_Code)) !!}
          {!! $champ('Téléphone mobile', $usager->Phone_No_) !!}
          {!! $champ('Téléphone bureau', $usager->Tel_Bureau) !!}
          {!! $champ('E-mail', $usager['E-Mail']) !!}
          {!! $champ('Boîte postale', $usager->Boite_postale) !!}
          {!! $champ('Domicile', trim(implode(', ', array_filter([optional($secteur_usager)->name, optional($arrondissement_usager)->name, optional($commune_usager)->name, optional($province_usager)->name, optional($region_usager)->name])))) !!}
          {!! $champ('Compte e-Création', optional($compte)->email) !!}
        </dl>
      </div>
    </div>

    @if ($peutCorriger)
      @include('backend.adminlte.partials.corrections')
    @endif

    @if ($demandes->RCCM)
      @include('backend.adminlte.partials.formalites')
    @endif

    <div class="card mb-3">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-history me-2 text-secondary" aria-hidden="true"></i>Historique du dossier</h3></div>
      <div class="card-body">
        <ol class="chronologie">
          @foreach ($historique as $evenement)
            <li style="--puce: var(--bs-{{ $couleursHistorique[$evenement['type']] ?? 'secondary' }});">
              <div class="d-flex flex-wrap justify-content-between gap-2">
                <span class="fw-semibold">{{ $evenement['titre'] }}</span>
                <span class="small text-muted">{{ $evenement['date']->format('d/m/Y à H:i') }}</span>
              </div>
              @if ($evenement['auteur'])<div class="small text-muted">par {{ $evenement['auteur'] }}</div>@endif
              @if ($evenement['detail'])<div class="small mt-1 historique-detail">{{ $evenement['detail'] }}</div>@endif
            </li>
          @endforeach
        </ol>
      </div>
    </div>

    @if ($autresDemandes->isNotEmpty())
      <div class="card mb-3" id="autres-demandes">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-folder me-2 text-secondary" aria-hidden="true"></i>Autres demandes du promoteur</h3></div>
        <div class="list-group list-group-flush">
          @foreach ($autresDemandes as $autre)
            @php $etat = $etatAutre($autre); @endphp
            <a href="{{ route('detail.demande', $autre->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center gap-2">
              <span>
                <span class="fw-semibold">{{ $autre->commercial_name ?: $autre->denomination_social }}</span>
                <span class="small text-muted d-block">{{ $autre->numero_demande }} · {{ $date($autre->created_at) }}</span>
              </span>
              <span class="badge text-bg-{{ $etat[1] }}">{{ $etat[0] }}</span>
            </a>
          @endforeach
        </div>
      </div>
    @endif
  </div>

  {{-- ===== Pièces jointes et visionneuse (reste visible pendant le défilement) ===== --}}
  <div class="col-xl-5">
    <div class="colonne-pieces">
      <div class="card mb-3">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-paperclip me-2 text-secondary" aria-hidden="true"></i>Pièces jointes <span class="badge text-bg-secondary ms-1">{{ $piecejointes->count() }}</span></h3>
        </div>
        @if ($piecejointes->isEmpty())
          <div class="card-body text-muted">Aucune pièce jointe pour cette demande.</div>
        @else
          <div class="list-group list-group-flush liste-pieces">
            @foreach ($piecejointes as $piece)
              <div class="list-group-item d-flex align-items-center gap-2 {{ optional($premierePiece)->id === $piece->id ? 'active-piece' : '' }}" data-piece>
                <button type="button" class="btn btn-link text-start text-decoration-none p-0 flex-grow-1 text-body"
                        @if ($piece->fichier_present) data-piece-url="{{ route('piecejointe.voir', $piece->id) }}" @else data-piece-absente @endif
                        data-piece-titre="{{ $piece->libelle() }}">
                  <span class="fw-semibold d-block">{{ $piece->libelle() }}
                    @unless ($piece->fichier_present)<span class="badge text-bg-danger fw-normal ms-1">Fichier absent</span>@endunless
                  </span>
                  @if ($piece->numero || $piece->date_etablissement || $piece->lieu_etablissement)
                    <span class="small text-muted">
                      {{ implode(' · ', array_filter([$piece->numero ? 'N° '.$piece->numero : null, $piece->date_etablissement ? 'du '.$date($piece->date_etablissement) : null, $piece->lieu_etablissement])) }}
                    </span>
                  @endif
                </button>
                @if ($peutTraiter)
                  <div class="form-check form-check-reverse mb-0 small text-nowrap" title="Pièce à faire corriger par le promoteur">
                    <input class="form-check-input piece-a-corriger" type="checkbox" id="corriger{{ $piece->id }}" data-libelle="{{ $piece->libelle() }}">
                    <label class="form-check-label text-danger fw-normal" for="corriger{{ $piece->id }}">À corriger</label>
                  </div>
                @endif
                @if ($piece->fichier_present)
                  <a href="{{ route('piecejointe.voir', $piece->id) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary" title="Ouvrir dans un nouvel onglet"><i class="fas fa-external-link-alt" aria-hidden="true"></i><span class="visually-hidden">Ouvrir</span></a>
                @endif
                @can('valider.demande', Auth::user())
                  <a href="{{ route('edit.pj', $piece) }}" class="btn btn-sm btn-outline-primary" title="Remplacer ou modifier la pièce"><i class="fas fa-pen" aria-hidden="true"></i><span class="visually-hidden">Modifier</span></a>
                @endcan
              </div>
            @endforeach
          </div>
        @endif
      </div>

      @if ($piecejointes->isNotEmpty())
        {{-- Aperçu : reste en haut de l'écran pendant le défilement et en occupe toute la hauteur --}}
        <div class="card mb-3 carte-apercu">
          <div class="card-header d-flex align-items-center gap-2 py-2">
            <div class="flex-grow-1 text-truncate small">
              <i class="fas fa-eye me-1 text-secondary" aria-hidden="true"></i>Aperçu :
              <span class="fw-semibold" data-visionneuse-titre>{{ optional($premierePiece)->libelle() ?? $piecejointes->first()->libelle() }}</span>
            </div>
            <div class="btn-group btn-group-sm" role="group" aria-label="Changer de pièce">
              <button type="button" class="btn btn-outline-secondary" data-piece-precedente title="Pièce précédente"><i class="fas fa-chevron-left" aria-hidden="true"></i><span class="visually-hidden">Pièce précédente</span></button>
              <button type="button" class="btn btn-outline-secondary" data-piece-suivante title="Pièce suivante"><i class="fas fa-chevron-right" aria-hidden="true"></i><span class="visually-hidden">Pièce suivante</span></button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary {{ $premierePiece ? '' : 'd-none' }}" data-bs-toggle="modal" data-bs-target="#modal-apercu-plein" data-bouton-agrandir title="Afficher en plein écran">
              <i class="fas fa-expand" aria-hidden="true"></i><span class="visually-hidden">Plein écran</span>
            </button>
          </div>
          <div class="card-body p-2">
            <iframe class="visionneuse {{ $premierePiece ? '' : 'd-none' }}" data-visionneuse
                    @if ($premierePiece) src="{{ route('piecejointe.voir', $premierePiece->id) }}#navpanes=0&zoom=page-fit" @endif title="Aperçu de la pièce jointe"></iframe>
            <div class="visionneuse visionneuse-absente {{ $premierePiece ? 'd-none' : '' }}" data-visionneuse-absente>
              <div>
                <i class="fas fa-file-excel fa-2x mb-2 text-danger" aria-hidden="true"></i>
                <div class="fw-semibold">Le fichier de cette pièce est introuvable sur le serveur.</div>
                <div class="small text-muted mt-1">La pièce est enregistrée, mais son fichier n’a pas été retrouvé. Demandez au promoteur de la joindre à nouveau, ou remplacez-la avec le bouton <i class="fas fa-pen" aria-hidden="true"></i>.</div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

{{-- Aperçu d'une pièce en plein écran --}}
<div class="modal fade" id="modal-apercu-plein" tabindex="-1" aria-labelledby="titre-apercu-plein" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title" id="titre-apercu-plein"><i class="fas fa-paperclip me-2 text-secondary" aria-hidden="true"></i><span data-apercu-plein-titre></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body p-0">
        <iframe class="w-100 h-100 border-0" data-apercu-plein title="Pièce jointe en plein écran"></iframe>
      </div>
    </div>
  </div>
</div>

{{-- ===== Fenêtres de décision ===== --}}
<div class="modal fade" id="modal-confirm" tabindex="-1" aria-labelledby="titre-validation" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('valider.demande', $demandes->id) }}" method="post" data-envoi-unique>
        @csrf
        <input type="hidden" name="etat" value="oui">
        <div class="modal-header">
          <h5 class="modal-title" id="titre-validation"><i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>Valider la demande</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <p class="mb-2">Vous validez la demande <strong>{{ $demandes->commercial_name ?: $demandes->denomination_social }}</strong>.</p>
          <p class="small text-muted mb-0"><i class="fas fa-envelope me-1" aria-hidden="true"></i>Le promoteur sera prévenu par e-mail et invité à déposer le dossier physique au {{ $cefore_code }}.</p>
          <div class="alert alert-warning small mt-3 mb-0 d-none" data-alerte-validation>
            <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>Vous avez coché des pièces « À corriger ». Si elles ne sont pas conformes, demandez plutôt une correction.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1" aria-hidden="true"></i>Confirmer la validation</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-confirm-rejet" tabindex="-1" aria-labelledby="titre-rejet" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <form action="{{ route('valider.demande', $demandes->id) }}" method="post" data-envoi-unique class="d-flex flex-column" style="min-height: 0;">
        @csrf
        <input type="hidden" name="etat" value="non">
        <div class="modal-header">
          <h5 class="modal-title" id="titre-rejet"><i class="fas fa-undo-alt text-danger me-2" aria-hidden="true"></i>Demander une correction au promoteur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <label for="motif_rejet" class="form-label">Motif <span class="text-danger">*</span></label>
          <textarea name="motif" id="motif_rejet" class="form-control" rows="7" maxlength="2000" required
                    placeholder="Indiquez précisément ce que le promoteur doit corriger (pièce concernée, information erronée…)"></textarea>
          <div class="d-flex justify-content-between small text-muted mt-1">
            <span><i class="fas fa-envelope me-1" aria-hidden="true"></i>Ce motif est envoyé tel quel au promoteur par e-mail.</span>
            <span data-compteur-motif>0 / 2000</span>
          </div>
          <div class="mt-3">
            <div class="small fw-semibold mb-1">Ajouter une phrase type :</div>
            <div class="d-flex flex-wrap gap-2">
              @foreach ([
                  'La pièce est illisible : merci de joindre une copie nette et complète.',
                  'La pièce est expirée : merci de joindre une pièce en cours de validité.',
                  'La pièce ne correspond pas au document demandé.',
                  'Les informations saisies ne correspondent pas aux pièces jointes.',
                  'Le nom commercial doit être modifié.',
                  'L’adresse ou la localisation de l’entreprise est incomplète.',
              ] as $phrase)
                <button type="button" class="btn btn-sm btn-outline-secondary" data-motif-suggestion="{{ $phrase }}">{{ \Illuminate\Support\Str::limit($phrase, 48) }}</button>
              @endforeach
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane me-1" aria-hidden="true"></i>Envoyer la demande de correction</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
