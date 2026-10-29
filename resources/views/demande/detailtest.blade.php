@extends('layouts.frontend')
@section('content')
@include('demande.partials.styles')

@php
    $suivi = $demandes->suivi();
    $rejetee = $demandes->estRejetee();
    // Affiche une valeur échappée, ou « Non renseigné »
    $aff = function ($valeur) {
        $valeur = is_string($valeur) ? trim($valeur) : $valeur;
        return ($valeur === null || $valeur === '' || $valeur === 'NP')
            ? '<span class="ed-vide">Non renseigné</span>'
            : e($valeur);
    };
    $fcfa = function ($n) {
        return ($n === null || $n === '') ? null : number_format((float) $n, 0, ',', ' ').' FCFA';
    };
    $usage = $terrains ? $usage_terrains->firstWhere('Code', $terrains->id_usage_terrain) : null;
    // Commune sans arrondissement : le code enregistré est celui de la commune, il n'y a pas d'arrondissement à afficher
    $arrondissementEntreprise = ($arrondissements && $arrondissements->commune_code == $demandes->commune_departement_code)
        ? $arrondissements->name : null;
    $civilite = optional($civilites->firstWhere('code', $usager->Civility))->libelle
        ?? ['M.' => 'Monsieur', 'MME' => 'Madame', 'MLLE' => 'Mademoiselle'][$usager->Civility] ?? $usager->Civility;
    $situation = [1 => 'Célibataire', 2 => 'Marié(e)', 3 => 'Divorcé(e)'][$usager->SituationMatrimoniale] ?? null;
    $nbRejets = $historiques->filter(function ($h) { return $h->motif !== 'Envoyer Pour Traitement'; })->count();
    // Libellés lisibles des pièces jointes (type_piece enregistré en base -> libellé affiché)
    $libellesPieces = [
        'declaration' => 'Déclaration sur l’honneur / casier judiciaire', 'casier_judiciaire' => 'Casier judiciaire',
        'cnib' => 'CNIB', 'passport' => 'Passeport', 'piece_didentite' => 'Pièce d’identité',
        'titre_propriete' => 'Titre de propriété / bail', 'titre_de_propriete' => 'Titre de propriété / bail',
        'formulaire_dem_cpc' => 'Formulaire de demande de CPC', 'formulaire_cpc_es' => 'Formulaire CPC',
        'certificat_residence' => 'Certificat de résidence', 'certificat_de_residence' => 'Certificat de résidence',
        'photo_didentite' => 'Photo d’identité', 'signature' => 'Signature', 'statut' => 'Statuts',
        'formulaire_rccm' => 'Formulaire RCCM', 'acte_de_depot' => 'Acte de dépôt',
        'acte_mariage' => 'Acte de mariage', 'autorisation_de_commerce' => 'Autorisation d’exercer le commerce',
    ];
    $libellePiece = function ($type) use ($libellesPieces) {
        $cle = mb_strtolower(trim((string) $type));
        return $libellesPieces[$cle] ?? ucfirst(str_replace('_', ' ', $cle));
    };
@endphp

