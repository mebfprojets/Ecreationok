/*
 * Dépôt des pièces avant le formulaire de demande (demande/partials/depot_pieces).
 * Choix et contrôle des fichiers (format, taille), aperçu, retour à la pièce déjà déposée,
 * pièces manquantes signalées avant l'envoi. Fichier externe : compatible avec la Content-Security-Policy.
 */
(function () {
    'use strict';

    var formulaire = document.querySelector('[data-depot-pieces]');
    if (!formulaire) { return; }

    var cartes = Array.prototype.slice.call(formulaire.querySelectorAll('[data-piece]'));
    var resumeErreurs = document.querySelector('[data-resume-erreurs]');

    function taille(octets) {
        return octets < 1024 * 1024 ? Math.max(1, Math.round(octets / 1024)) + ' Ko' : (octets / 1024 / 1024).toFixed(1).replace('.', ',') + ' Mo';
    }

    function elements(carte) {
        return {
            fichier: carte.querySelector('[data-fichier]'),
            nom: carte.querySelector('[data-nom-fichier]'),
            etat: carte.querySelector('[data-etat-fichier]'),
            choisir: carte.querySelector('[data-libelle-choisir]'),
            voir: carte.querySelector('[data-voir]'),
            annuler: carte.querySelector('[data-annuler]'),
            erreur: carte.querySelector('[data-erreur]')
        };
    }

    function afficherErreur(carte, message) {
        var e = elements(carte);
        e.erreur.textContent = message || '';
        e.erreur.classList.toggle('d-none', !message);
        carte.classList.toggle('etat-erreur', !!message);
    }

    function existante(carte) { return carte.getAttribute('data-existante') === '1'; }
    function nouvelle(carte) { return elements(carte).fichier.files.length > 0; }

    // Contrôle du fichier choisi : format attendu et taille maximale de la pièce
    function verifier(carte, fichier) {
        var accepte = elements(carte).fichier.getAttribute('accept') || '';
        var max = parseFloat(carte.getAttribute('data-taille-max')) || 10;
        var extension = (fichier.name.split('.').pop() || '').toLowerCase();
        var estPdf = extension === 'pdf' || fichier.type === 'application/pdf';
        var estImage = ['jpg', 'jpeg', 'png'].indexOf(extension) !== -1 || fichier.type === 'image/jpeg' || fichier.type === 'image/png';

        if (accepte.indexOf('.pdf') !== -1 && !estPdf) {
            return '« ' + fichier.name + ' » n’est pas un PDF. Enregistrez ou scannez le document au format PDF.';
        }
        if (accepte.indexOf('image/') !== -1 && !estImage) {
            return '« ' + fichier.name + ' » n’est pas une image JPG ou PNG.';
        }
        if (fichier.size === 0) {
            return '« ' + fichier.name + ' » est vide. Choisissez un autre fichier.';
        }
        if (fichier.size > max * 1024 * 1024) {
            return '« ' + fichier.name + ' » pèse ' + taille(fichier.size) + ' : la taille maximale pour cette pièce est de ' + max + ' Mo. '
                + 'Réduisez le fichier (numérisation en noir et blanc ou en résolution plus faible) puis réessayez.';
        }
        return null;
    }

    // Met la carte dans l'état « déposée », « nouvelle » (fichier choisi, pas encore envoyé) ou « vide »
    function actualiser(carte) {
        var e = elements(carte);
        var fichier = e.fichier.files[0];
        if (carte.dataset.apercu) { URL.revokeObjectURL(carte.dataset.apercu); delete carte.dataset.apercu; }

        carte.classList.remove('etat-deposee', 'etat-nouvelle', 'etat-vide');
        if (fichier) {
            carte.dataset.apercu = URL.createObjectURL(fichier);
            carte.classList.add('etat-nouvelle');
            e.nom.textContent = fichier.name;
            e.etat.textContent = taille(fichier.size) + (existante(carte) ? ' · remplacera la pièce déposée' : ' · prête à être envoyée');
            e.choisir.textContent = 'Choisir un autre fichier';
            e.voir.href = carte.dataset.apercu;
            e.voir.classList.remove('d-none');
            e.annuler.classList.remove('d-none');
        } else {
            carte.classList.add(existante(carte) ? 'etat-deposee' : 'etat-vide');
            e.nom.textContent = e.nom.getAttribute('data-nom-existant') || 'Aucun fichier';
            e.etat.textContent = e.etat.getAttribute('data-etat-existant');
            e.choisir.textContent = existante(carte) ? 'Remplacer' : 'Choisir un fichier';
            e.voir.href = e.voir.getAttribute('data-voir-existant') || '#';
            e.voir.classList.toggle('d-none', !existante(carte));
            e.annuler.classList.add('d-none');
        }
        actualiserResume();
    }

    // Compteur de pièces prêtes et texte du bouton d'envoi
    function actualiserResume() {
        var pretes = cartes.filter(function (c) { return existante(c) || nouvelle(c); }).length;
        var nouvelles = cartes.filter(nouvelle).length;
        var remplacees = cartes.filter(function (c) { return existante(c) && nouvelle(c); }).length;

        document.querySelector('[data-compteur-pretes]').textContent = pretes;
        var barre = document.querySelector('[data-barre-pretes]');
        barre.setAttribute('aria-valuenow', pretes);
        barre.firstElementChild.style.width = Math.round(pretes * 100 / cartes.length) + '%';

        var texte = document.querySelector('[data-texte-envoi]');
        var resume = document.querySelector('[data-resume-envoi]');
        if (nouvelles === 0) {
            texte.textContent = pretes === cartes.length ? 'Continuer vers le formulaire' : 'Continuer';
            resume.textContent = pretes === cartes.length ? 'Aucune pièce remplacée : vos pièces déjà déposées seront conservées.' : '';
        } else {
            texte.textContent = 'Enregistrer ' + (nouvelles > 1 ? 'les ' + nouvelles + ' pièces' : 'la pièce') + ' et continuer';
            resume.textContent = remplacees ? remplacees + ' pièce' + (remplacees > 1 ? 's' : '') + ' déjà déposée' + (remplacees > 1 ? 's' : '') + ' sera remplacée' + (remplacees > 1 ? 's' : '') + '.' : '';
        }
    }

    cartes.forEach(function (carte) {
        var e = elements(carte);
        carte.querySelector('[data-choisir]').addEventListener('click', function () { e.fichier.click(); });

        e.fichier.addEventListener('change', function () {
            var fichier = e.fichier.files[0];
            if (!fichier) { actualiser(carte); return; }
            var probleme = verifier(carte, fichier);
            if (probleme) {
                e.fichier.value = '';   // le fichier refusé n'est pas envoyé ; la pièce déjà déposée reste en place
                afficherErreur(carte, probleme);
            } else {
                afficherErreur(carte, null);
            }
            actualiser(carte);
        });

        e.annuler.addEventListener('click', function () {
            e.fichier.value = '';
            afficherErreur(carte, null);
            actualiser(carte);
        });
    });

    // Pièce d'identité : date d'expiration = établissement + 10 ans - 1 jour
    var etablissement = document.getElementById('date_etablissement');
    var expiration = document.getElementById('date_expiration');
    if (etablissement && expiration) {
        etablissement.addEventListener('change', function () {
            if (!this.value) { expiration.value = ''; return; }
            var d = new Date(this.value + 'T00:00:00Z');
            d.setUTCFullYear(d.getUTCFullYear() + 10);
            d.setUTCDate(d.getUTCDate() - 1);
            expiration.value = d.toISOString().slice(0, 10);
        });
    }

    // Avant l'envoi : toutes les pièces doivent être déposées ou choisies, et la pièce d'identité renseignée
    formulaire.addEventListener('submit', function (evenement) {
        var problemes = [];
        var premier = null;

        cartes.forEach(function (carte) {
            if (!existante(carte) && !nouvelle(carte)) {
                afficherErreur(carte, 'Cette pièce est obligatoire : choisissez le fichier à déposer.');
                problemes.push(carte.getAttribute('data-libelle'));
                premier = premier || carte;
            }
        });
        formulaire.querySelectorAll('[data-obligatoire]').forEach(function (champ) {
            var vide = !champ.value.trim();
            champ.classList.toggle('is-invalid', vide);
            if (vide) {
                problemes.push(champ.getAttribute('data-obligatoire'));
                premier = premier || champ.closest('[data-piece]');
            }
        });

        if (problemes.length) {
            evenement.preventDefault();
            resumeErreurs.innerHTML = '';
            var titre = document.createElement('strong');
            titre.textContent = problemes.length > 1 ? 'Il manque ' + problemes.length + ' éléments avant de continuer :' : 'Il manque un élément avant de continuer :';
            var liste = document.createElement('ul');
            liste.className = 'mb-0 mt-1';
            problemes.forEach(function (p) { var li = document.createElement('li'); li.textContent = p; liste.appendChild(li); });
            resumeErreurs.appendChild(titre);
            resumeErreurs.appendChild(liste);
            resumeErreurs.classList.remove('d-none');
            (premier || resumeErreurs).scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        resumeErreurs.classList.add('d-none');
        var bouton = formulaire.querySelector('[data-bouton-envoi]');
        bouton.disabled = true;
        bouton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>'
            + (cartes.some(nouvelle) ? 'Envoi des pièces en cours…' : 'Chargement…');
    });

    formulaire.querySelectorAll('[data-obligatoire]').forEach(function (champ) {
        champ.addEventListener('input', function () { if (champ.value.trim()) { champ.classList.remove('is-invalid'); } });
    });

    // Retour arrière du navigateur après un envoi : le bouton redevient utilisable
    window.addEventListener('pageshow', function () {
        var bouton = formulaire.querySelector('[data-bouton-envoi]');
        bouton.disabled = false;
        bouton.innerHTML = '<span data-texte-envoi></span><i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>';
        cartes.forEach(actualiser);
    });

    cartes.forEach(actualiser);
})();
