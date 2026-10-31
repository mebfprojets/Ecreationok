@extends('layouts.frontend')
@section('alertes_locales', '1')

@section('content')
@php
    // [code, titre, description, icône, couleur, pièces]
    $types = [
        ['ei', 'Entreprise individuelle', 'Exploitée par une seule personne physique, sans création de société.', 'fa-user-tie', 'vert', \App\Models\PieceJointe::piecesADeposer('ei')],
        ['es', 'Entreprise sociétaire', 'SARL, SA, SAS, SASU, EURL et autres formes de société.', 'fa-building', 'jaune', \App\Models\PieceJointe::piecesADeposer('es')],
        ['gie', 'Groupement d’intérêt économique (GIE)', 'Regroupement d’entreprises ou d’organismes autour d’une activité commune.', 'fa-hands-helping', 'bleu', \App\Models\PieceJointe::piecesADeposer('gie')],
    ];
@endphp
<div class="container parcours-demande">
  <nav aria-label="Étapes de la demande" class="etapes-parcours">
    <span class="etape-parcours active"><span class="etape-numero">1</span>Type d’entreprise</span>
    <span class="etape-parcours"><span class="etape-numero">2</span>Pièces à fournir</span>
    <span class="etape-parcours"><span class="etape-numero">3</span>Formulaire</span>
    <span class="etape-parcours"><span class="etape-numero">4</span>Paiement</span>
  </nav>

  <h1 class="titre-parcours">Quel type d’entreprise souhaitez-vous créer ?</h1>
  <p class="sous-titre-parcours">Choisissez le type qui correspond à votre projet : la liste des pièces à fournir en dépend.</p>

  @include('demande.partials.promoteur', ['variante' => 'bandeau'])

  @if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
  @endif

  <div class="row g-4 choix-types">
    @foreach ($types as [$code, $titre, $description, $icone, $couleur, $pieces])
      @php $indisponible = $code === 'ei' && $aDejaUneEI; @endphp
      <div class="col-md-6 col-lg-4">
        @if ($indisponible)
          <div class="carte-type carte-type-{{ $couleur }} carte-type-indisponible" aria-disabled="true">
        @else
          <a href="{{ route('process.type.entreprise', $code) }}" class="carte-type carte-type-{{ $couleur }}">
        @endif
            <span class="carte-type-icone" aria-hidden="true"><i class="fas {{ $icone }}"></i></span>
            <h2 class="carte-type-titre">{{ $titre }}</h2>
            <p class="carte-type-description">{{ $description }}</p>
            <div class="carte-type-pieces">
              <div class="carte-type-pieces-titre">{{ count($pieces) }} pièces à préparer</div>
              <ul>
                @foreach ($pieces as [$libelle])
                  <li>{{ $libelle }}</li>
                @endforeach
              </ul>
            </div>
            @if ($indisponible)
              <span class="carte-type-action"><i class="fas fa-lock me-1" aria-hidden="true"></i>Vous avez déjà une entreprise individuelle</span>
            @else
              <span class="carte-type-action">Choisir <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></span>
            @endif
        @if ($indisponible)
          </div>
        @else
          </a>
        @endif
      </div>
    @endforeach
  </div>

  <div class="actions-parcours">
    <a href="{{ route('index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Retour à l’accueil</a>
  </div>
</div>
@endsection
