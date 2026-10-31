@extends('layouts.frontend')
@section('content')
@include('demande.partials.styles')

@php
    $aCorriger = $demandes->filter(function ($d) { return $d->estRejetee(); })->count();
    $aPayer = $demandes->where('paye', 0)->count();
    $retirables = $demandes->filter(fn ($d) => $d->suivi()['etape'] == 5)->count();
    $nomsCefore = $nomsCefore ?? collect();
    $typeEntreprise = fn ($d) => $d->request_type === 'G1' ? 'Groupement d’intérêt économique'
        : ($d->company_type == 'EI' ? 'Entreprise individuelle' : 'Entreprise sociétaire');
@endphp

<div class="ed-page">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
        <div>
            <h1 class="ed-titre h3">Mes demandes</h1>
            <p class="ed-sous-titre">
                @if ($c === 0)
                    Vous n’avez encore déposé aucune demande.
                @else
                    Suivez l’avancement de vos demandes de création d’entreprise.
                @endif
            </p>
        </div>
        <a href="{{ route('create.usager') }}" class="btn btn-success">
            <i class="fas fa-plus me-1" aria-hidden="true"></i> Nouvelle demande
        </a>
    </div>

    @if ($c > 0)
        <div class="ed-compteurs" aria-label="Résumé de mes demandes">
            <span class="ed-compteur"><i class="fas fa-folder-open" aria-hidden="true"></i><strong>{{ $c }}</strong> demande{{ $c > 1 ? 's' : '' }}</span>
            @if ($aCorriger)
                <span class="ed-compteur alerte"><i class="fas fa-undo-alt" aria-hidden="true"></i><strong>{{ $aCorriger }}</strong> à corriger</span>
            @endif
            @if ($aPayer)
                <span class="ed-compteur attente"><i class="fas fa-wallet" aria-hidden="true"></i><strong>{{ $aPayer }}</strong> à payer</span>
            @endif
            @if ($retirables)
                <span class="ed-compteur"><i class="fas fa-box-open" aria-hidden="true"></i><strong>{{ $retirables }}</strong> prête{{ $retirables > 1 ? 's' : '' }} au retrait</span>
            @endif
        </div>
    @endif

    @if ($aCorriger > 0)
        <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
            <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
            <div>
                <strong>{{ $aCorriger }} demande{{ $aCorriger > 1 ? 's ont été rejetées' : ' a été rejetée' }} par le CEFORE.</strong>
                Corrigez-la{{ $aCorriger > 1 ? 's' : '' }} puis renvoyez-la{{ $aCorriger > 1 ? 's' : '' }} pour traitement.
            </div>
        </div>
    @endif
    @if ($aPayer > 0)
        <div class="alert alert-warning d-flex align-items-center gap-2" role="status">
            <i class="fas fa-wallet" aria-hidden="true"></i>
            <div>{{ $aPayer }} demande{{ $aPayer > 1 ? 's sont' : ' est' }} en attente de paiement : elle{{ $aPayer > 1 ? 's' : '' }} ne sera{{ $aPayer > 1 ? 'nt' : '' }} transmise{{ $aPayer > 1 ? 's' : '' }} au CEFORE qu’après règlement.</div>
        </div>
    @endif

    @forelse ($demandes as $demande)
        @php $suivi = $demande->suivi(); @endphp
        @php $nouveautes = \App\Models\JournalAction::nonLuesDuPromoteur(Auth::user())->where('demande_id', $demande->id); @endphp
        <article class="ed-carte ed-etat-{{ $suivi['couleur'] }} mb-3 {{ $nouveautes->isNotEmpty() ? 'ed-carte-nouveaute' : '' }}">
            <div class="ed-carte-entete">
                <div>
                    <h2>{{ $demande->commercial_name ?: 'Demande sans nom commercial' }}
                        @if ($nouveautes->isNotEmpty())
                            <span class="badge rounded-pill bg-danger align-middle ms-1" title="{{ $nouveautes->first()->messagePromoteur() }}">
                                <i class="fas fa-bell me-1" aria-hidden="true"></i>Nouveau
                            </span>
                        @endif
                    </h2>
                    @if ($nouveautes->isNotEmpty())
                        <div class="small text-danger fw-semibold mb-1"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>{{ $nouveautes->first()->messagePromoteur() }} — ouvrez le dossier pour en savoir plus.</div>
                    @endif
                    <div class="ed-meta mt-1">
                        <span><i class="fas fa-hashtag" aria-hidden="true"></i> {{ $demande->numero_demande }}</span>
                        <span><i class="fas fa-building" aria-hidden="true"></i> {{ $typeEntreprise($demande) }}</span>
                    </div>
                </div>
                <span class="ed-badge {{ $suivi['couleur'] }}">
                    <i class="fas {{ $suivi['icone'] }}" aria-hidden="true"></i> {{ $suivi['libelle'] }}
                </span>
            </div>

            <div class="ed-carte-corps">
                @include('demande.partials.frise', ['demande' => $demande])

                <div class="ed-meta mt-3">
                    <span><i class="far fa-calendar-alt" aria-hidden="true"></i>
                        Déposée le {{ optional($demande->created_at)->format('d/m/Y') }}</span>
                    <span><i class="fas fa-map-marker-alt" aria-hidden="true"></i> {{ $nomsCefore[$demande->organisation_code] ?? $demande->organisation_code }}</span>
                    @if ($demande->montant_total)
                        <span><i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                            {{ number_format((float) $demande->montant_total, 0, ',', ' ') }} FCFA</span>
                    @endif
                </div>

                <p class="mt-3 mb-0">{{ $suivi['consigne'] }}</p>

                @if ($demande->estRejetee() && $demande->motif)
                    <div class="alert alert-danger py-2 mt-3 mb-0">
                        <strong>Motif du rejet :</strong> {{ \Illuminate\Support\Str::limit($demande->motif, 180) }}
                    </div>
                @endif
            </div>

            <div class="ed-carte-pied">
                @if ($demande->estRejetee())
                    <a href="{{ route('demande.detail', $demande->id) }}#correction" class="btn btn-danger btn-sm">
                        <i class="fas fa-pen me-1" aria-hidden="true"></i> Corriger ma demande
                    </a>
                @endif

                @if ($demande->paye == 0)
                    <form action="{{ route('orange.index') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ $demande->id }}">
                        <input type="hidden" name="numero_command" value="{{ $demande->numero_command }}">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="fas fa-wallet me-1" aria-hidden="true"></i> Payer
                        </button>
                    </form>
                @elseif ($demande->paye == 1)
                    <a href="{{ route('demande.facture', $demande->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-invoice me-1" aria-hidden="true"></i> Facture
                    </a>
                @endif

                <a href="{{ route('demande.detail', $demande->id) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-eye me-1" aria-hidden="true"></i> Voir le détail
                </a>
            </div>
        </article>
    @empty
        <div class="ed-carte text-center p-5">
            <i class="fas fa-folder-open fa-3x text-success mb-3" aria-hidden="true"></i>
            <h2 class="h5">Aucune demande pour le moment</h2>
            <p class="text-muted mb-3">Créez votre première demande de création d’entreprise : elle apparaîtra ici avec son suivi.</p>
            <a href="{{ route('create.usager') }}" class="btn btn-success">
                <i class="fas fa-plus me-1" aria-hidden="true"></i> Créer une demande
            </a>
        </div>
    @endforelse
</div>
@endsection
