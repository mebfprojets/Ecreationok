@extends("backend.adminlte.main")
@section('title', 'Agents')
@section('administration', 'menu-open')
@section('administration-user', 'active')

@section('content')
<div class="card">
  <div class="card-header d-flex flex-wrap align-items-center gap-2">
    <h3 class="card-title flex-grow-1"><i class="fas fa-users me-2 text-secondary" aria-hidden="true"></i>Comptes des agents</h3>
    @can('user.create', Auth::user())
      <a href="{{ route('user.create') }}" class="btn btn-sm btn-success"><i class="fas fa-user-plus me-1" aria-hidden="true"></i>Nouvel agent</a>
    @endcan
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped table-sm align-middle w-100">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom(s)</th>
          <th>E-mail</th>
          <th>Téléphone</th>
          <th>CEFORE</th>
          <th>Dernier lien envoyé</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          @php $dernierLien = $derniersLiens[mb_strtolower(trim((string) $user->email))] ?? null; @endphp
          <tr>
            <td class="fw-semibold">{{ $user->name }}</td>
            <td>{{ $user->prenom }}</td>
            <td class="text-break">{{ $user->email }}</td>
            <td class="text-nowrap">{{ $user->telephone }}</td>
            <td class="text-nowrap">{{ $user->organisation === '001000' ? 'Siège' : ($organisations[$user->organisation] ?? $user->organisation) }}</td>
            <td class="text-nowrap small" data-order="{{ optional($dernierLien)->timestamp ?? 0 }}">
              {{ $dernierLien ? $dernierLien->format('d/m/Y à H:i') : '—' }}
            </td>
            <td class="text-end text-nowrap">
              @can('user.create', Auth::user())
                <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-outline-secondary" title="Modifier le compte">
                  <i class="fas fa-edit" aria-hidden="true"></i><span class="visually-hidden">Modifier</span>
                </a>
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modal-reinitialisation"
                        data-action="{{ route('user.reinitialisation', $user) }}" data-nom="{{ trim($user->prenom.' '.$user->name) }}" data-email="{{ $user->email }}"
                        title="Envoyer un lien de réinitialisation du mot de passe">
                  <i class="fas fa-key me-1" aria-hidden="true"></i>Réinitialiser
                </button>
              @endcan
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Confirmation avant l'envoi du lien de réinitialisation (formulaire complété par espace-agents.js) --}}
@can('user.create', Auth::user())
  <div class="modal fade" id="modal-reinitialisation" tabindex="-1" aria-labelledby="modal-reinitialisation-titre" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" method="POST" action="#" data-form-reinitialisation>
        @csrf
        <div class="modal-header">
          <h3 class="modal-title h5" id="modal-reinitialisation-titre"><i class="fas fa-key me-2 text-warning" aria-hidden="true"></i>Réinitialiser le compte</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <p class="mb-2">Un e-mail va être envoyé à <strong data-reinit-nom></strong> (<span class="text-break" data-reinit-email></span>) avec un lien pour choisir un nouveau mot de passe.</p>
          <ul class="small text-muted mb-0">
            <li>Le lien est valable {{ \App\Support\ReinitialisationMotDePasse::DUREE_MINUTES }} minutes et ne sert qu’une fois.</li>
            <li>Le mot de passe actuel reste valable tant que l’agent n’en a pas choisi un nouveau.</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-warning"><i class="fas fa-paper-plane me-1" aria-hidden="true"></i>Envoyer le lien</button>
        </div>
      </form>
    </div>
  </div>
@endcan
@endsection
