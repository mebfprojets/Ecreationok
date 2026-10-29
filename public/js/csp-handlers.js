/*
 * Gestionnaires d'événements compatibles avec la Content-Security-Policy (ANSSI VUL-009).
 *
 * La CSP interdit les attributs onclick="…" / onchange="…" écrits dans le HTML.
 * Ils sont remplacés par des attributs data-csp-* :
 *
 *   data-csp-change="nomFonction"  data-csp-change-args='["arg1","arg2"]'
 *   data-csp-click="nomFonction"   data-csp-click-args='[12]'
 *
 * La fonction globale est appelée avec this = l'élément, comme l'était l'ancien attribut.
 * Le gestionnaire est posé comme propriété (el.onchange = …) : il est donc aussi déclenché
 * par les .trigger('change') de jQuery et de Select2, exactement comme avant.
 * Les éléments ajoutés plus tard dans la page sont pris en charge automatiquement.
 */
(function () {
    'use strict';

    var EVENEMENTS = ['click', 'change', 'submit', 'input', 'keyup', 'blur'];

    // Actions prédéfinies pour les anciens attributs qui n'appelaient pas une fonction
    var ACTIONS = {
        '__majuscules': function () {
            this.value = this.value.toUpperCase();
        },
        '__majuscule_initiale': function () {
            this.value = this.value.charAt(0).toUpperCase() + this.value.substr(1);
        },
        '__retour': function () {
            history.back();
        },
        '__deconnexion': function (event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        },
        '__aucune': function (event) {
            event.preventDefault();
        },
        // Champ « nombre entier » : la partie décimale est retirée (12,5 -> 12) et seuls les chiffres sont conservés
        '__entier': function () {
            var chiffres = this.value.split(/[.,]/)[0].replace(/[^0-9]/g, '');
            if (chiffres !== this.value) {
                this.value = chiffres;
            }
        },
        // Numéro de téléphone : chiffres uniquement, limité à data-chiffres-max (8). Un numéro collé avec
        // l'indicatif du Burkina (+226 / 00226) est ramené à ses 8 chiffres. (Pas de maxlength :
        // le navigateur couperait le texte collé avant ce traitement.)
        '__chiffres': function () {
            var max = parseInt(this.getAttribute('data-chiffres-max'), 10) || 0;
            var chiffres = this.value.replace(/[^0-9]/g, '');
            if (max && chiffres.length > max && /^(00)?226/.test(chiffres)) {
                chiffres = chiffres.replace(/^(00)?226/, '');
            }
            if (max) {
                chiffres = chiffres.slice(0, max);
            }
            if (chiffres !== this.value) {
                this.value = chiffres;
            }
        },
        // Copie le texte de l'attribut data-copier dans le presse-papiers (ex. code USSD de paiement)
        '__copier': function (event) {
            event.preventDefault();
            var bouton = this;
            var texte = bouton.getAttribute('data-copier') || '';
            var confirmer = function () {
                var libelle = bouton.getAttribute('data-libelle-copie') || 'Copié';
                var avant = bouton.innerHTML;
                bouton.textContent = libelle;
                setTimeout(function () { bouton.innerHTML = avant; }, 2000);
            };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(texte).then(confirmer);
            } else {
                var zone = document.createElement('textarea');
                zone.value = texte;
                document.body.appendChild(zone);
                zone.select();
                try { document.execCommand('copy'); confirmer(); } catch (e) { /* copie impossible : rien */ }
                zone.remove();
            }
        }
    };

    // Cartes cliquables (data-carte-cliquable) : un clic n'importe où dans la carte déclenche
    // son bouton principal (data-action-principale), sauf si le clic porte déjà sur un élément interactif.
    document.addEventListener('click', function (event) {
        var carte = event.target.closest ? event.target.closest('[data-carte-cliquable]') : null;
        if (!carte || event.target.closest('a, button, input, select, textarea, label')) {
            return;
        }
        var action = carte.querySelector('[data-action-principale]');
        if (action && !action.disabled) {
            action.click();
        }
    });

    // Formulaires marqués data-envoi-unique : un seul envoi (évite un double paiement sur double clic)
    document.addEventListener('submit', function (event) {
        var formulaire = event.target;
        if (!formulaire.matches || !formulaire.matches('form[data-envoi-unique]') || event.defaultPrevented) {
            return;
        }
        if (formulaire.getAttribute('data-envoye') === '1') {
            event.preventDefault();
            return;
        }
        formulaire.setAttribute('data-envoye', '1');
        formulaire.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (bouton) {
            bouton.setAttribute('data-libelle-initial', bouton.innerHTML);
            bouton.disabled = true;
            if (bouton.getAttribute('data-libelle-envoi')) {
                bouton.innerHTML = bouton.getAttribute('data-libelle-envoi');
            }
        });
    });

    // Retour arrière du navigateur (page restaurée depuis le cache) : les formulaires redeviennent utilisables
    window.addEventListener('pageshow', function (event) {
        if (!event.persisted) {
            return;
        }
        document.querySelectorAll('form[data-envoi-unique][data-envoye="1"]').forEach(function (formulaire) {
            formulaire.removeAttribute('data-envoye');
            formulaire.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (bouton) {
                bouton.disabled = false;
                if (bouton.getAttribute('data-libelle-initial') !== null) {
                    bouton.innerHTML = bouton.getAttribute('data-libelle-initial');
                }
            });
        });
    });

    function lireArguments(el, evenement) {
        var brut = el.getAttribute('data-csp-' + evenement + '-args');
        if (!brut) {
            return [];
        }
        try {
            return JSON.parse(brut);
        } catch (e) {
            console.warn('[CSP] arguments invalides', el, brut);
            return [];
        }
    }

    function brancher(el) {
        EVENEMENTS.forEach(function (evenement) {
            var nom = el.getAttribute('data-csp-' + evenement);
            if (!nom || el['__csp_' + evenement]) {
                return;
            }
            el['__csp_' + evenement] = true;
            el['on' + evenement] = function (event) {
                if (ACTIONS[nom]) {
                    ACTIONS[nom].call(el, event);
                    return;
                }
                if (typeof window[nom] !== 'function') {
                    console.warn('[CSP] fonction introuvable : ' + nom);
                    return;
                }
                window[nom].apply(el, lireArguments(el, evenement));
            };
        });
    }

    var SELECTEUR = EVENEMENTS.map(function (e) { return '[data-csp-' + e + ']'; }).join(',');

    function brancherDans(racine) {
        if (racine.nodeType !== 1) {
            return;
        }
        if (racine.matches && racine.matches(SELECTEUR)) {
            brancher(racine);
        }
        var elements = racine.querySelectorAll(SELECTEUR);
        for (var i = 0; i < elements.length; i++) {
            brancher(elements[i]);
        }
    }

    brancherDans(document.documentElement);
    document.addEventListener('DOMContentLoaded', function () {
        brancherDans(document.documentElement);
    });

    new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            for (var i = 0; i < mutation.addedNodes.length; i++) {
                brancherDans(mutation.addedNodes[i]);
            }
        });
    }).observe(document.documentElement, { childList: true, subtree: true });
})();
