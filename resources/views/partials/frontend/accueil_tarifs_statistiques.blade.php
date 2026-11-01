{{--
  Page d'accueil : coût des formalités et statistiques de l'année en cours.
  $statistiques : DemandeController::statistiquesAccueil(). Compteurs animés : public/js/accueil.js
--}}
@php
    $nombre = fn ($n) => number_format((int) $n, 0, ',', ' ');
    // Formalités : sigle => signification (infobulle)
    $formalites = [
        'RCCM' => 'Immatriculation au Registre du commerce et du crédit mobilier',
        'IFU' => 'Identifiant financier unique (impôts)',
        'CNSS' => 'Immatriculation à la Caisse nationale de sécurité sociale',
        'CPC' => 'Carte professionnelle de commerçant',
    ];
    // [titre, icône, couleur, description, [[libellé de l'option, montant, formalités]]]
    $tarifs = [
        ['Entreprise individuelle', 'fa-user-tie', 'vert', 'Une seule personne physique, sans création de société.',
            [[null, 47380, ['RCCM', 'IFU', 'CNSS', 'CPC']]]],
        ['Entreprise sociétaire', 'fa-building', 'jaune', 'SARL, SA, SAS, SASU, EURL et autres sociétés.',
            [['Sans CPC', 65540, ['RCCM', 'IFU', 'CNSS']], ['Avec CPC', 83430, ['RCCM', 'IFU', 'CNSS', 'CPC']]]],
        ['Groupement d’intérêt économique', 'fa-hands-helping', 'rouge', 'Entreprises ou organismes réunis autour d’une activité commune.',
            [['Sans CPC', 65540, ['RCCM', 'IFU', 'CNSS']], ['Avec CPC', 83430, ['RCCM', 'IFU', 'CNSS', 'CPC']]]],
    ];
    $s = $statistiques;
    $part = fn ($n) => $s['total'] ? round($n * 100 / $s['total']) : 0;
@endphp

{{-- Coût des formalités --}}
<section class="accueil-bloc accueil-tarifs" aria-labelledby="titre-tarifs">
  <div class="container">
    <div class="accueil-entete">
      <span class="accueil-surtitre">Tarifs</span>
      <h2 id="titre-tarifs" class="accueil-titre">Coût des formalités</h2>
      <p class="accueil-intro">Un montant unique couvre toutes les formalités de création, payé en ligne par Orange Money ou Moov Money.</p>
    </div>
    <div class="row g-4">
      @foreach ($tarifs as [$titre, $icone, $couleur, $description, $options])
        <div class="col-md-6 col-lg-4">
          <article class="carte-tarif carte-tarif-{{ $couleur }}">
            <div class="carte-tarif-entete">
              <span class="carte-tarif-icone" aria-hidden="true"><i class="fas {{ $icone }}"></i></span>
              <h3 class="carte-tarif-titre">{{ $titre }}</h3>
            </div>
            <p class="carte-tarif-description">{{ $description }}</p>
            @foreach ($options as [$option, $montant, $incluses])
              <div class="carte-tarif-option">
                @if ($option)<div class="carte-tarif-libelle">{{ $option }}</div>@endif
                <div class="carte-tarif-montant">{{ $nombre($montant) }} <span>F CFA</span></div>
                <ul class="carte-tarif-formalites" aria-label="Formalités incluses">
                  @foreach ($incluses as $sigle)
                    <li title="{{ $formalites[$sigle] }}"><i class="fas fa-check" aria-hidden="true"></i>{{ $sigle }}</li>
                  @endforeach
                </ul>
              </div>
            @endforeach
          </article>
        </div>
      @endforeach
    </div>
    <dl class="accueil-legende">
      @foreach ($formalites as $sigle => $signification)
        <div><dt>{{ $sigle }}</dt><dd>{{ $signification }}</dd></div>
      @endforeach
    </dl>
  </div>
</section>

{{-- Statistiques de l'année en cours --}}
<section class="accueil-bloc accueil-statistiques" aria-labelledby="titre-statistiques">
  <div class="container">
    <div class="accueil-entete">
      <span class="accueil-surtitre">Statistiques {{ $s['annee'] }}</span>
      <h2 id="titre-statistiques" class="accueil-titre">La création d’entreprise en {{ $s['annee'] }}</h2>
    </div>

    <div class="row g-3 g-lg-4">
      @foreach ([
          ['fa-file-signature', $s['total'], 'Demandes de création', 'dont '.$nombre($s['validees']).' validées par les CEFORE'],
          ['fa-user-tie', $s['individuelles'], 'Entreprises individuelles', $part($s['individuelles']).' % des demandes'],
          ['fa-building', $s['societaires'], 'Sociétés et GIE', $part($s['societaires']).' % des demandes'],
          ['fa-calendar-check', $s['mois_en_cours'], 'En '.$s['nom_mois'], 'mois en cours, au '.now()->format('d/m')],
      ] as [$icone, $valeur, $libelle, $precision])
        <div class="col-6 col-lg-3">
          <div class="chiffre-cle">
            <span class="chiffre-cle-icone" aria-hidden="true"><i class="fas {{ $icone }}"></i></span>
            {{-- Valeur finale dans la page (lisible sans JavaScript) ; animée par accueil.js --}}
            <div class="chiffre-cle-valeur" data-compteur="{{ (int) $valeur }}">{{ $nombre($valeur) }}</div>
            <div class="chiffre-cle-libelle">{{ $libelle }}</div>
            <div class="chiffre-cle-precision">{{ $precision }}</div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
