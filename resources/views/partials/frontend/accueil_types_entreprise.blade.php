{{-- Page d'accueil : les types d'entreprise (accordéon) et l'aide aux promoteurs --}}
@php
    // [identifiant, titre, icône, couleur, résumé, points clés, formes, fenêtre des pièces]
    $types = [
        ['individuelle', 'Entreprise individuelle', 'fa-user-tie', 'vert',
            'Forme simplifiée d’entreprise, créée par une personne physique qui devient entrepreneur individuel.',
            [['fa-user', 'Créée par', 'une personne physique de plus de 20 ans'],
             ['fa-balance-scale', 'Responsabilité', 'l’entrepreneur est indéfiniment responsable des dettes de l’entreprise']],
            [], '#modal-piece_pp'],
        ['societaire', 'Entreprise sociétaire', 'fa-building', 'jaune',
            'Société commerciale créée par contrat entre deux personnes ou plus, qui affectent des biens (en numéraire, en nature ou en industrie) à une activité pour en partager le bénéfice ou profiter de l’économie qui en résulte.',
            [['fa-users', 'Créée par', 'deux associés ou plus, ou une seule personne (« associé unique »)'],
             ['fa-coins', 'Apports', 'en numéraire, en nature ou en industrie']],
            ['SARL' => 'Société à responsabilité limitée', 'SA' => 'Société anonyme', 'SAS' => 'Société par actions simplifiée',
             'SNC' => 'Société en nom collectif', 'SCS' => 'Société en commandite simple'],
            '#modal-piece_pm'],
        ['gie', 'Groupement d’intérêt économique', 'fa-hands-helping', 'rouge',
            'Organisation qui a pour but exclusif de mettre en œuvre, pour une durée déterminée, tous les moyens propres à faciliter ou à développer l’activité économique de ses membres et à en améliorer les résultats.',
            [['fa-balance-scale', 'Responsabilité', 'les membres sont solidairement et indéfiniment responsables des dettes du groupement'],
             ['fa-coins', 'Capital', 'le GIE peut être créé sans capital social'],
             ['fa-user-cog', 'Gestion', 'par un ou plusieurs administrateurs']],
            [], '#modal-piece_pm'],
    ];
    // Numéros d'assistance (comme dans l'en-tête du site)
    $telephones = ['02 21 21 21' => '+22602212121', '58 80 77 77' => '+22658807777', '56 62 02 02' => '+22656620202'];
@endphp
<section class="accueil-bloc accueil-types" aria-labelledby="titre-types">
  <div class="container">
    <div class="accueil-entete">
      <span class="accueil-surtitre">Types d’entreprise</span>
      <h2 id="titre-types" class="accueil-titre">Quelle forme pour votre entreprise ?</h2>
    </div>
    <div class="row g-4 align-items-start">
      <div class="col-lg-8">
        <div class="types-accordeon" id="accordeon-types">
          @foreach ($types as $index => [$id, $titre, $icone, $couleur, $resume, $points, $formes, $modalePieces])
            <div class="type-entreprise type-entreprise-{{ $couleur }}">
              <h3 class="m-0">
                <button class="type-entreprise-bouton {{ $index ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                        data-bs-target="#type-{{ $id }}" aria-expanded="{{ $index ? 'false' : 'true' }}" aria-controls="type-{{ $id }}">
                  <span class="type-entreprise-icone" aria-hidden="true"><i class="fas {{ $icone }}"></i></span>
                  <span class="flex-grow-1">{{ $titre }}</span>
                  <i class="fas fa-chevron-down type-entreprise-chevron" aria-hidden="true"></i>
                </button>
              </h3>
              <div id="type-{{ $id }}" class="collapse {{ $index ? '' : 'show' }}" data-bs-parent="#accordeon-types">
                <div class="type-entreprise-corps">
                  <p class="type-entreprise-resume">{{ $resume }}</p>
                  <ul class="type-entreprise-points">
                    @foreach ($points as [$iconePoint, $libelle, $texte])
                      <li><i class="fas {{ $iconePoint }} fa-fw" aria-hidden="true"></i><div><strong>{{ $libelle }} :</strong> {{ $texte }}</div></li>
                    @endforeach
                  </ul>
                  @if ($formes)
                    <div class="type-entreprise-formes">
                      <span class="type-entreprise-formes-titre">Formes de société</span>
                      @foreach ($formes as $sigle => $nom)
                        <span class="type-entreprise-forme" title="{{ $nom }}"><strong>{{ $sigle }}</strong> {{ $nom }}</span>
                      @endforeach
                    </div>
                  @endif
                  <div class="type-entreprise-actions">
                    <a href="{{ $modalePieces }}" class="btn btn-sm btn-success" data-bs-toggle="modal"><i class="fas fa-clipboard-list me-1" aria-hidden="true"></i>Pièces à fournir</a>
                    <a href="#titre-tarifs" class="btn btn-sm btn-outline-success"><i class="fas fa-tag me-1" aria-hidden="true"></i>Voir le tarif</a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="col-lg-4">
        <aside class="carte-aide" aria-labelledby="titre-aide">
          <span class="carte-aide-icone" aria-hidden="true"><i class="fas fa-headset"></i></span>
          <h3 id="titre-aide" class="carte-aide-titre">Besoin d’aide ?</h3>
          <p class="carte-aide-texte">Une question sur le choix de la forme, les pièces ou le paiement ? Nos conseillers CEFORE vous répondent.</p>
          <ul class="carte-aide-contacts">
            @foreach ($telephones as $affiche => $numero)
              <li><a href="tel:{{ $numero }}"><i class="fas fa-phone-alt" aria-hidden="true"></i>(+226) {{ $affiche }}</a></li>
            @endforeach
            {{-- Adresse encodée en entités HTML (ANSSI Vul-009 : pas d'adresse en clair pour les robots) --}}
            <li><a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#105;&#110;&#102;&#111;&#64;&#109;&#101;&#46;&#98;&#102;"><i class="fas fa-envelope" aria-hidden="true"></i>&#105;&#110;&#102;&#111;&#64;&#109;&#101;&#46;&#98;&#102;</a></li>
          </ul>
          <a href="#modal-infos" class="btn btn-warning w-100" data-bs-toggle="modal"><i class="fas fa-lightbulb me-1" aria-hidden="true"></i>Avant de commencer</a>
        </aside>
      </div>
    </div>
  </div>
</section>
