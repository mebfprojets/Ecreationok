/*
 * Page laissée ouverte sans activité : rechargement automatique une fois le délai d'inactivité dépassé.
 * Le serveur (middleware DeconnexionInactivite) déconnecte alors l'utilisateur : les données ne restent
 * plus affichées à l'écran. Le délai (en minutes) est donné par l'attribut data-inactivite-minutes du <body>.
 */
(function () {
    'use strict';
    var minutes = parseInt(document.body && document.body.getAttribute('data-inactivite-minutes'), 10);
    if (!minutes) { return; }

    var delai = minutes * 60 * 1000 + 15000;   // 15 s de marge sur le délai du serveur
    var derniere = Date.now();
    var noter = function () { derniere = Date.now(); };
    ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'wheel'].forEach(function (evenement) {
        window.addEventListener(evenement, noter, { passive: true });
    });

    setInterval(function () {
        if (Date.now() - derniere > delai) {
            window.location.reload();
        }
    }, 30000);
})();
