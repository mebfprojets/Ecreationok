@extends('layouts.frontend')
@section('alertes_locales', '1')

{{-- Pièces à fournir : entreprise individuelle --}}
@section('content')
  @include('demande.partials.depot_pieces')
@endsection

@section('additionnel_script')
  <script src="{{ asset_version('js/depot-pieces.js') }}"></script>
@endsection
