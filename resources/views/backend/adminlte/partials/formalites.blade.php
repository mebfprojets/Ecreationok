{{-- Formalités de retour (RCCM, IFU, CNSS, CPC) : fonctionnement inchangé, seule la présentation suit la nouvelle page --}}
<div class="card mb-3">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-stamp me-2 text-secondary" aria-hidden="true"></i>Formalités de retour</h3></div>
  <div class="list-group list-group-flush">
    @foreach ($typepieceformaliteretours as $typejointe)
      <div class="list-group-item d-flex align-items-center gap-2">
        <span class="flex-grow-1">{{ $typejointe->libelle }}</span>
        @if (getformalite($typejointe->id, $demandes->id))
          <span class="badge text-bg-success">Enregistrée</span>
          <a href="{{ route('show_formalite_retour', getformalite($typejointe->id, $demandes->id)) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Voir"><i class="fas fa-eye" aria-hidden="true"></i></a>
          @can('save_formalite_retour', Auth::user())
            <a href="#modal-update-piece" data-bs-toggle="modal" data-csp-click="gettypepiece_update" data-csp-click-args="{{ json_encode([(string) $typejointe->id, (string) $typejointe->libelle]) }}" class="btn btn-sm btn-outline-primary" title="Remplacer"><i class="fas fa-pen" aria-hidden="true"></i></a>
          @endcan
        @else
          <span class="badge text-bg-light border">À joindre</span>
          @can('save_formalite_retour', Auth::user())
            <a href="#modal-add-piece" data-bs-toggle="modal" data-csp-click="gettypepiece" data-csp-click-args="{{ json_encode([(string) $typejointe->id, (string) $typejointe->libelle]) }}" class="btn btn-sm btn-outline-primary" title="Ajouter"><i class="fas fa-plus" aria-hidden="true"></i></a>
          @endcan
        @endif
      </div>
    @endforeach
  </div>
</div>

@foreach (['modal-add-piece' => ['add_formalite_retour', 'Ajouter la formalité', 'typepiece', 'p_typepiece'], 'modal-update-piece' => ['update_formalite_retour', 'Remplacer la formalité', 'typepiece_u', 'p_typepiece_u']] as $idFenetre => [$route, $titre, $idType, $classeLibelle])
  <div class="modal fade" id="{{ $idFenetre }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" action="{{ route($route) }}" enctype="multipart/form-data">
          @csrf
          <input id="{{ $idType }}" type="hidden" name="typepiece">
          <input type="hidden" name="demande" value="{{ $demandes->id }}">
          <div class="modal-header">
            <h5 class="modal-title">{{ $titre }} <span class="{{ $classeLibelle }}"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <label class="form-label" for="copie_{{ $idType }}">Copie de la formalité (PDF, JPG ou PNG)</label>
            <input id="copie_{{ $idType }}" class="form-control" type="file" name="copie_de_la_formalite" accept=".pdf,.jpg,.jpeg,.png" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

<script nonce="{{ $cspNonce ?? '' }}">
  function gettypepiece(id, libelle) { $('#typepiece').val(id); $('.p_typepiece').text(libelle); }
  function gettypepiece_update(id, libelle) { $('#typepiece_u').val(id); $('.p_typepiece_u').text(libelle); }
</script>
