{{--
  Fenêtres de la page d'accueil : « Avant de commencer » et pièces à fournir (personne physique, personne morale).
  Documents à télécharger : [libellé, adresse, format] ; pièces à joindre : [libellé, précision].
--}}
@php
    $wp = 'https://www.me.bf/wp-content/uploads/';
    $justificatifLocal = 'Contrat de bail à usage commercial enregistré, titre foncier, permis urbain d’habiter, attestation d’attribution de parcelle ou facture d’eau ou d’électricité récente.';
    $modales = [
        'modal-piece_pp' => [
            'titre' => 'Pièces à fournir — Personne physique',
            'sous_titre' => 'Entreprise individuelle',
            'icone' => 'fa-user-tie',
            'documents' => [
                ['Formulaire de renseignement', 'https://www.me.bf/wp-content/uploads/2024/01/Formalite-personne-physique.pdf', 'PDF'],
                ['Fiche de déclaration sur l’honneur', $wp.'2025/10/DECLARATION-SUR-LHONNEUR-vf-21-10-2025.docx', 'DOCX'],
                ['Formulaire de demande de carte professionnelle de commerçant (CPC)', $wp.'2023/05/Fiche-Carte-Professionnelle-de-Commercant_CPC-SCANNE.pdf', 'PDF'],
                ['Fiche de visite', $wp.'2024/11/FICHE-DE-VISITE.pdf', 'PDF'],
            ],
            'pieces' => [
                ['Photocopie légalisée de la pièce d’identité ou du passeport du promoteur', null],
                ['Extrait de casier judiciaire (bulletin n° 3) de moins de 3 mois', 'Si vous ne pouvez pas l’établir à Ouagadougou, vous disposez de 75 jours pour l’apporter au CEFORE.'],
                ['Copie de l’acte de mariage', 'S’il y a lieu.'],
                ['Certificat de résidence de l’année en cours', 'Taxe de résidence payée au domaine, certificat établi à la mairie ou au commissariat de police.'],
                ['Justificatif du local, au nom du créateur', $justificatifLocal],
                ['Deux photos d’identité du promoteur', null],
            ],
        ],
        'modal-piece_pm' => [
            'titre' => 'Pièces à fournir — Personne morale',
            'sous_titre' => 'Entreprise sociétaire',
            'icone' => 'fa-building',
            'documents' => [
                ['Formulaire de renseignement', 'https://www.me.bf/wp-content/uploads/2024/01/Formalite-personne-morale.pdf', 'PDF'],
                ['Déclaration sur l’honneur', $wp.'2025/10/DECLARATION-SUR-LHONNEUR-vf-21-10-2025.docx', 'DOCX'],
                ['Formulaire de demande de carte professionnelle de commerçant (CPC)', $wp.'2023/05/Fiche-Carte-Professionnelle-de-Commercant_CPC-SCANNE.pdf', 'PDF'],
                ['Formulaire RCCM', $wp.'2025/09/model-M1-VF.doc', 'DOC'],
                ['Modèle d’acte de dépôt', $wp.'2026/03/Acte-de-depot.doc', 'DOC'],
                ['Fiche de visite', $wp.'2024/11/FICHE-DE-VISITE.pdf', 'PDF'],
                ['Modèle de statuts — SARL unipersonnelle', $wp.'2023/09/Modele-de-statuts-dune-SARL-unipersonnelle.docx', 'DOCX'],
                ['Modèle de statuts — SARL pluripersonnelle', $wp.'2023/09/Modele-de-statuts-dune-SARL-pluripersonnelle.docx', 'DOCX'],
                ['Modèle de procès-verbal constitutif', $wp.'2023/09/Modele-de-proces-verbal-constitutif.docx', 'DOCX'],
                ['Modèle de déclaration de souscription et de versement des fonds', $wp.'2023/09/Modele-de-declaration-de-souscription-et-de-versement-des-fonds.docx', 'DOCX'],
                ['Modèle de déclaration de régularité et de conformité', $wp.'2023/09/Modele-de-declaration-de-regularite-et-de-conformite.docx', 'DOCX'],
                ['Modèle de contrat d’apport de biens en nature', $wp.'2023/09/Telecharger-ici-le-modele-de-contrat-dapport-de-bien-en-nature.docx', 'DOCX'],
            ],
            'pieces' => [
                ['Photocopie de la pièce d’identité ou du passeport du ou des dirigeants', null],
                ['Extrait de casier judiciaire (bulletin n° 3) de moins de 3 mois du ou des dirigeants', null],
                ['Attestation de dépôt du capital en banque au nom de la société', 'En cas d’apport en numéraire.'],
                ['Rapport d’évaluation des biens apportés', 'Si leur valeur dépasse 5 millions de F CFA.'],
                ['Justificatif du local, au nom de la société', $justificatifLocal],
            ],
        ],
    ];
    $icones = ['PDF' => 'fa-file-pdf', 'DOC' => 'fa-file-word', 'DOCX' => 'fa-file-word'];
