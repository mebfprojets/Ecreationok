{{-- Activité du promoteur : son parcours sur cette demande et l'historique des connexions de son compte --}}
<div class="card mb-3" id="activite-promoteur">
  <div class="card-header d-flex align-items-center flex-wrap gap-2">
    <h3 class="card-title flex-grow-1"><i class="fas fa-user-clock me-2 text-secondary" aria-hidden="true"></i>Activité du promoteur</h3>
    <ul class="nav nav-pills nav-sm onglets-activite" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#onglet-parcours" type="button" role="tab" aria-controls="onglet-parcours" aria-selected="true">
          Parcours <span class="badge text-bg-light border ms-1">{{ $parcoursPromoteur->count() }}</span>
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#onglet-connexions" type="button" role="tab" aria-controls="onglet-connexions" aria-selected="false">
          Connexions <span class="badge text-bg-light border ms-1">{{ $resumeConnexions['connexions'] }}</span>
          @if ($resumeConnexions['echecs_30_jours'] > 0)
            <span class="badge text-bg-danger ms-1" title="Tentatives échouées sur les 30 derniers jours">{{ $resumeConnexions['echecs_30_jours'] }}</span>
          @endif
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#onglet-emails" type="button" role="tab" aria-controls="onglet-emails" aria-selected="false">
          E-mails <span class="badge text-bg-light border ms-1">{{ $emailsEnvoyes->count() }}</span>
          @if ($resumeConnexions['emails_echec'] > 0)
            <span class="badge text-bg-danger ms-1" title="Envois en échec">{{ $resumeConnexions['emails_echec'] }}</span>
          @endif
        </button>
      </li>
    </ul>
  </div>
  <div class="card-body tab-content">
    {{-- Parcours --}}
    <div class="tab-pane fade show active" id="onglet-parcours" role="tabpanel">
      @if ($parcoursPromoteur->isEmpty())
        <p class="text-muted mb-0">Aucune activité retrouvée.</p>
      @else
        <ul class="liste-activite">
          @foreach ($parcoursPromoteur as $evenement)
            <li>
              <i class="fas {{ $evenement['icone'] }} fa-fw" aria-hidden="true"></i>
              <div class="flex-grow-1">
                <div class="d-flex flex-wrap justify-content-between gap-2">
                  <span class="fw-semibold">{{ $evenement['titre'] }}</span>
                  {{-- Certaines tables n'enregistrent que la date (sans heure) : on n'affiche alors pas « à 00:00 » --}}
                  <span class="small text-muted text-nowrap">{{ $evenement['date']->format('H:i:s') === '00:00:00' ? $evenement['date']->format('d/m/Y') : $evenement['date']->format('d/m/Y à H:i') }}</span>
                </div>
                @if ($evenement['detail'])<div class="small text-muted text-break">{{ $evenement['detail'] }}</div>@endif
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    {{-- Connexions --}}
    <div class="tab-pane fade" id="onglet-connexions" role="tabpanel">
      <div class="row g-2 mb-3 resume-connexions">
        <div class="col-sm-4"><div class="fait-libelle">Dernière connexion</div><div class="fw-semibold">{{ optional($resumeConnexions['derniere_connexion'])->format('d/m/Y à H:i') ?? '—' }}</div></div>
        <div class="col-sm-4"><div class="fait-libelle">Dernière activité</div><div class="fw-semibold">{{ optional($resumeConnexions['derniere_activite'])->format('d/m/Y à H:i') ?? '—' }}</div></div>
        <div class="col-sm-4"><div class="fait-libelle">Échecs (30 jours)</div><div class="fw-semibold {{ $resumeConnexions['echecs_30_jours'] ? 'text-danger' : '' }}">{{ $resumeConnexions['echecs_30_jours'] }}</div></div>
      </div>
      @if ($connexions->isEmpty())
        <p class="text-muted mb-0">Aucune connexion enregistrée pour ce compte.</p>
      @else
        <div class="table-responsive">
          <table class="table table-sm align-middle mb-0">
            <thead><tr><th>Date</th><th>Événement</th><th>Adresse IP</th><th>Navigateur</th></tr></thead>
            <tbody>
              @foreach ($connexions as $connexion)
                <tr class="{{ $connexion->action === 'connexion_echouee' ? 'table-danger' : '' }}">
                  <td class="text-nowrap">{{ optional($connexion->created_at)->format('d/m/Y H:i') }}</td>
                  <td><i class="fas {{ $connexion->icone() }} me-1" aria-hidden="true"></i>{{ $connexion->libelle() }}
                    @if ($connexion->detail)<div class="small text-muted">{{ $connexion->detail }}</div>@endif</td>
                  <td class="text-nowrap small">{{ $connexion->ip ?? '—' }}</td>
                  <td class="small">{{ \App\Models\ActivitePromoteur::navigateurLisible($connexion->navigateur) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
      <p class="small text-muted mt-2 mb-0"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
        Connexions enregistrées depuis {{ $resumeConnexions['suivi_depuis'] ? 'le '.$resumeConnexions['suivi_depuis']->format('d/m/Y') : 'la mise en service de ce suivi' }} (30 dernières affichées).</p>
    </div>

    {{-- E-mails envoyés au promoteur --}}
    <div class="tab-pane fade" id="onglet-emails" role="tabpanel">
      @if ($emailsEnvoyes->isEmpty())
        <p class="text-muted mb-0">Aucun e-mail enregistré pour ce promoteur.</p>
      @else
        <div class="table-responsive">
          <table class="table table-sm align-middle mb-0">
            <thead><tr><th>Date</th><th>E-mail</th><th>Destinataire</th><th>Envoyé par</th><th>Statut</th></tr></thead>
            <tbody>
              @foreach ($emailsEnvoyes as $envoi)
                <tr class="{{ $envoi->estEnvoye() ? '' : 'table-danger' }}">
                  <td class="text-nowrap">{{ optional($envoi->created_at)->format('d/m/Y H:i') }}</td>
                  <td><i class="fas {{ $envoi->icone() }} me-1" aria-hidden="true"></i>{{ $envoi->libelle() }}
                    @if ($envoi->objet)<div class="small text-muted text-break">« {{ $envoi->objet }} »</div>@endif</td>
                  <td class="small text-break">{{ $envoi->destinataire ?? '—' }}</td>
                  <td class="small">
                    @if (!$envoi->declencheur)
                      <span class="text-muted">Le site (sans connexion)</span>
                    @elseif ($envoi->declencheur->isadmin)
                      {{ trim($envoi->declencheur->prenom.' '.$envoi->declencheur->name) }}
                    @else
                      Le promoteur
                    @endif
                  </td>
                  <td>
                    @if ($envoi->estEnvoye())
                      <span class="badge text-bg-success"><i class="fas fa-check me-1" aria-hidden="true"></i>Envoyé</span>
                    @else
                      <span class="badge text-bg-danger"><i class="fas fa-times me-1" aria-hidden="true"></i>Échec</span>
                      @if ($envoi->erreur)<div class="small text-danger text-break mt-1">{{ $envoi->erreur }}</div>@endif
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
      <p class="small text-muted mt-2 mb-0"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
        E-mails enregistrés depuis {{ $resumeConnexions['emails_depuis'] ? 'le '.$resumeConnexions['emails_depuis']->format('d/m/Y') : 'la mise en service de ce suivi' }} :
        décision du CEFORE, code de vérification à l’inscription et réinitialisation du mot de passe (50 derniers affichés).
        « Envoyé » signifie que le serveur de messagerie a accepté l’e-mail.</p>
    </div>
  </div>
</div>
