{{-- Messages flash (laracasts/flash) au format Bootstrap 5. Le texte est échappé : jamais de HTML dans un message. --}}
@foreach (session('flash_notification', collect())->toArray() as $message)
    @php
        $niveau = $message['level'] === 'error' ? 'danger' : $message['level'];
        $icone = ['success' => 'fa-check-circle', 'danger' => 'fa-exclamation-triangle', 'warning' => 'fa-exclamation-circle'][$niveau] ?? 'fa-info-circle';
    @endphp
    <div class="alert alert-{{ $niveau }} alert-dismissible fade show {{ $message['important'] ? 'alert-important' : '' }}" role="alert">
        <i class="fas {{ $icone }} me-2" aria-hidden="true"></i>{{ $message['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endforeach

{{ session()->forget('flash_notification') }}