@endphp

@foreach ($modales as $id => $m)
  <div id="{{ $id }}" class="modal fade modale-pieces" tabindex="-1" aria-labelledby="{{ $id }}-titre" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <span class="modale-pieces-icone" aria-hidden="true"><i class="fas {{ $m['icone'] }}"></i></span>
          <div class="flex-grow-1">
            <h3 class="modal-title" id="{{ $id }}-titre">{{ $m['titre'] }}</h3>
            <div class="modale-pieces-sous-titre">{{ $m['sous_titre'] }}</div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <h4 class="modale-pieces-rubrique"><span>1</span>Documents à télécharger et remplir</h4>
          <ul class="liste-documents">
            @foreach ($m['documents'] as [$libelle, $adresse, $format])
              <li>
                <a href="{{ $adresse }}" target="_blank" rel="noopener">
                  <i class="fas {{ $icones[$format] }} liste-documents-icone format-{{ strtolower($format) }}" aria-hidden="true"></i>
                  <span class="flex-grow-1">{{ $libelle }}</span>
                  <span class="liste-documents-format">{{ $format }}</span>
                  <i class="fas fa-download liste-documents-telecharger" aria-hidden="true"></i>
                </a>
              </li>
            @endforeach
          </ul>

          <h4 class="modale-pieces-rubrique"><span>2</span>Pièces à joindre</h4>
          <ul class="liste-pieces">
            @foreach ($m['pieces'] as [$libelle, $precision])
              <li>
                <i class="fas fa-check-circle" aria-hidden="true"></i>
                <div>
                  <span class="fw-semibold">{{ $libelle }}</span>
                  @if ($precision)<div class="liste-pieces-precision">{{ $precision }}</div>@endif
                </div>
              </li>
            @endforeach
          </ul>
          <p class="modale-pieces-note"><i class="fas fa-info-circle me-1" aria-hidden="true"></i>
            Les pièces sont déposées en ligne (PDF) lors de votre demande : préparez-les à l’avance pour gagner du temps.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
          @auth
            <a href="{{ route('create.usager') }}" class="btn btn-success"><i class="fas fa-arrow-right me-1" aria-hidden="true"></i>Créer ma demande</a>
          @else
            <a href="#modal-create-compte" class="btn btn-success" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-user-plus me-1" aria-hidden="true"></i>Créer mon compte</a>
          @endauth
        </div>
      </div>
    </div>
  </div>
@endforeach

{{-- Avant de commencer --}}
<div id="modal-infos" class="modal fade modale-pieces" tabindex="-1" aria-labelledby="modal-infos-titre" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modale-pieces-icone" aria-hidden="true"><i class="fas fa-lightbulb"></i></span>
        <div class="flex-grow-1">
          <h3 class="modal-title" id="modal-infos-titre">Avant de commencer</h3>
          <div class="modale-pieces-sous-titre">Trois étapes pour préparer votre demande</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <ol class="etapes-avant">
          <li>
            <h4>Vérifiez la disponibilité du nom commercial</h4>
            <p>Le nom commercial ou la dénomination sociale envisagé, ainsi que le sigle, ne doivent pas déjà être utilisés.</p>
            <a href="#modal-verifier-nomCommercial" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-dismiss="modal">
              <i class="fas fa-search me-1" aria-hidden="true"></i>Vérifier un nom commercial</a>
          </li>
          <li>
            <h4>Réservez votre nom (facultatif)</h4>
            <p>Vous pouvez réserver le nom commercial ou la dénomination sociale contre une <strong>attestation de disponibilité et de réservation</strong>, jointe aux statuts. Elle s’obtient auprès :</p>
            <ul>
              <li>de l’administrateur du FN-RCCM, à la MEBF, si vous résidez à Ouagadougou ;</li>
              <li>du conseiller CEFORE, dans les autres localités disposant d’un bureau CEFORE ;</li>
              <li>du chef de greffe du tribunal compétent, dans les localités sans bureau CEFORE.</li>
            </ul>
          </li>
          <li>
            <h4>Préparez les pièces à fournir</h4>
            <p>La liste dépend du type d’entreprise :</p>
            <div class="d-flex flex-wrap gap-2">
              <a href="#modal-piece_pp" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-dismiss="modal">Personne physique</a>
              <a href="#modal-piece_pm" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-dismiss="modal">Personne morale</a>
            </div>
          </li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
