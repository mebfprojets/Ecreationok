<!DOCTYPE html>
{{-- Thème clair imposé : les vues existantes ont des couleurs prévues pour un fond clair --}}
<html lang="fr" data-bs-theme="light" data-lte-color-mode="off">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@hasSection('title')@yield('title') — @endif e-Création · Espace agents</title>

  {{-- Bibliothèques servies depuis public/vendor (versions listées dans public/vendor/VERSIONS.md) --}}
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free-5.15.4/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte-4.10.0/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/datatables-2.3.8/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/datatables-2.3.8/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/datatables-2.3.8/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset_version('css/espace-agents.css') }}">

  {{-- jQuery dès l'en-tête : les scripts écrits dans les pages s'en servent --}}
  <script src="{{ asset('vendor/jquery-3.7.1/jquery.min.js') }}"></script>
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
<div class="app-wrapper">

  <nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Afficher ou masquer le menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
          </a>
        </li>
        <li class="nav-item d-none d-md-block">
          <a href="{{ route('dashboard') }}" class="nav-link">Tableau de bord</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#" data-lte-toggle="fullscreen" role="button" aria-label="Plein écran">
            <i data-lte-icon="maximize" class="fas fa-expand-arrows-alt" aria-hidden="true"></i>
            <i data-lte-icon="minimize" class="fas fa-compress-arrows-alt" style="display: none" aria-hidden="true"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="far fa-user-circle me-1" aria-hidden="true"></i>
            <span class="d-none d-md-inline">{{ Auth::user()->prenom }} {{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-end">
            <div class="dropdown-header">
              <div class="fw-semibold text-body">{{ Auth::user()->prenom }} {{ Auth::user()->name }}</div>
              <div class="small">{{ Auth::user()->email }}</div>
            </div>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item text-danger" data-csp-click="__deconnexion">
              <i class="fas fa-sign-out-alt me-2" aria-hidden="true"></i>Se déconnecter
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
      <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('frontend/images/logo-me.jpg') }}" alt="Logo MEBF" class="brand-image opacity-75 shadow" width="33" height="33">
        <span class="brand-text fw-light">e-Création</span>
      </a>
    </div>

    <div class="sidebar-wrapper">
      <nav class="mt-2" aria-label="Menu principal">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
          @can('lister.demande', Auth::user())
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link @yield('dashboard')">
              <i class="nav-icon fas fa-tachometer-alt" aria-hidden="true"></i>
              <p>Tableau de bord</p>
            </a>
          </li>
          <li class="nav-item @yield('demandes')">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folder-open" aria-hidden="true"></i>
              <p>Demandes <i class="nav-arrow fas fa-angle-right" aria-hidden="true"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('list') }}?etat=0" class="nav-link @yield('demande_a_valider')">
                  <i class="nav-icon fas fa-hourglass-half" aria-hidden="true"></i>
                  <p>À valider</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list') }}?etat=1" class="nav-link @yield('demande_valider')">
                  <i class="nav-icon fas fa-check-circle" aria-hidden="true"></i>
                  <p>Validées</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list.rejet') }}" class="nav-link @yield('liste-rejetee')">
                  <i class="nav-icon fas fa-times-circle" aria-hidden="true"></i>
                  <p>Rejetées</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list.en_attente_de_partenaire') }}" class="nav-link @yield('liste_partenaire')">
                  <i class="nav-icon fas fa-handshake" aria-hidden="true"></i>
                  <p>En attente des partenaires</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('all.list') }}" class="nav-link @yield('all')">
              <i class="nav-icon fas fa-list-alt" aria-hidden="true"></i>
              <p>Toutes les demandes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('promoteur.liste') }}" class="nav-link @yield('promoteur')">
              <i class="nav-icon fas fa-user-tie" aria-hidden="true"></i>
              <p>Promoteurs</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('user.compte') }}" class="nav-link @yield('compte')">
              <i class="nav-icon fas fa-id-card" aria-hidden="true"></i>
              <p>Comptes des promoteurs</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('statistique') }}" class="nav-link @yield('statistique')">
              <i class="nav-icon fas fa-chart-bar" aria-hidden="true"></i>
              <p>Statistiques</p>
            </a>
          </li>
          @endcan

          @can('user.create', Auth::user())
          <li class="nav-header">ADMINISTRATION</li>
          <li class="nav-item @yield('administration')">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs" aria-hidden="true"></i>
              <p>Administration <i class="nav-arrow fas fa-angle-right" aria-hidden="true"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link @yield('administration-user')">
                  <i class="nav-icon fas fa-users" aria-hidden="true"></i>
                  <p>Agents</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link @yield('administration-role')">
                  <i class="nav-icon fas fa-user-shield" aria-hidden="true"></i>
                  <p>Rôles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('permissions.index') }}" class="nav-link @yield('administration-permission')">
                  <i class="nav-icon fas fa-key" aria-hidden="true"></i>
                  <p>Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('parametres.index') }}" class="nav-link @yield('administration-parametre')">
                  <i class="nav-icon fas fa-sliders-h" aria-hidden="true"></i>
                  <p>Paramètres</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('valeurs.index') }}" class="nav-link @yield('administration-valeur')">
                  <i class="nav-icon fas fa-list-ul" aria-hidden="true"></i>
                  <p>Valeurs</p>
                </a>
              </li>
            </ul>
          </li>
          @endcan
        </ul>
      </nav>
    </div>
  </aside>
