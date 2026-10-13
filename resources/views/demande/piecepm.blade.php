@extends('layouts.frontend')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dépôt des Pièces Jointes @if($type=="es") ENTREPRISE SOCIETAIRE @else GROUPEMENT D'INTERET ECONOMIQUE @endif</h4>
            </div>
        </div>
    </div>
    <!-- Chargement en cours -->
    <div id="loadingMessage" style="display:none; text-align:center; margin-top:20px;">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
        <div>Chargement en cours...</div>
    </div>

    <form action="{{route('piece.store')}}" method="POST" enctype="multipart/form-data" id="piecesJointesForm">
        @csrf
        
        <div class="row">
            <input type="hidden" name="type_entreprise" value="{{$type}}">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                <strong>Promoteur lié au Compte :</strong> 
                                {{$usager->NomRaisonSociale}} {{$usager->Prenom}} - 
                                <strong>N°Pièce :  </strong> {{$usager->CIN}} - 
                                <strong>Email :  </strong> {{Auth::user()->email}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Messages de session -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Messages d'erreur de validation -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Déclaration -->
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        Déclaration sur l'honneur + Casier Judiciaire + Attestation de Reservation
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-upload-wrapper" data-category="declaration" data-max-size="3">
                                        <div class="input-group">
                                            <input type="file" 
                                                   name="declaration" 
                                                   class="form-control file-input-hidden" 
                                                   accept=".pdf" 
                                                   style="display: none"
                                                   {{ isset($documentsParCategorie['declaration']) ? '' : 'required' }}>
                                            <input type="text" 
                                                   class="form-control file-name-display" 
                                                   placeholder="Aucun fichier sélectionné" 
                                                   readonly
                                                   value="{{ $documentsParCategorie['declaration']->url_local ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-browse">
                                                    <i class="fas fa-upload me-1"></i> 
                                                    {{ isset($documentsParCategorie['declaration']) ? 'Remplacer' : 'Importer' }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="file-actions mt-2" style="{{ isset($documentsParCategorie['declaration']) ? 'display: block;' : 'display: none;' }}">
                                            <button type="button" class="btn btn-info btn-sm btn-preview me-1">
                                                <i class="fas fa-eye me-1"></i> Visualiser
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm btn-change">
                                                <i class="fas fa-sync me-1"></i> Changer
                                            </button>
                                        </div>
                                        @if(isset($documentsParCategorie['declaration']))
                                            <div class="mt-1">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> 
                                                    Fichier déjà importé: {{ basename($documentsParCategorie['declaration']->url_local) }}
                                                </small>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Format PDF uniquement - Max: 3MB</small>
                                        <div class="invalid-feedback file-error"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Répétez la même structure pour les autres catégories -->
                            <!-- Acte de Depot -->
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        Acte de Depots
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-upload-wrapper" data-category="acte_de_depot" data-max-size="2">
                                        <div class="input-group">
                                            <input type="file" 
                                                   name="acte_de_depot" 
                                                   class="form-control file-input-hidden" 
                                                   accept=".pdf" 
                                                   style="display: none"
                                                   {{ isset($documentsParCategorie['acte_de_depot']) ? '' : 'required' }}>
                                            <input type="text" 
                                                   class="form-control file-name-display" 
                                                   placeholder="Aucun fichier sélectionné" 
                                                   readonly
                                                   value="{{ $documentsParCategorie['acte_de_depot']->url_local ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-browse">
                                                    <i class="fas fa-upload me-1"></i> 
                                                    {{ isset($documentsParCategorie['acte_de_depot']) ? 'Remplacer' : 'Importer' }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="file-actions mt-2" style="{{ isset($documentsParCategorie['acte_de_depot']) ? 'display: block;' : 'display: none;' }}">
                                            <button type="button" class="btn btn-info btn-sm btn-preview me-1">
                                                <i class="fas fa-eye me-1"></i> Visualiser
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm btn-change">
                                                <i class="fas fa-sync me-1"></i> Changer
                                            </button>
                                        </div>
                                        @if(isset($documentsParCategorie['acte_de_depot']))
                                            <div class="mt-1">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> 
                                                    Fichier déjà importé: {{ basename($documentsParCategorie['acte_de_depot']->url_local) }}
                                                </small>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Format PDF uniquement - Max: 2MB</small>
                                        <div class="invalid-feedback file-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        Statut + PV + Autres Documents
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-upload-wrapper" data-category="statut" data-max-size="10">
                                        <div class="input-group">
                                            <input type="file" 
                                                   name="statut" 
                                                   class="form-control file-input-hidden" 
                                                   accept=".pdf" 
                                                   style="display: none"
                                                   {{ isset($documentsParCategorie['statut']) ? '' : 'required' }}>
                                            <input type="text" 
                                                   class="form-control file-name-display" 
                                                   placeholder="Aucun fichier sélectionné" 
                                                   readonly
                                                   value="{{ $documentsParCategorie['statut']->url_local ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-browse">
                                                    <i class="fas fa-upload me-1"></i> 
                                                    {{ isset($documentsParCategorie['statut']) ? 'Remplacer' : 'Importer' }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="file-actions mt-2" style="{{ isset($documentsParCategorie['statut']) ? 'display: block;' : 'display: none;' }}">
                                            <button type="button" class="btn btn-info btn-sm btn-preview me-1">
                                                <i class="fas fa-eye me-1"></i> Visualiser
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm btn-change">
                                                <i class="fas fa-sync me-1"></i> Changer
                                            </button>
                                        </div>
                                        @if(isset($documentsParCategorie['statut']))
                                            <div class="mt-1">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> 
                                                    Fichier déjà importé: {{ basename($documentsParCategorie['statut']->url_local) }}
                                                </small>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Format PDF uniquement - Max: 10MB</small>
                                        <div class="invalid-feedback file-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        Formulaire RCCM
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-upload-wrapper" data-category="formulaire_rccm" data-max-size="1">
                                        <div class="input-group">
                                            <input type="file" 
                                                   name="formulaire_rccm" 
                                                   class="form-control file-input-hidden" 
                                                   accept=".pdf" 
                                                   style="display: none"
                                                   {{ isset($documentsParCategorie['formulaire_rccm']) ? '' : 'required' }}>
                                            <input type="text" 
                                                   class="form-control file-name-display" 
                                                   placeholder="Aucun fichier sélectionné" 
                                                   readonly
                                                   value="{{ $documentsParCategorie['formulaire_rccm']->url_local ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-browse">
                                                    <i class="fas fa-upload me-1"></i> 
                                                    {{ isset($documentsParCategorie['formulaire_rccm']) ? 'Remplacer' : 'Importer' }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="file-actions mt-2" style="{{ isset($documentsParCategorie['formulaire_rccm']) ? 'display: block;' : 'display: none;' }}">
                                            <button type="button" class="btn btn-info btn-sm btn-preview me-1">
                                                <i class="fas fa-eye me-1"></i> Visualiser
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm btn-change">
                                                <i class="fas fa-sync me-1"></i> Changer
                                            </button>
                                        </div>
                                        @if(isset($documentsParCategorie['formulaire_rccm']))
                                            <div class="mt-1">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> 
                                                    Fichier déjà importé: {{ basename($documentsParCategorie['formulaire_rccm']->url_local) }}
                                                </small>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Format PDF uniquement - Max: 1MB</small>
                                        <div class="invalid-feedback file-error"></div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        Pièce d'Identité
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-upload-wrapper" data-category="piece_didentite" data-max-size="1">
                                        <div class="input-group">
                                            <input type="file" 
                                                name="piece_didentite" 
                                                class="form-control file-input-hidden" 
                                                accept=".pdf" 
                                                style="display: none"
                                                {{ isset($documentsParCategorie['piece_didentite']) ? '' : 'required' }}>
                                            <input type="text" 
                                                class="form-control file-name-display" 
                                                placeholder="Aucun fichier sélectionné" 
                                                readonly
                                                value="{{ $documentsParCategorie['piece_didentite']->url_local ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-browse">
                                                    <i class="fas fa-upload me-1"></i> 
                                                    {{ isset($documentsParCategorie['piece_didentite']) ? 'Remplacer' : 'Importer' }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="file-actions mt-2" style="{{ isset($documentsParCategorie['piece_didentite']) ? 'display: block;' : 'display: none;' }}">
                                            <button type="button" class="btn btn-info btn-sm btn-preview me-1">
                                                <i class="fas fa-eye me-1"></i> Visualiser
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm btn-change">
                                                <i class="fas fa-sync me-1"></i> Changer
                                            </button>
                                        </div>
                                        @if(isset($documentsParCategorie['piece_didentite']))
                                            <div class="mt-1">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> 
                                                    Fichier déjà importé: {{ basename($documentsParCategorie['piece_didentite']->url_local) }}
                                                </small>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Format PDF uniquement - Max: 1MB</small>
                                        <div class="invalid-feedback file-error"></div>
                                    </div>
                                    
                                    <!-- Section des informations de la pièce d'identité -->
                                    <div class="row mt-3" id="piece-identite-infos">
                                        @if(isset($documentsParCategorie['piece_didentite']))
                                            <!-- Mode affichage : pièce déjà existante -->
                                            <div class="col-md-6">
                                                <label class="form-label">Numéro de Référence</label>
                                                <div class="form-control bg-light">
                                                    {{ $documentsParCategorie['piece_didentite']->numero ?? 'Non renseigné' }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Date d'établissement</label>
                                                <div class="form-control bg-light">
                                                    {{ isset($documentsParCategorie['piece_didentite']->date_etablissement) ? \Carbon\Carbon::parse($documentsParCategorie['piece_didentite']->date_etablissement)->format('d/m/Y') : 'Non renseignée' }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Date d'expiration</label>
                                                <div class="form-control bg-light">
                                                    @if(isset($documentsParCategorie['piece_didentite']->date_etablissement))
                                                        {{ \Carbon\Carbon::parse($documentsParCategorie['piece_didentite']->date_etablissement)->addYears(10)->subDay()->format('d/m/Y') }}
                                                    @else
                                                        Non calculable
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <!-- Mode édition : pièce non encore chargée -->
                                            <div class="col-md-6">
                                                <label for="reference_cnib" class="form-label">Numéro de Référence</label>
                                                <input type="text" id="reference_cnib" name="reference" class="form-control" placeholder="" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date_etablissement" class="form-label">Date d'établissement</label>
                                                <input type="date" id="date_etablissement" name="date_etablissement" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="date_expiration" class="form-label">Date d'expiration</label>
                                                <input type="date" id="date_expiration" name="date_expiration" class="form-control" readonly>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">
                                        Titre de Propriété / Jouissance + Fiche de Visite des Impôts
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-upload-wrapper" data-category="titre_de_propriete" data-max-size="4">
                                        <div class="input-group">
                                            <input type="file" 
                                                   name="titre_de_propriete" 
                                                   class="form-control file-input-hidden" 
                                                   accept=".pdf" 
                                                   style="display: none"
                                                   {{ isset($documentsParCategorie['titre_de_propriete']) ? '' : 'required' }}>
                                            <input type="text" 
                                                   class="form-control file-name-display" 
                                                   placeholder="Aucun fichier sélectionné" 
                                                   readonly
                                                   value="{{ $documentsParCategorie['titre_de_propriete']->url_local ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success btn-browse">
                                                    <i class="fas fa-upload me-1"></i> 
                                                    {{ isset($documentsParCategorie['titre_de_propriete']) ? 'Remplacer' : 'Importer' }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="file-actions mt-2" style="{{ isset($documentsParCategorie['titre_de_propriete']) ? 'display: block;' : 'display: none;' }}">
                                            <button type="button" class="btn btn-info btn-sm btn-preview me-1">
                                                <i class="fas fa-eye me-1"></i> Visualiser
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm btn-change">
                                                <i class="fas fa-sync me-1"></i> Changer
                                            </button>
                                        </div>
                                        @if(isset($documentsParCategorie['titre_de_propriete']))
                                            <div class="mt-1">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> 
                                                    Fichier déjà importé: {{ basename($documentsParCategorie['titre_de_propriete']->url_local) }}
                                                </small>
                                            </div>
                                        @endif
                                        <small class="form-text text-muted">Format PDF uniquement - Max: 4MB</small>
                                        <div class="invalid-feedback file-error"></div>
                                    </div>
                                    
                                </div>
                            </div>

                            <!-- Continuez pour les autres catégories (statut, formulaire_rccm, piece_didentite, titre_de_propriete, formulaire_cpc_es) -->
                            <!-- ... -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>Valider et continuer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

<script>
    class FileUploadManager {
        constructor() {
            this.initEvents();
        }

        initEvents() {
            // Bouton Importer/Remplacer
            document.querySelectorAll('.btn-browse').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    this.openFilePicker(e.target);
                });
            });

            // Changement de fichier
            document.querySelectorAll('.file-input-hidden').forEach(input => {
                input.addEventListener('change', (e) => {
                    this.handleFileSelect(e.target);
                });
            });

            // Visualisation
            document.querySelectorAll('.btn-preview').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    this.previewFile(e.target);
                });
            });

            // Changer le fichier
            document.querySelectorAll('.btn-change').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    this.changeFile(e.target);
                });
            });

            // Validation du formulaire
            document.getElementById('piecesJointesForm').addEventListener('submit', (e) => {
                if (!this.validateAllFiles()) {
                    e.preventDefault();
                }
                else {
                    document.getElementById('loadingMessage').style.display = 'block';
                }
            });
        }

        openFilePicker(button) {
            const wrapper = button.closest('.file-upload-wrapper');
            const fileInput = wrapper.querySelector('.file-input-hidden');
            fileInput.click();
        }

        handleFileSelect(input) {
            const file = input.files[0];
            const wrapper = input.closest('.file-upload-wrapper');
            
            if (!file) return;

            // Validation
            if (!this.validateFile(file, wrapper)) {
                input.value = ''; // Reset the input
                return;
            }

            // Mise à jour de l'interface
            this.updateUIAfterSelection(wrapper, file.name);
            
            // Créer un objet URL pour la prévisualisation
            const objectUrl = URL.createObjectURL(file);
            wrapper.dataset.objectUrl = objectUrl;
        }

        validateFile(file, wrapper) {
            const maxSizeMB = parseInt(wrapper.dataset.maxSize);
            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            const acceptTypes = wrapper.querySelector('.file-input-hidden').accept;
            
            let isValid = true;
            let errorMessage = '';

            // Validation de la taille
            if (file.size > maxSizeBytes) {
                errorMessage = `La taille du fichier ne doit pas dépasser ${maxSizeMB}MB`;
                isValid = false;
            }

            // Validation du type
            if (acceptTypes && !this.isFileTypeAccepted(file, acceptTypes)) {
                const allowedTypes = acceptTypes.split(',').map(type => type.replace('.', '')).join(', ');
                errorMessage = `Type de fichier non autorisé. Formats acceptés: ${allowedTypes}`;
                isValid = false;
            }

            if (!isValid) {
                this.showError(wrapper, errorMessage);
            } else {
                this.hideError(wrapper);
            }

            return isValid;
        }

        isFileTypeAccepted(file, acceptTypes) {
            const allowedExtensions = acceptTypes.split(',').map(type => type.trim().toLowerCase());
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
            const fileType = file.type.toLowerCase();

            return allowedExtensions.some(extension => {
                if (extension === '.jpg' || extension === '.jpeg') {
                    return fileExtension === '.jpg' || fileExtension === '.jpeg' || fileType === 'image/jpeg';
                }
                return fileExtension === extension || fileType.includes(extension.replace('.', ''));
            });
        }

        updateUIAfterSelection(wrapper, fileName) {
            // Mise à jour du nom du fichier
            wrapper.querySelector('.file-name-display').value = fileName;
            
            // Mettre à jour le texte du bouton
            wrapper.querySelector('.btn-browse').innerHTML = '<i class="fas fa-upload me-1"></i> Remplacer';
            
            // Afficher les actions
            wrapper.querySelector('.file-actions').style.display = 'block';
            
            // Masquer le message de fichier existant
            const existingFileMsg = wrapper.querySelector('.text-success');
            if (existingFileMsg) {
                existingFileMsg.style.display = 'none';
            }
            
            // Marquer comme valide
            wrapper.classList.remove('is-invalid');
            wrapper.classList.add('is-valid');
        }

        previewFile(button) {
            const wrapper = button.closest('.file-upload-wrapper');
            const objectUrl = wrapper.dataset.objectUrl;
            
            if (objectUrl) {
                // Prévisualisation du nouveau fichier
                window.open(objectUrl, '_blank');
            } else {
                // Voir le fichier existant (redirection vers la route de visualisation)
                const category = wrapper.dataset.category;
                window.open(`/view-document/${category}`, '_blank');
            }
        }

        changeFile(button) {
            const wrapper = button.closest('.file-upload-wrapper');
            const fileInput = wrapper.querySelector('.file-input-hidden');
            
            // Nettoyer l'URL objet précédente
            if (wrapper.dataset.objectUrl) {
                URL.revokeObjectURL(wrapper.dataset.objectUrl);
                delete wrapper.dataset.objectUrl;
            }
            
            // Réinitialiser l'interface
            fileInput.value = '';
            wrapper.querySelector('.file-name-display').value = '';
            wrapper.querySelector('.btn-browse').innerHTML = '<i class="fas fa-upload me-1"></i> Importer';
            wrapper.querySelector('.file-actions').style.display = 'none';
            wrapper.classList.remove('is-valid', 'is-invalid');
            
            // Réafficher le message de fichier existant s'il y en a un
            const existingFileMsg = wrapper.querySelector('.text-success');
            if (existingFileMsg) {
                existingFileMsg.style.display = 'block';
            }
            
            this.hideError(wrapper);
        }

        validateAllFiles() {
            let isValid = true;
            const requiredWrappers = document.querySelectorAll('.file-upload-wrapper[data-category]');

            requiredWrappers.forEach(wrapper => {
                const fileInput = wrapper.querySelector('.file-input-hidden');
                const fileName = wrapper.querySelector('.file-name-display').value;

                // Vérifier si le champ est requis ET qu'aucun fichier n'est sélectionné
                if (fileInput.hasAttribute('required') && !fileInput.files[0] && !fileName) {
                    this.showError(wrapper, 'Ce document est requis');
                    isValid = false;
                }
            });

            return isValid;
        }

        showError(wrapper, message) {
            const errorElement = wrapper.querySelector('.file-error');
            errorElement.textContent = message;
            wrapper.classList.add('is-invalid');
            wrapper.classList.remove('is-valid');
        }

        hideError(wrapper) {
            const errorElement = wrapper.querySelector('.file-error');
            errorElement.textContent = '';
            wrapper.classList.remove('is-invalid');
        }
    }
    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        new FileUploadManager();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateEtab = document.getElementById('date_etablissement');
        const dateExp = document.getElementById('date_expiration');

        // Vérifier si les champs d'édition existent (pièce non encore chargée)
        if (dateEtab && dateExp) {
            dateEtab.addEventListener('change', function() {
                if (this.value) {
                    const etabDate = new Date(this.value);
                    const expDate = new Date(etabDate);
                    expDate.setFullYear(etabDate.getFullYear() + 10);
                    expDate.setDate(expDate.getDate() - 1); // 10 ans moins 1 jour
                    dateExp.value = expDate.toISOString().split('T')[0];
                } else {
                    dateExp.value = '';
                }
            });
        }
    });
</script>
<style>
    .file-upload-wrapper {
        margin-bottom: 1rem;
    }

    .file-name-display {
        background-color: #f8f9fa;
    }

    .file-actions {
        transition: all 0.3s ease;
    }

    .is-valid .file-name-display {
        border-color: #28a745;
        background-color: #f8fff9;
    }

    .is-invalid .file-name-display {
        border-color: #dc3545;
        background-color: #fff8f8;
    }

    .btn-browse {
        border-left: none;
    }
</style>