{{--
  Promoteur lié au compte connecté.
  $variante : 'bandeau' (une ligne, en tête des pages du parcours) ou 'fiche' (détail complet, étape 1 du formulaire).
--}}
@php
    $variante = $variante ?? 'bandeau';
    $nom = mb_strtoupper(trim((string) $usager->NomRaisonSociale));
    $prenom = mb_convert_case(mb_strtolower(trim((string) $usager->Prenom)), MB_CASE_TITLE);
    $initiales = mb_strtoupper(mb_substr($prenom, 0, 1).mb_substr($nom, 0, 1)) ?: '?';
    $email = mb_strtolower(trim((string) ($usager->{'E-Mail'} ?: optional(Auth::user())->email))) ?: null;   // souvent saisi en majuscules
    $valeur = fn ($v) => filled($v) ? $v : null;
    $dateNaissance = null;
    if (filled($usager->DateNaissance)) {
        try { $dateNaissance = \Carbon\Carbon::parse($usager->DateNaissance)->format('d/m/Y'); } catch (\Throwable $e) { $dateNaissance = $usager->DateNaissance; }
    }
@endphp

@if ($variante === 'bandeau')
  <div class="fiche-promoteur fiche-promoteur-bandeau">
    <span class="fiche-promoteur-avatar" aria-hidden="true">{{ $initiales }}</span>
    <div class="fiche-promoteur-identite">
      <div class="fiche-promoteur-surtitre">Promoteur lié à votre compte</div>
      <div class="fiche-promoteur-nom">{{ $nom }} {{ $prenom }}</div>
    </div>
    <ul class="fiche-promoteur-contacts">
      @if ($valeur($usager->CIN))<li><i class="fas fa-id-card" aria-hidden="true"></i><span class="visually-hidden">N° de pièce d’identité :</span>{{ $usager->CIN }}</li>@endif
      @if ($valeur($usager->Phone_No_))<li><i class="fas fa-phone-alt" aria-hidden="true"></i><span class="visually-hidden">Téléphone :</span>{{ $usager->Phone_No_ }}</li>@endif
      @if ($email)<li><i class="fas fa-envelope" aria-hidden="true"></i><span class="visually-hidden">E-mail :</span>{{ $email }}</li>@endif
    </ul>
  </div>
@else
  @php
      $adresse = collect([
          getvaleur('regions', $usager->Region_Code),
          getvaleur('provinces', $usager->Province_Code),
          getvaleur('commune_departements', $usager->Commun_Departement_Code),
          getvaleur('secteur_villages', $usager->Code_Secteur_Village),
      ])->filter()->implode(' · ');
      $naissance = collect([$dateNaissance, $valeur($usager->LieuNaissance) ? 'à '.$usager->LieuNaissance : null])->filter()->implode(' ');
      $champs = [
          ['fa-birthday-cake', 'Naissance', $naissance],
          ['fa-id-card', 'N° de pièce d’identité', $valeur($usager->CIN)],
          ['fa-mobile-alt', 'Mobile 1', $valeur($usager->Phone_No_)],
          ['fa-phone-alt', 'Mobile 2', $valeur($usager->Tel_Bureau)],
          ['fa-envelope', 'E-mail', $email],
          ['fa-map-marker-alt', 'Adresse', $adresse],
      ];
  @endphp
  <section class="fiche-promoteur fiche-promoteur-complete" aria-labelledby="fiche-promoteur-titre">
    <div class="fiche-promoteur-entete">
      <span class="fiche-promoteur-avatar" aria-hidden="true">{{ $initiales }}</span>
      <div class="fiche-promoteur-identite">
        <div class="fiche-promoteur-surtitre">Promoteur lié à votre compte</div>
        <h5 class="fiche-promoteur-nom mb-0" id="fiche-promoteur-titre">{{ $nom }} {{ $prenom }}</h5>
      </div>
      <span class="badge fiche-promoteur-badge"><i class="fas fa-user-check me-1" aria-hidden="true"></i>Promoteur</span>
    </div>
    <dl class="fiche-promoteur-champs">
      @foreach ($champs as [$icone, $libelle, $contenu])
        <div class="fiche-promoteur-champ {{ $libelle === 'Adresse' ? 'fiche-promoteur-champ-large' : '' }}">
          <dt><i class="fas {{ $icone }} fa-fw" aria-hidden="true"></i>{{ $libelle }}</dt>
          <dd class="{{ $contenu ? '' : 'text-muted fst-italic' }}">{{ $contenu ?: 'Non renseigné' }}</dd>
        </div>
      @endforeach
    </dl>
    <div class="fiche-promoteur-pied">
      <span><i class="fas fa-info-circle me-1" aria-hidden="true"></i>Ces informations seront reprises dans votre demande.</span>
      <span>Fiche créée le {{ optional($usager->created_at)->format('d/m/Y') ?? '—' }}@if ($usager->updated_at && $usager->updated_at != $usager->created_at) · mise à jour le {{ $usager->updated_at->format('d/m/Y') }}@endif</span>
    </div>
  </section>
@endif
