/*
 * Détail d'une demande rejetée (site public) : reprise de la signature dans une fenêtre.
 * Utilise le module de signature jQuery UI (backend/js/signature.js), comme le formulaire de demande.
 * Le cadre est créé à l'ouverture de la fenêtre : il doit être visible pour prendre sa vraie taille.
 */
(function ($) {
    'use strict';

    var $fenetre = $('#modal-reprise-signature');
    if (!$fenetre.length || !$.fn.signature) { return; }

    var $zone = $fenetre.find('[data-zone-signature]');
    var $champ = $fenetre.find('[data-champ-signature]');
    var $etat = $fenetre.find('[data-etat-signature]');
    var $enregistrer = $fenetre.find('[data-enregistrer-signature]');
    var cree = false;

    function actualiser() {
        var vide = !cree || $zone.signature('isEmpty');
        if (vide) { $champ.val(''); }
        $enregistrer.prop('disabled', vide);
        $etat.text(vide ? 'Le cadre est vide.' : 'Signature prête à être enregistrée.');
    }

    $fenetre.on('shown.bs.modal', function () {
        if (!cree) {
            $zone.signature({ syncField: $champ, syncFormat: 'PNG', guideline: true, guidelineOffset: 40, thickness: 2, change: actualiser });
            cree = true;
        }
        actualiser();
    });

    $fenetre.find('[data-effacer-signature]').on('click', function () {
        if (cree) { $zone.signature('clear'); }
        actualiser();
    });

    $fenetre.find('[data-reprise-signature]').on('submit', function (evenement) {
        if (!cree || $zone.signature('isEmpty') || !$champ.val()) {
            evenement.preventDefault();
            $etat.text('Signez dans le cadre avant d’enregistrer.');
            return;
        }
        $enregistrer.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Enregistrement…');
    });
})(jQuery);
