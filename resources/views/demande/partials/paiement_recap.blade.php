{{-- Récapitulatif de la demande à payer. Paramètre : $demande --}}
@php
    $total = (float) $demande->montant_total;
    $base = (float) $demande->montant;
    $frais = ($base > 0 && $total > $base) ? $total - $base : 0;
    $fcfa = function ($n) { return number_format((float) $n, 0, ',', ' ').' FCFA'; };
@endphp
<section class="ed-carte">
    <div class="ed-carte-corps d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="ed-meta mb-1">
                <span><i class="fas fa-hashtag" aria-hidden="true"></i> {{ $demande->numero_demande }}</span>
                <span><i class="fas fa-building" aria-hidden="true"></i>
                    {{ $demande->company_type == 'EI' ? 'Entreprise individuelle' : 'Entreprise sociétaire' }}</span>
            </div>
            <div class="fw-bold fs-5">{{ $demande->commercial_name }}</div>
        </div>
        <div class="ed-montant text-end">
            <div class="libelle">Montant à payer</div>
            <div class="valeur">{{ $fcfa($total) }}</div>
        </div>
    </div>
</section>
