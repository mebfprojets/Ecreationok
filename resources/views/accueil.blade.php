@extends('layouts.frontend')
@section('content')
{{-- Bannière : l'image (1080 × 151) est affichée en entier, dans ses proportions, sans être agrandie en hauteur ni rognée --}}
<div class="accueil-banniere">
  <img src="{{ asset('frontend/images/slider-main/bg1.jpeg') }}" width="1080" height="151"
       alt="Deux promoteurs déposent leur demande de création d’entreprise en ligne" class="accueil-banniere-image">
</div>
@auth
  <div class="accueil-banniere-action">
    <a href="{{ route('create.usager') }}" class="btn btn-success btn-lg"><i class="fas fa-plus-circle me-2" aria-hidden="true"></i>Créer mon entreprise</a>
  </div>
@endauth
@include('partials.frontend.accueil_demarches')
@include('partials.frontend.accueil_types_entreprise')

@include('partials.frontend.accueil_tarifs_statistiques')
@endsection

{{-- Fenêtres « Avant de commencer » et « Pièces à fournir » --}}
@section('modal_parpage')
  @include('partials.frontend.modales_pieces')
@endsection

@section('additionnel_script')
  <script src="{{ asset_version('js/accueil.js') }}"></script>
@endsection