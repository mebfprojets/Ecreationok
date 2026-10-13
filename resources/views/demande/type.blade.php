@extends('layouts.frontend')

@section('content')
<style>
    .card-type-entreprise-link {
        text-decoration: none;
        color: inherit;
    }

    .card-type-entreprise-link .card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        height: 100%;
    }

    .card-type-entreprise-link .card:hover {
        border-color: #0d6efd;
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .card-type-entreprise-link .card:hover .fa-3x {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }

    .badge {
        font-size: 0.75rem;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Choix du Type d'Entreprise</h4>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                <strong>Promoteur lié au Compte :</strong> 
                                {{$usager->NomRaisonSociale}} {{$usager->Prenom}} - 
                                <strong>N°Pièce:  </strong> {{$usager->CIN}} - 
                                <strong>Email:  </strong> {{Auth::user()->email}}
                            </div>
                    </div>
                    <h5 class="card-title mb-0">Sélectionnez votre type d'entreprise</h5>
                    <!-- <p class="text-muted mb-0">Cliquez directement sur le type d'entreprise pour continuer.</p> -->

                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <!-- Entreprise Individuelle --> 
                         @if($typeDemande != 'EI')                        
                        <div class="col-lg-6 mb-4">
                            <a href="{{ route('process.type.entreprise', 'ei') }}" class="card-type-entreprise-link">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-user-tie fa-3x text-primary"></i>
                                        </div>
                                        <h5 class="card-title">Entreprise Individuelle (EI)</h5>
                                        <p class="card-text text-muted small">
                                            Entreprise exploitée par une personne physique sans création de personne morale
                                        </p>
                                        <div class="mt-3">
                                            <span class="badge bg-primary">Cliquer pour continuer</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif

                        <!-- Entreprise Sociétaire -->                        
                        <div class="col-lg-6 mb-4">
                            <a href="{{ route('process.type.entreprise', 'es') }}" class="card-type-entreprise-link">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-building fa-3x text-success"></i>
                                        </div>
                                        <h5 class="card-title">Entreprise Sociétaire</h5>
                                        <p class="card-text text-muted small">
                                            SARL, SA, SAS, SASU, EURL et autres formes sociétaires
                                        </p>
                                        <div class="mt-3">
                                            <span class="badge bg-success">Cliquer pour continuer</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Groupement d'Intérêt Général -->
                        <div class="col-lg-6 mb-4">
                            <a href="{{ route('process.type.entreprise', 'gie') }}" class="card-type-entreprise-link">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-hands-helping fa-3x text-info"></i>
                                        </div>
                                        <h5 class="card-title">Groupement d'Intérêt Economique (GIE)</h5>
                                        <p class="card-text text-muted small">
                                            Regroupement d'entreprises ou d'organismes pour un projet commun d'intérêt général
                                        </p>
                                        <div class="mt-3">
                                            <span class="badge bg-info">Cliquer pour continuer</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <small class="text-muted">Cliquez directement sur un type d'entreprise ci-dessus</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation au survol des cartes
    const cards = document.querySelectorAll('.card-type-entreprise-link .card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>

