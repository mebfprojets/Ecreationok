/*
 * Page Contacts : filtre des représentations CEFORE/CEFAC par ville (ou adresse) pendant la saisie.
 * Les accents sont ignorés (« fada » trouve « Fada N’Gourma », « dedougou » trouve « Dédougou »).
 */
(function () {
    'use strict';

    var champ = document.querySelector('[data-recherche-contacts]');
    if (!champ) { return; }
    var cartes = Array.prototype.slice.call(document.querySelectorAll('[data-contact]'));
    var aucun = document.querySelector('[data-aucun-contact]');

    function simplifier(texte) {
        return String(texte || '').toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[’']/g, ' ');
    }

    champ.addEventListener('input', function () {
        var recherche = simplifier(champ.value.trim());
        var visibles = 0;
        cartes.forEach(function (carte) {
            var trouve = !recherche || simplifier(carte.getAttribute('data-contact')).indexOf(recherche) !== -1;
            carte.classList.toggle('d-none', !trouve);
            if (trouve) { visibles++; }
        });
        aucun.classList.toggle('d-none', visibles > 0);
    });
})();