<div class="ed-page">
    <a href="{{ route('demande.liste') }}" class="d-inline-block mb-3 text-decoration-none">
        <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Mes demandes
    </a>

    {{-- En-tête : identité de la demande et suivi --}}
    <section class="ed-carte">
        <div class="ed-carte-entete">
            <div>
                <h1 class="ed-titre h4">{{ $demandes->commercial_name ?: 'Demande sans nom commercial' }}</h1>
                <div class="ed-meta mt-1">
                    <span><i class="fas fa-hashtag" aria-hidden="true"></i> {{ $demandes->numero_demande }}</span>
                    <span><i class="fas fa-building" aria-hidden="true"></i>
                        {{ $demandes->company_type == 'EI' ? 'Entreprise individuelle' : 'Entreprise sociétaire' }}</span>
                    <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> {{ \Illuminate\Support\Str::startsWith(mb_strtoupper((string) $cefore_code), 'CEFORE') ? $cefore_code : 'CEFORE '.$cefore_code }}</span>
                    <span><i class="far fa-calendar-alt" aria-hidden="true"></i>
                        Déposée le {{ optional($demandes->created_at)->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
            <span class="ed-badge {{ $suivi['couleur'] }}">
                <i class="fas {{ $suivi['icone'] }}" aria-hidden="true"></i> {{ $suivi['libelle'] }}
            </span>
        </div>
        <div class="ed-carte-corps">
            @include('demande.partials.frise', ['demande' => $demandes])
            <p class="mt-3 mb-0">{{ $suivi['consigne'] }}</p>
            <div class="d-flex flex-wrap gap-2 mt-3">
                @if ($demandes->paye == 0)
                    <form action="{{ route('orange.index') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ $demandes->id }}">
                        <input type="hidden" name="numero_command" value="{{ $demandes->numero_command }}">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="fas fa-wallet me-1" aria-hidden="true"></i>
                            Payer {{ $fcfa($demandes->montant_total) }}
                        </button>
                    </form>
                @elseif ($demandes->paye == 1)
                    <a href="{{ route('demande.facture', $demandes->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-invoice me-1" aria-hidden="true"></i> Télécharger la facture
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- Rejet : motif et marche à suivre --}}
    @if ($rejetee)
        <section class="ed-carte ed-rejet" id="correction">
            <div class="ed-carte-entete">
                <h2 class="text-danger"><i class="fas fa-exclamation-circle me-1" aria-hidden="true"></i>
                    Votre demande a été rejetée par le CEFORE</h2>
                @php
                    try {
                        $dateRejet = $demandes->Date_etat_validation ? \Carbon\Carbon::parse($demandes->Date_etat_validation)->format('d/m/Y') : null;
                    } catch (\Throwable $e) {
                        $dateRejet = null;
                    }
                @endphp
                @if ($dateRejet)
                    <span class="ed-meta">Le {{ $dateRejet }}</span>
                @endif
            </div>
            <div class="ed-carte-corps">
                <p class="mb-2 fw-semibold">Motif du rejet :</p>
                <div class="motif">{{ $demandes->motif ?: 'Aucun motif n’a été précisé. Contactez le CEFORE pour connaître les corrections attendues.' }}</div>

                <p class="mt-3 mb-0 fw-semibold">Pour corriger votre demande :</p>
                <ol class="ed-etapes-correction">
                    <li>
                        Corrigez les éléments concernés par le motif :
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <a href="#section-entreprise" class="btn btn-outline-danger btn-sm" data-csp-click="editdemande">
                                <i class="fas fa-building me-1" aria-hidden="true"></i> Informations de l’entreprise
                            </a>
                            <a href="#section-dirigeant" class="btn btn-outline-danger btn-sm" data-csp-click="editusager">
                                <i class="fas fa-user me-1" aria-hidden="true"></i> Informations du dirigeant
                            </a>
                            <a href="#section-pieces" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-paperclip me-1" aria-hidden="true"></i> Pièces jointes
                            </a>
                        </div>
                    </li>
                    <li>Enregistrez chaque correction (bouton « Enregistrer » de la rubrique concernée).</li>
                    <li>
                        Renvoyez la demande au CEFORE pour un nouvel examen :
                        <form action="{{ route('update.promoteur', $demandes->id) }}" method="post" class="mt-2">
                            @csrf
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="corrections_faites" required>
                                <label class="form-check-label" for="corrections_faites">
                                    J’ai effectué les corrections demandées dans le motif du rejet.
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-1" aria-hidden="true"></i> Renvoyer pour traitement
                            </button>
                        </form>
                    </li>
                </ol>
            </div>
        </section>
    @endif

    {{-- Formalités retour (une fois le RCCM délivré) --}}
    @if ($demandes->RCCM != '')
        <section class="ed-carte">
            <div class="ed-carte-entete"><h2><i class="fas fa-stamp me-1 text-success" aria-hidden="true"></i> Mes formalités</h2></div>
            <div class="ed-carte-corps">
                <div class="ed-pieces">
                    @foreach ($types_formalites as $types_formalite)
                        <div class="ed-piece">
                            <i class="fas fa-file-signature icone text-success" aria-hidden="true"></i>
                            <div class="nom">
                                {{ getlibelle($types_formalite->id) }}
                                <div class="ed-meta mt-1">
                                    <span>N° {{ getelementformalite($demandes->id, $types_formalite->id)['numero'] ?: '—' }}</span>
                                    <span>{{ getelementformalite($demandes->id, $types_formalite->id)['date'] ?: '' }}</span>
                                </div>
                            </div>
                            @if (getpieceformalite($demandes->id, $types_formalite->id) != 0)
                                <a href="{{ route('affiche_formalite', getpieceformalite($demandes->id, $types_formalite->id)) }}"
                                   class="btn btn-success btn-sm" title="Télécharger {{ getlibelle($types_formalite->id) }}">
                                    <i class="fas fa-download" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Entreprise --}}
    <form action="{{ route('demande.update', $demandes->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" name="id_terrain" value="{{ $demandes->id_terrain }}">
        <section class="ed-carte" id="section-entreprise">
            <div class="ed-carte-entete">
                <h2><i class="fas fa-building me-1 text-success" aria-hidden="true"></i> Entreprise</h2>
                @if ($rejetee)
                    <a href="#section-entreprise" class="btn btn-outline-danger btn-sm edit_demande" data-csp-click="editdemande">
                        <i class="fas fa-pen me-1" aria-hidden="true"></i> Corriger
                    </a>
                @endif
            </div>
            <div class="ed-carte-corps">
                {{-- Lecture --}}
                <div class="edit_demande">
                    <div class="ed-rubrique ed-rubrique-identite">
                        <h3 class="ed-rubrique-titre"><i class="fas fa-id-card" aria-hidden="true"></i> Identité</h3>
                        <dl class="ed-infos">
                        <div><dt>Nom commercial</dt><dd>{!! $aff($demandes->commercial_name) !!}</dd></div>
                        @if ($demandes->company_type == 'ES')
                            <div><dt>Dénomination sociale</dt><dd>{!! $aff($demandes->denomination_social) !!}</dd></div>
                        @endif
                        <div><dt>Sigle</dt><dd>{!! $aff($demandes->sigle) !!}</dd></div>
                        <div><dt>Enseigne</dt><dd>{!! $aff($demandes->enseigne) !!}</dd></div>
                        <div><dt>Forme juridique</dt><dd>{!! $aff(optional($forme_juridiques)->libelle) !!}</dd></div>
                    </dl>
                    </div>

                    <div class="ed-rubrique ed-rubrique-activite">
                        <h3 class="ed-rubrique-titre"><i class="fas fa-briefcase" aria-hidden="true"></i> Activité</h3>
                        <dl class="ed-infos">
                        <div><dt>Secteur d’activité</dt><dd>{!! $aff($demandes->activity_sector) !!}</dd></div>
                        <div><dt>Activité principale</dt><dd>{!! $aff(optional($activites)->description) !!}</dd></div>
                        <div><dt>Chiffre d’affaires prévisionnel</dt><dd>{!! $aff($fcfa($demandes->chiffre_daffaire_previsionel)) !!}</dd></div>
                        <div class="large"><dt>Objet social</dt><dd>{!! $aff($demandes->objet_social) !!}</dd></div>
                    </dl>
                    </div>

                    <div class="ed-rubrique ed-rubrique-siege">
                        <h3 class="ed-rubrique-titre"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Siège et terrain</h3>
                        <dl class="ed-infos">
                        <div><dt>Région</dt><dd>{!! $aff(optional($regions)->name) !!}</dd></div>
                        <div><dt>Province</dt><dd>{!! $aff(optional($provinces)->name) !!}</dd></div>
                        <div><dt>Commune</dt><dd>{!! $aff(optional($communes)->name) !!}</dd></div>
                        @if ($arrondissementEntreprise)
                            <div><dt>Arrondissement</dt><dd>{{ $arrondissementEntreprise }}</dd></div>
                        @endif
                        <div><dt>Secteur / Village</dt><dd>{!! $aff(optional($secteurs)->name) !!}</dd></div>
                        <div><dt>Lot · Section · Parcelle</dt>
                            <dd>{!! $aff(collect([optional($terrains)->numero_lot, optional($terrains)->numero_section, optional($terrains)->numero_parcelle])->filter()->implode(' · ')) !!}</dd></div>
                        <div><dt>Usage du terrain</dt><dd>{!! $aff(optional($usage)->Libelle ?? optional($terrains)->id_usage_terrain) !!}</dd></div>
                        <div><dt>Superficie</dt><dd>{!! $aff(optional($terrains)->superficie ? optional($terrains)->superficie.' m²' : null) !!}</dd></div>
                    </dl>
                    </div>

                    @if ($demandes->company_type == 'ES')
                        <div class="ed-rubrique ed-rubrique-capital">
                            <h3 class="ed-rubrique-titre"><i class="fas fa-coins" aria-hidden="true"></i> Capital</h3>
                            <dl class="ed-infos">
                            <div><dt>Capital social</dt><dd>{!! $aff($fcfa($demandes->capital_social)) !!}</dd></div>
                            <div><dt>Dont en numéraire</dt><dd>{!! $aff($fcfa($demandes->capital_en_numeraire)) !!}</dd></div>
                            <div><dt>Dont en nature</dt><dd>{!! $aff($fcfa($demandes->capital_en_nature)) !!}</dd></div>
                            <div><dt>Montant d’une action</dt><dd>{!! $aff($fcfa($demandes->montant_action)) !!}</dd></div>
                            <div><dt>Nombre d’actions</dt><dd>{!! $aff($demandes->nbre_actions) !!}</dd></div>
                        </dl>
                        </div>
                    @endif
                </div>

                {{-- Correction (demande rejetée uniquement) --}}
                @if ($rejetee)
                    <div class="save_demande" style="display:none">
                        <div class="alert alert-info py-2"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
                            Modifiez les informations concernées par le motif du rejet, puis enregistrez.</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="c_nom_commercial">Nom commercial</label>
                                <input class="form-control" id="c_nom_commercial" name="nom_commercial" type="text" value="{{ $demandes->commercial_name }}" required>
                            </div>
                            @if ($demandes->company_type == 'ES')
                                <div class="col-md-6">
                                    <label class="form-label" for="c_denomination">Dénomination sociale</label>
                                    <input class="form-control" id="c_denomination" name="denomination_sociale" type="text" value="{{ $demandes->denomination_social }}">
                                </div>
                            @endif
                            <div class="col-md-6">
                                <label class="form-label" for="c_sigle">Sigle</label>
                                <input class="form-control" id="c_sigle" name="sigle" type="text" value="{{ $demandes->sigle }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="c_enseigne">Enseigne</label>
                                <input class="form-control" id="c_enseigne" name="enseigne" type="text" value="{{ $demandes->enseigne }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="forme_juridique_pp">Forme juridique</label>
                                @php
                                    $formes = ['P1' => [$FJ_EI, 'forme_juridique_pp'], 'M1' => [$FJ_ES, 'forme_juridique_es'], 'G1' => [$FJ_GIE, 'forme_juridique_gie']][$demandes->request_type] ?? null;
                                @endphp
                                @if ($formes)
                                    <select id="forme_juridique_pp" name="{{ $formes[1] }}" class="form-control select2" style="width: 100%;">
                                        @foreach ($formes[0] as $forme)
                                            <option value="{{ $forme->code }}" @if($forme->code == $demandes->forme_juridique) selected @endif>{{ $forme->libelle }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="c_chiffre">Chiffre d’affaires prévisionnel (FCFA)</label>
                                <input class="form-control" id="c_chiffre" name="chiffre_daffaire" type="number" min="0" value="{{ $demandes->chiffre_daffaire_previsionel }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="secteur_activite">Secteur d’activité</label>
                                <select id="secteur_activite" name="secteur_activite" class="form-control select2" style="width: 100%;"
                                        data-csp-change="changeActivite" data-csp-change-args='["secteur_activite", "activite_principale"]'>
                                    @foreach ($activites_all as $activite)
                                        <option value="{{ $activite->secteur_activite }}" @if($activite->secteur_activite == $demandes->activity_sector) selected @endif>{{ $activite->secteur_activite }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="activite_principale">Activité principale</label>
                                <select id="activite_principale" name="activite_principale" class="form-control select2 activite_principale" style="width: 100%;">
                                    <option value="{{ optional($activites)->Code }}">{{ optional($activites)->description }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="c_objet">Objet social</label>
                                <textarea class="form-control" id="c_objet" name="objet_social" rows="4">{{ $demandes->objet_social }}</textarea>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="c_lot">Lot</label>
                                <input class="form-control" id="c_lot" name="lot" type="text" value="{{ optional($terrains)->numero_lot }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="c_section">Section</label>
                                <input class="form-control" id="c_section" name="section" type="text" value="{{ optional($terrains)->numero_section }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="c_parcelle">Parcelle</label>
                                <input class="form-control" id="c_parcelle" name="parcelle" type="text" value="{{ optional($terrains)->numero_parcelle }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="usage">Usage du terrain</label>
                                <select id="usage" name="usage" class="form-control select2" style="width: 100%;" required>
                                    @foreach ($usage_terrains as $usage_terrain)
                                        <option value="{{ $usage_terrain->Code }}" @if($usage_terrain->Code == optional($terrains)->id_usage_terrain) selected @endif>{{ $usage_terrain->Libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('demande.detail', $demandes->id) }}#section-entreprise" class="btn btn-light">Annuler</a>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save me-1" aria-hidden="true"></i> Enregistrer</button>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </form>

    {{-- Dirigeant / promoteur --}}
    <form action="{{ route('usager.update', $usager->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <section class="ed-carte" id="section-dirigeant">
            <div class="ed-carte-entete">
                <h2><i class="fas fa-user me-1 text-success" aria-hidden="true"></i> Dirigeant</h2>
                @if ($rejetee)
                    <a href="#section-dirigeant" class="btn btn-outline-danger btn-sm edit_usager" data-csp-click="editusager">
                        <i class="fas fa-pen me-1" aria-hidden="true"></i> Corriger
                    </a>
                @endif
            </div>
            <div class="ed-carte-corps">
                <div class="edit_usager">
                    <div class="ed-rubrique ed-rubrique-personne">
                        <h3 class="ed-rubrique-titre"><i class="fas fa-user" aria-hidden="true"></i> Identité</h3>
                        <dl class="ed-infos">
                            <div><dt>Nom et prénom</dt><dd>{!! $aff(trim($civilite.' '.$usager->NomRaisonSociale.' '.$usager->Prenom)) !!}</dd></div>
                            <div><dt>Né(e) le</dt><dd>{!! $aff(trim(($usager->DateNaissance ? format_date($usager->DateNaissance) : '').($usager->LieuNaissance ? ' à '.$usager->LieuNaissance : ''))) !!}</dd></div>
                            <div><dt>Genre</dt><dd>{{ $usager->Gender == 1 ? 'Féminin' : 'Masculin' }}</dd></div>
                            <div><dt>Situation matrimoniale</dt><dd>{!! $aff($situation) !!}</dd></div>
                            <div><dt>Profession</dt><dd>{!! $aff(getfonction($usager->IdFonction)) !!}</dd></div>
                            <div><dt>Nationalité</dt><dd>{!! $aff(getpays($usager->Nationality_No_)) !!}</dd></div>
                            <div><dt>Pays de résidence</dt><dd>{!! $aff(getpays($usager->Country_Code)) !!}</dd></div>
                            <div><dt>Pièce d’identité</dt><dd>{!! $aff($usager->CIN) !!}</dd></div>
                        </dl>
                    </div>
                    <div class="ed-rubrique ed-rubrique-coordonnees">
                        <h3 class="ed-rubrique-titre"><i class="fas fa-address-book" aria-hidden="true"></i> Coordonnées</h3>
                        <dl class="ed-infos">
                            <div><dt>Téléphone mobile</dt><dd>{!! $aff($usager->Phone_No_) !!}</dd></div>
                            <div><dt>Téléphone bureau</dt><dd>{!! $aff($usager->Tel_Bureau) !!}</dd></div>
                            <div><dt>E-mail</dt><dd>{!! $aff($usager['E-Mail']) !!}</dd></div>
                            <div><dt>Boîte postale</dt><dd>{!! $aff($usager->Boite_postale) !!}</dd></div>
                            <div class="large"><dt>Adresse</dt>
                                <dd>{!! $aff(collect([$usager->IdAdresse, optional($secteur_usager)->name, optional($commune_usager)->name, optional($province_usager)->name, optional($region_usager)->name])->filter()->implode(', ')) !!}</dd></div>
                        </dl>
                    </div>
                </div>

                @if ($rejetee)
                    <div class="save_usager" style="display:none">
                        <div class="alert alert-info py-2"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
                            Modifiez les informations concernées par le motif du rejet, puis enregistrez.</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="single-select-field">Civilité</label>
                                <select id="single-select-field" name="civilite" class="form-control select2" style="width: 100%;" required>
                                    @foreach ($civilites as $c_civilite)
                                        <option value="{{ $c_civilite->code }}" @if($c_civilite->code == $usager->Civility) selected @endif>{{ $c_civilite->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_nom">Nom</label>
                                <input class="form-control" id="c_nom" name="nom" type="text" value="{{ $usager->NomRaisonSociale }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_prenom">Prénom</label>
                                <input class="form-control" id="c_prenom" name="prenom" type="text" value="{{ $usager->Prenom }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_date_naissance">Date de naissance</label>
                                <input class="form-control date_nais_usager" id="c_date_naissance" name="date_de_naissance" type="text"
                                       value="{{ $usager->DateNaissance ? format_date($usager->DateNaissance) : '' }}" data-date-format="dd-mm-yyyy" placeholder="jj-mm-aaaa">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_lieu_naissance">Lieu de naissance</label>
                                <input class="form-control" id="c_lieu_naissance" name="lieu_naissance" type="text" value="{{ $usager->LieuNaissance }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="situation_matrimoniale">Situation matrimoniale</label>
                                <select id="situation_matrimoniale" name="situation_matrimoniale" class="form-control select2" style="width: 100%;" required>
                                    @foreach ([1 => 'Célibataire', 2 => 'Marié(e)', 3 => 'Divorcé(e)'] as $code => $libelle)
                                        <option value="{{ $code }}" @if($code == $usager->SituationMatrimoniale) selected @endif>{{ $libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="profession">Profession</label>
                                <select id="profession" name="profession" class="form-control select2" style="width: 100%;">
                                    @foreach ($professions as $profession)
                                        <option value="{{ $profession->code }}" @if($profession->code == $usager->IdFonction) selected @endif>{{ $profession->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="code">Nationalité</label>
                                <select id="code" name="nationalite_usager" class="form-control select2" style="width: 100%;">
                                    @foreach ($nationalites as $nationalite)
                                        <option value="{{ $nationalite->code }}" @if($nationalite->code == $usager->Nationality_No_) selected @endif>{{ $nationalite->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="code_pays">Pays de résidence</label>
                                <select id="code_pays" name="pays_usager" class="form-control select2" style="width: 100%;">
                                    @foreach ($pays as $pay)
                                        <option value="{{ $pay->code }}" @if($pay->code == $usager->Country_Code) selected @endif>{{ $pay->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_tel_mobile">Téléphone mobile</label>
                                <input class="form-control" id="c_tel_mobile" name="tel_mobile" type="text" value="{{ $usager->Phone_No_ }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_tel_bureau">Téléphone bureau</label>
                                <input class="form-control" id="c_tel_bureau" name="tel_bureau" type="text" value="{{ $usager->Tel_Bureau }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_mail">E-mail</label>
                                <input class="form-control" id="c_mail" name="mail" type="email" value="{{ $usager['E-Mail'] !== 'NP' ? $usager['E-Mail'] : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="c_bp">Boîte postale</label>
                                <input class="form-control" id="c_bp" name="boite_postale" type="text" value="{{ $usager->Boite_postale !== 'NP' ? $usager->Boite_postale : '' }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('demande.detail', $demandes->id) }}#section-dirigeant" class="btn btn-light">Annuler</a>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save me-1" aria-hidden="true"></i> Enregistrer</button>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </form>

    {{-- Pièces jointes --}}
    <section class="ed-carte" id="section-pieces">
        <div class="ed-carte-entete">
            <h2><i class="fas fa-paperclip me-1 text-success" aria-hidden="true"></i> Pièces jointes</h2>
            <span class="ed-meta">{{ $piecejointes->count() }} document{{ $piecejointes->count() > 1 ? 's' : '' }}</span>
        </div>
        <div class="ed-carte-corps">
            @if ($rejetee)
                <p class="text-muted small mb-3"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
                    Pour remplacer un document, cliquez sur <i class="fas fa-pen" aria-hidden="true"></i> à côté de la pièce concernée.</p>
            @endif
            @if ($piecejointes->isEmpty())
                <p class="ed-vide mb-0">Aucune pièce jointe pour cette demande.</p>
            @else
                <div class="ed-pieces">
                    @foreach ($piecejointes as $piecejointe)
                        @php $image = in_array(strtolower((string) $piecejointe->file_extension), ['jpg', 'jpeg', 'png']); @endphp
                        <div class="ed-piece">
                            <i class="fas {{ $image ? 'fa-file-image text-primary' : 'fa-file-pdf' }} icone" aria-hidden="true"></i>
                            <span class="nom">{{ $libellePiece($piecejointe->type_piece) }}</span>
                            <a href="{{ route('detaildocument_affiche', $piecejointe->id) }}" class="btn btn-outline-success btn-sm" title="Voir le document">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </a>
                            @if ($rejetee)
                                <a href="#updatepiecejointe_correction" data-bs-toggle="modal" class="btn btn-outline-danger btn-sm" title="Remplacer le document"
                                   data-csp-click="editpiecejointes" data-csp-click-args="{{ json_encode([(string) ($piecejointe->categorie_piece)]) }}">
                                    <i class="fas fa-pen" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Historique des rejets et renvois --}}
    <section class="ed-carte">
        <div class="ed-carte-entete">
            <h2><i class="fas fa-history me-1 text-success" aria-hidden="true"></i> Historique</h2>
            @if ($nbRejets > 0)
                <span class="ed-meta">{{ $nbRejets }} rejet{{ $nbRejets > 1 ? 's' : '' }}</span>
            @endif
        </div>
        <div class="ed-carte-corps">
            <ul class="ed-historique">
                @foreach ($historiques as $historique)
                    @php $renvoi = $historique->motif === 'Envoyer Pour Traitement'; @endphp
                    <li class="{{ $renvoi ? '' : 'rejet' }}">
                        <div class="date">{{ optional($historique->created_at)->format('d/m/Y à H:i') }}</div>
                        @if ($renvoi)
                            <strong>Demande renvoyée pour traitement</strong>
                        @else
                            <strong class="text-danger">Demande rejetée par le CEFORE</strong>
                            <div class="text-muted">{{ $historique->motif }}</div>
                        @endif
                    </li>
                @endforeach
                <li>
                    <div class="date">{{ optional($demandes->created_at)->format('d/m/Y à H:i') }}</div>
                    <strong>Demande déposée</strong>
                </li>
            </ul>
        </div>
    </section>
</div>
@endsection
