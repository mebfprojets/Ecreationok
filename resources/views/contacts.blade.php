@extends('layouts.frontend')

{{-- Contacts : siège, assistance e-Création et représentations CEFORE / CEFAC (config/representations.php) --}}
@section('content')
@php
    $representations = config('representations');
    // « 25 39 80 58 » -> lien d'appel +22625398058
    $appel = fn ($numero) => 'tel:+226'.preg_replace('/\D/', '', $numero);
@endphp
<div class="container parcours-demande page-contacts">
  <h1 class="titre-parcours">Nous contacter</h1>
  <p class="sous-titre-parcours">Le siège de la MEBF à Ouagadougou et les {{ count($representations['regions']) }} représentations CEFORE/CEFAC vous accueillent pour vos formalités de création d’entreprise.</p>

  <div class="row g-3 mb-4">
    <div class="col-lg-7">
      <article class="carte-contact carte-contact-siege h-100">
        <span class="carte-contact-icone" aria-hidden="true"><i class="fas fa-building"></i></span>
        <div>
          <div class="carte-contact-surtitre">Siège · CEFORE de Ouagadougou</div>
          <h2 class="carte-contact-titre">Maison de l’Entreprise du Burkina Faso</h2>
          <p class="carte-contact-adresse"><i class="fas fa-map-marker-alt fa-fw" aria-hidden="true"></i>{{ $representations['siege']['adresse'] }}</p>
          <ul class="carte-contact-telephones">
            @foreach ($representations['siege']['telephones'] as $numero)
              <li><a href="{{ $appel($numero) }}"><i class="fas fa-phone-alt" aria-hidden="true"></i>(+226) {{ $numero }}</a></li>
            @endforeach
          </ul>
        </div>
      </article>
    </div>
    <div class="col-lg-5">
      <article class="carte-contact carte-contact-assistance h-100">
        <span class="carte-contact-icone" aria-hidden="true"><i class="fas fa-headset"></i></span>
        <div>
          <div class="carte-contact-surtitre">Plateforme e-Création</div>
          <h2 class="carte-contact-titre">Assistance en ligne</h2>
          <ul class="carte-contact-telephones">
            @foreach ($representations['assistance']['telephones'] as $numero)
              <li><a href="{{ $appel($numero) }}"><i class="fas fa-phone-alt" aria-hidden="true"></i>(+226) {{ $numero }}</a></li>
            @endforeach
            {{-- Adresse encodée en entités HTML (ANSSI Vul-009 : pas d'adresse en clair pour les robots) --}}
            <li><a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#105;&#110;&#102;&#111;&#64;&#109;&#101;&#46;&#98;&#102;"><i class="fas fa-envelope" aria-hidden="true"></i>&#105;&#110;&#102;&#111;&#64;&#109;&#101;&#46;&#98;&#102;</a></li>
          </ul>
        </div>
      </article>
    </div>
  </div>

  <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3">
    <h2 class="titre-section-contacts">Représentations CEFORE / CEFAC</h2>
    <div class="recherche-contacts">
      <label for="recherche-ville" class="visually-hidden">Rechercher une ville</label>
      <i class="fas fa-search" aria-hidden="true"></i>
      <input type="search" id="recherche-ville" class="form-control" placeholder="Rechercher une ville…" autocomplete="off" data-recherche-contacts>
    </div>
  </div>

  <div class="row g-3" data-liste-contacts>
    @foreach (collect($representations['regions'])->sortBy('ville', SORT_NATURAL | SORT_FLAG_CASE) as $representation)
      <div class="col-md-6 col-lg-4" data-contact="{{ mb_strtolower($representation['ville'].' '.$representation['adresse']) }}">
        <article class="carte-contact h-100">
          <div>
            <h3 class="carte-contact-ville"><i class="fas fa-map-pin" aria-hidden="true"></i>{{ $representation['ville'] }}</h3>
            <p class="carte-contact-adresse">{{ $representation['adresse'] }}</p>
            <ul class="carte-contact-telephones">
              @foreach ($representation['telephones'] as $numero)
                <li><a href="{{ $appel($numero) }}"><i class="fas fa-phone-alt" aria-hidden="true"></i>(+226) {{ $numero }}</a></li>
              @endforeach
            </ul>
          </div>
        </article>
      </div>
    @endforeach
  </div>
  <p class="text-muted mt-3 d-none" data-aucun-contact><i class="fas fa-info-circle me-1" aria-hidden="true"></i>Aucune représentation ne correspond à cette recherche.</p>
</div>
@endsection

@section('additionnel_script')
  <script src="{{ asset_version('js/contacts.js') }}"></script>
@endsection
