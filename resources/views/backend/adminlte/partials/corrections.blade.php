{{-- Correction des informations par l'agent (demande rejetée, en attente de correction).
     Les noms des champs sont ceux attendus par DemandeController::update_demande et update_usager. --}}
@php
    $formes = ['P1' => ['forme_juridique_pp', $FJ_EI], 'M1' => ['forme_juridique_es', $FJ_ES], 'G1' => ['forme_juridique_gie', $FJ_GIE]][$demandes->request_type] ?? null;
@endphp
<div class="card mb-3 border-primary">
  <div class="card-header d-flex flex-wrap align-items-center gap-2">
    <h3 class="card-title flex-grow-1"><i class="fas fa-edit me-2 text-primary" aria-hidden="true"></i>Corriger les informations</h3>
    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#correction-entreprise" aria-expanded="false">Entreprise</button>
    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#correction-dirigeant" aria-expanded="false">Dirigeant</button>
  </div>
  <div class="card-body small text-muted py-2">
    À utiliser pour corriger une erreur évidente à la place du promoteur. Chaque correction est notée dans l’historique du dossier.
  </div>

  {{-- Entreprise --}}
  <div class="collapse" id="correction-entreprise">
    <form action="{{ route('demande.update', $demandes->id) }}" method="post" class="card-body border-top">
      @csrf
      @method('PUT')
      <input type="hidden" name="id_terrain" value="{{ $demandes->id_terrain }}">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="c_nom_commercial">Nom commercial</label>
          <input id="c_nom_commercial" class="form-control" name="nom_commercial" value="{{ $demandes->commercial_name }}" required>
        </div>
        @if ($demandes->company_type === 'ES')
          <div class="col-md-6">
            <label class="form-label" for="c_denomination">Dénomination sociale</label>
            <input id="c_denomination" class="form-control" name="denomination_sociale" value="{{ $demandes->denomination_social }}">
          </div>
        @endif
        <div class="col-md-3">
          <label class="form-label" for="c_sigle">Sigle</label>
          <input id="c_sigle" class="form-control" name="sigle" value="{{ $demandes->sigle }}">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_enseigne">Enseigne</label>
          <input id="c_enseigne" class="form-control" name="enseigne" value="{{ $demandes->enseigne }}">
        </div>
        <div class="col-md-6">
          <label class="form-label" for="c_ca">Chiffre d’affaires prévisionnel (FCFA)</label>
          <input id="c_ca" class="form-control" type="number" min="0" step="1" name="chiffre_daffaire" value="{{ $demandes->chiffre_daffaire_previsionel }}">
        </div>
        @if ($formes)
          <div class="col-md-6">
            <label class="form-label" for="c_forme">Forme juridique</label>
            <select id="c_forme" class="form-select" name="{{ $formes[0] }}">
              @foreach ($formes[1] as $forme)
                <option value="{{ $forme->code }}" @if ($forme->code == $demandes->forme_juridique) selected @endif>{{ $forme->libelle }}</option>
              @endforeach
            </select>
          </div>
        @endif
        <div class="col-md-6">
          <label class="form-label" for="c_secteur">Secteur d’activité</label>
          <select id="c_secteur" class="form-select" name="secteur_activite" data-activites-url="{{ route('valeur.activite') }}" data-activites-cible="#c_activite" required>
            @foreach ($activites_all as $secteur)
              <option value="{{ $secteur->secteur_activite }}" @if ($secteur->secteur_activite == $demandes->activity_sector) selected @endif>{{ $secteur->secteur_activite }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label" for="c_activite">Activité principale</label>
          <select id="c_activite" class="form-select" name="activite_principale">
            @if ($activites)<option value="{{ $activites->Code }}" selected>{{ $activites->description }}</option>@endif
          </select>
          <div class="form-text">Changer de secteur recharge la liste des activités.</div>
        </div>
        <div class="col-12">
          <label class="form-label" for="c_objet">Objet social</label>
          <textarea id="c_objet" class="form-control" name="objet_social" rows="3">{{ $demandes->objet_social }}</textarea>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_lot">Lot</label>
          <input id="c_lot" class="form-control" name="lot" value="{{ optional($terrains)->numero_lot }}">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_section">Section</label>
          <input id="c_section" class="form-control" name="section" value="{{ optional($terrains)->numero_section }}">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_parcelle">Parcelle</label>
          <input id="c_parcelle" class="form-control" name="parcelle" value="{{ optional($terrains)->numero_parcelle }}">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_usage">Usage du terrain</label>
          <select id="c_usage" class="form-select" name="usage">
            @foreach ($usage_terrains as $usageTerrain)
              <option value="{{ $usageTerrain->Code }}" @if ($usageTerrain->Code == optional($terrains)->id_usage_terrain) selected @endif>{{ $usageTerrain->Libelle }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1" aria-hidden="true"></i>Enregistrer les corrections de l’entreprise</button>
      </div>
    </form>
  </div>

  {{-- Dirigeant --}}
  <div class="collapse" id="correction-dirigeant">
    <form action="{{ route('usager.update', $usager->id) }}" method="post" class="card-body border-top">
      @csrf
      @method('PUT')
      <input type="hidden" name="demande" value="{{ $demandes->id }}">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label" for="c_civilite">Civilité</label>
          <select id="c_civilite" class="form-select" name="civilite" required>
            @foreach ($civilites as $c)
              <option value="{{ $c->code }}" @if ($c->code == $usager->Civility) selected @endif>{{ $c->libelle }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label" for="c_nom">Nom</label>
          <input id="c_nom" class="form-control" name="nom" value="{{ $usager->NomRaisonSociale }}" required>
        </div>
        <div class="col-md-5">
          <label class="form-label" for="c_prenom">Prénom(s)</label>
          <input id="c_prenom" class="form-control" name="prenom" value="{{ $usager->Prenom }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label" for="c_naissance">Date de naissance</label>
          <input id="c_naissance" class="form-control" name="date_de_naissance" value="{{ $usager->DateNaissance ? format_date($usager->DateNaissance) : '' }}" placeholder="jj-mm-aaaa">
        </div>
        <div class="col-md-4">
          <label class="form-label" for="c_lieu">Lieu de naissance</label>
          <input id="c_lieu" class="form-control" name="lieu_naissance" value="{{ $usager->LieuNaissance }}">
        </div>
        <div class="col-md-4">
          <label class="form-label" for="c_situation">Situation matrimoniale</label>
          <select id="c_situation" class="form-select" name="situation_matrimoniale">
            @foreach ([1 => 'Célibataire', 2 => 'Marié(e)', 3 => 'Divorcé(e)'] as $code => $libelle)
              <option value="{{ $code }}" @if ($code == $usager->SituationMatrimoniale) selected @endif>{{ $libelle }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="c_profession">Profession</label>
          <select id="c_profession" class="form-select" name="profession">
            @foreach ($professions as $p)
              <option value="{{ $p->code }}" @if ($p->code == $usager->IdFonction) selected @endif>{{ $p->libelle }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_nationalite">Nationalité</label>
          <select id="c_nationalite" class="form-select" name="nationalite_usager">
            @foreach ($nationalites as $n)
              <option value="{{ $n->code }}" @if ($n->code == $usager->Nationality_No_) selected @endif>{{ $n->libelle }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_pays">Pays de résidence</label>
          <select id="c_pays" class="form-select" name="pays_usager">
            @foreach ($pays as $pa)
              <option value="{{ $pa->code }}" @if ($pa->code == $usager->Country_Code) selected @endif>{{ $pa->libelle }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_mobile">Téléphone mobile</label>
          <input id="c_mobile" class="form-control" name="tel_mobile" value="{{ $usager->Phone_No_ }}">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="c_bureau">Téléphone bureau</label>
          <input id="c_bureau" class="form-control" name="tel_bureau" value="{{ $usager->Tel_Bureau }}">
        </div>
        <div class="col-md-4">
          <label class="form-label" for="c_mail">E-mail</label>
          <input id="c_mail" class="form-control" type="email" name="mail" value="{{ $usager['E-Mail'] }}">
        </div>
        <div class="col-md-2">
          <label class="form-label" for="c_bp">Boîte postale</label>
          <input id="c_bp" class="form-control" name="boite_postale" value="{{ $usager->Boite_postale }}">
        </div>
      </div>
      <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1" aria-hidden="true"></i>Enregistrer les corrections du dirigeant</button>
      </div>
    </form>
  </div>
</div>
