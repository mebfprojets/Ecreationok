/*
 * Page d'accueil : les chiffres clés des statistiques comptent jusqu'à leur valeur quand ils apparaissent à l'écran.
 * La valeur finale est déjà écrite dans la page : sans JavaScript (ou mouvement réduit), rien ne change.
 */
(function () {
    'use strict';

    var compteurs = document.querySelectorAll('[data-compteur]');
    if (!compteurs.length || !('IntersectionObserver' in window)
        || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
        return;
    }

    var format = new Intl.NumberFormat('fr-FR');

    function animer(element) {
        var cible = parseInt(element.getAttribute('data-compteur'), 10) || 0;
        var debut = null;
        var duree = 1200;
        function etape(instant) {
            if (debut === null) { debut = instant; }
            var avancement = Math.min(1, (instant - debut) / duree);
            var adouci = 1 - Math.pow(1 - avancement, 3);   // ralentit en fin de course
            element.textContent = format.format(Math.round(cible * adouci));
            if (avancement < 1) { window.requestAnimationFrame(etape); }
        }
        window.requestAnimationFrame(etape);
    }

    var observateur = new IntersectionObserver(function (entrees) {
        entrees.forEach(function (entree) {
            if (entree.isIntersecting) {
                observateur.unobserve(entree.target);
                animer(entree.target);
            }
        });
    }, { threshold: 0.4 });

    compteurs.forEach(function (element) { observateur.observe(element); });
})();
