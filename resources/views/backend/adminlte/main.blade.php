@include('backend.adminlte.header')
  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <h3 class="mb-0">@yield('title')</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end mb-0">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
              @hasSection('title')
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
              @endif
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="messages-flash">
          @include('flash::message')
          @foreach (['success' => ['success', 'fa-check-circle'], 'error' => ['danger', 'fa-exclamation-triangle'], 'message' => ['info', 'fa-info-circle']] as $cle => [$niveau, $icone])
            @if (session($cle))
              <div class="alert alert-{{ $niveau }} alert-dismissible fade show" role="alert">
                <i class="fas {{ $icone }} me-2" aria-hidden="true"></i>{{ session($cle) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
              </div>
            @endif
          @endforeach
          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i>{{ $errors->count() === 1 ? $errors->first() : 'Certaines informations sont à corriger :' }}
              @if ($errors->count() > 1)
                <ul class="mb-0 mt-1">@foreach ($errors->all() as $erreur)<li>{{ $erreur }}</li>@endforeach</ul>
              @endif
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
          @endif
        </div>
        @yield('content')
      </div>
    </div>
  </main>
@include('backend.adminlte.footer')
