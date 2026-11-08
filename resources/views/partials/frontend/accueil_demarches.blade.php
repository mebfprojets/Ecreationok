{{-- Page d'accueil : les démarches (avant de commencer, personne physique, personne morale) --}}
@php
    // [image, titre, sous-titre, texte, actions : [libellé, icône, lien, type (modale / externe), principal ?]]
    $demarches = [
        ['customer-service.png', 'Avant de commencer', 'Les étapes préalables',
            'Vérifiez d’abord la disponibilité du nom commercial, puis préparez les pièces de votre dossier.',
            [['Lire la suite', 'fa-book-open', '#modal-infos', 'modale', true],
             ['Vérifier un nom commercial', 'fa-search', '#modal-verifier-nomCommercial', 'modale', false]]],
        ['PP.png', 'Personne physique', 'Entreprise individuelle',
            'Pour exercer seul une activité commerciale, artisanale ou de services.',
            [['Pièces à fournir', 'fa-clipboard-list', '#modal-piece_pp', 'modale', true],
             ['Formulaire de renseignement', 'fa-file-pdf', 'https://www.me.bf/wp-content/uploads/2024/01/Formalite-personne-physique.pdf', 'externe', false]]],
        ['entreprise.png', 'Personne morale', 'Entreprise sociétaire',
            'Pour créer une société (SARL, SA, SAS…) seul ou avec des associés.',
            [['Pièces à fournir', 'fa-clipboard-list', '#modal-piece_pm', 'modale', true],
             ['Formulaire de renseignement', 'fa-file-pdf', 'https://www.me.bf/wp-content/uploads/2024/01/Formalite-personne-morale.pdf', 'externe', false]]],
    ];
@endphp
<section class="accueil-bloc accueil-demarches" aria-labelledby="titre-demarches">
  <div class="container">
    <div class="accueil-entete">
      <span class="accueil-surtitre">Vos démarches</span>
      <h2 id="titre-demarches" class="accueil-titre">Préparer votre création d’entreprise</h2>
    </div>
    <div class="row g-4">
      @foreach ($demarches as [$image, $titre, $sousTitre, $texte, $actions])
        <div class="col-md-4">
          <article class="carte-demarche">
            <span class="carte-demarche-image"><img src="{{ asset('frontend/images/'.$image) }}" alt="" width="72" height="72" loading="lazy"></span>
            <h3 class="carte-demarche-titre">{{ $titre }}</h3>
            <div class="carte-demarche-sous-titre">{{ $sousTitre }}</div>
            <p class="carte-demarche-texte">{{ $texte }}</p>
            <div class="carte-demarche-actions">
              @foreach ($actions as [$libelle, $icone, $lien, $type, $principal])
                <a href="{{ $lien }}" class="btn btn-sm {{ $principal ? 'btn-success' : 'btn-outline-success' }}"
                   @if ($type === 'modale') data-bs-toggle="modal" @else target="_blank" rel="noopener" @endif>
                  <i class="fas {{ $icone }} me-1" aria-hidden="true"></i>{{ $libelle }}
                  @if ($type === 'externe')<i class="fas fa-external-link-alt ms-1 small opacity-75" aria-hidden="true"></i><span class="visually-hidden"> (nouvel onglet)</span>@endif
                </a>
              @endforeach
            </div>
          </article>
        </div>
      @endforeach
    </div>
  </div>
</section>
