/*
 * Traduction des erreurs des appels AJAX en messages lisibles pour l'usager.
 *
 *   error: function (xhr) { alert(messageErreurAjax(xhr)); }
 *
 * 422 : liste des champs invalides renvoyée par la validation Laravel
 * 419 / 413 / 429 / 500… : message renvoyé par le serveur (app/Exceptions/Handler.php)
 * 0   : pas de réponse (connexion coupée)
 */
(function (window) {
    'use strict';

    var MESSAGES = {
        0: 'Le serveur ne répond pas. Vérifiez votre connexion internet puis réessayez.',
        401: 'Votre session est terminée. Reconnectez-vous puis réessayez.',
        403: 'Vous n’avez pas l’autorisation d’effectuer cette action.',
        404: 'L’élément demandé est introuvable.',
        413: 'Les fichiers envoyés sont trop volumineux. Réduisez leur taille puis réessayez.',
        419: 'Votre session a expiré pour des raisons de sécurité. Rechargez la page puis réessayez.',
        429: 'Trop de tentatives en peu de temps. Patientez une minute puis réessayez.',
        500: 'Une erreur est survenue lors du traitement de votre demande. Réessayez dans quelques instants ; si le problème persiste, contactez le CEFORE.'
    };

    window.messageErreurAjax = function (xhr) {
        var statut = xhr && typeof xhr.status === 'number' ? xhr.status : 0;
        var json = xhr && xhr.responseJSON;

        if (!json && xhr && xhr.responseText) {
            try { json = JSON.parse(xhr.responseText); } catch (e) { json = null; }
        }

        if (statut === 422 && json && json.errors) {
            var lignes = [];
            Object.keys(json.errors).forEach(function (champ) {
                [].concat(json.errors[champ]).forEach(function (m) { lignes.push('• ' + m); });
            });
            if (lignes.length) {
                return 'Veuillez corriger les points suivants :\n' + lignes.join('\n');
            }
        }

        if (json && typeof json.message === 'string' && json.message && statut !== 422 && statut < 500) {
            return json.message;
        }
        if (json && typeof json.message === 'string' && json.message && statut >= 500 && json.message.indexOf('Server Error') === -1) {
            return json.message;
        }

        return MESSAGES[statut] || MESSAGES[500];
    };
})(window);
