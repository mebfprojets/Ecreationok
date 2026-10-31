{{-- Frise de suivi d'une demande. Paramètre : $demande --}}
@php
    $suivi = $demande->suivi();
    $etapes = [1 => 'Dépôt', 2 => 'Paiement', 3 => 'Examen CEFORE', 4 => 'Traitement', 5 => 'Retrait'];
@endphp
<ol class="ed-frise" aria-label="Suivi de la demande">
    @foreach ($etapes as $numero => $libelle)
        @php
            if ($numero < $suivi['etape']) {
                $classe = 'fait';
            } elseif ($numero == $suivi['etape']) {
                $classe = $suivi['erreur'] ? 'erreur' : ($numero == count($etapes) ? 'fait' : 'encours');
            } else {
                $classe = '';
            }
        @endphp
        <li class="{{ $classe }}" @if($numero == $suivi['etape']) aria-current="step" @endif>
            <span class="rond">
                @if ($classe === 'fait') <i class="fas fa-check" aria-hidden="true"></i>
                @elseif ($classe === 'erreur') <i class="fas fa-times" aria-hidden="true"></i>
                @else {{ $numero }} @endif
            </span>
            {{ $libelle }}
        </li>
    @endforeach
</ol>
