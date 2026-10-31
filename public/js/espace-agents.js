/*
 * Espace agents (AdminLTE 4 / Bootstrap 5.3) : tableaux, calendriers, infobulles et messages.
 * Fichier externe, compatible avec la Content-Security-Policy (aucun script en ligne nécessaire).
 */
(function ($) {
    'use strict';

    var FRANCAIS = {
        decimal: ',',
        thousands: ' ',
        emptyTable: 'Aucune donnée à afficher',
        info: 'Lignes _START_ à _END_ sur _TOTAL_',
        infoEmpty: 'Aucune ligne',
        infoFiltered: '(filtrées parmi _MAX_)',
        lengthMenu: '_MENU_ lignes par page',
        loadingRecords: 'Chargement…',
        processing: 'Traitement…',
        search: 'Rechercher :',
        zeroRecords: 'Aucune ligne ne correspond à la recherche',
        aria: {
            sortAscending: ' : trier par ordre croissant',
            sortDescending: ' : trier par ordre décroissant',
            paginate: { first: 'Première page', last: 'Dernière page', next: 'Page suivante', previous: 'Page précédente' }
        },
        buttons: {
            copy: 'Copier',
            copyTitle: 'Copie dans le presse-papiers',
            copySuccess: { _: '%d lignes copiées', 1: '1 ligne copiée' },
            print: 'Imprimer',
            colvis: 'Colonnes'
        }
    };

    function initialiserTableau(table, options) {
        try {
            $(table).DataTable($.extend({ language: FRANCAIS, responsive: true, autoWidth: false }, options));
        } catch (e) {
            // Tableau mal formé (nombre de colonnes...) : il reste affiché tel quel, sans les outils
            if (window.console) { console.warn('Tableau non amélioré :', e); }
        }
    }

    /* Page de traitement d'une demande (backend/adminlte/detail) */
    function initialiserTraitementDemande() {
        var $motif = $('#motif_rejet');
        var texteAuto = '';   // dernier texte généré à partir des pièces cochées

        // Visionneuse : un clic sur une pièce l'affiche à côté des informations
        $(document).on('click', '[data-piece-url], [data-piece-absente]', function () {
            var url = $(this).data('piece-url');
            // Fichier introuvable sur le serveur : message à la place de l'aperçu
            $('[data-visionneuse]').toggleClass('d-none', !url);
            $('[data-visionneuse-absente]').toggleClass('d-none', !!url);
            // PDF : page entière, sans le panneau des miniatures (sans effet sur les images)
            if (url) { $('[data-visionneuse]').attr('src', url + '#navpanes=0&zoom=page-fit'); }
            $('[data-bouton-agrandir]').toggleClass('d-none', !url);
            $('[data-visionneuse-titre]').text($(this).data('piece-titre'));
            $('[data-piece]').removeClass('active-piece');
            $(this).closest('[data-piece]').addClass('active-piece');
        });

        // Pièce précédente / suivante depuis l'aperçu, sans remonter à la liste
        function changerDePiece(sens) {
            var $pieces = $('[data-piece-url], [data-piece-absente]');
            var actuelle = $pieces.index($('.active-piece').find('[data-piece-url], [data-piece-absente]'));
            var suivante = $pieces.eq((actuelle + sens + $pieces.length) % $pieces.length);
            suivante.trigger('click');
        }
        $(document).on('click', '[data-piece-precedente]', function () { changerDePiece(-1); });
        $(document).on('click', '[data-piece-suivante]', function () { changerDePiece(1); });

        // Plein écran : on affiche la pièce actuellement dans l'aperçu ; on vide la fenêtre en la fermant
        $('#modal-apercu-plein').on('show.bs.modal', function () {
            $('[data-apercu-plein]').attr('src', String($('[data-visionneuse]').attr('src')).split('#')[0] + '#zoom=page-fit');
            $('[data-apercu-plein-titre]').text($('[data-visionneuse-titre]').text());
        }).on('hidden.bs.modal', function () {
            $('[data-apercu-plein]').attr('src', 'about:blank');
        });

        function piecesSignalees() {
            return $('.piece-a-corriger:checked').map(function () { return $(this).data('libelle'); }).get();
        }

        // Pièces « À corriger » : compteur, mise en évidence et alerte avant une validation
        $(document).on('change', '.piece-a-corriger', function () {
            var nombre = piecesSignalees().length;
            $(this).closest('[data-piece]').toggleClass('piece-signalee', this.checked);
            $('[data-compteur-corrections]').toggleClass('d-none', nombre === 0)
                .text(nombre + ' pièce' + (nombre > 1 ? 's' : '') + ' à corriger');
            $('[data-alerte-validation]').toggleClass('d-none', nombre === 0);
        });

        function compterMotif() {
            $('[data-compteur-motif]').text(($motif.val() || '').length + ' / 2000');
        }
        $motif.on('input', compterMotif);

        // À l'ouverture de la fenêtre de correction : motif pré-rempli avec les pièces cochées
        // (sans écraser ce que l'agent a déjà écrit lui-même)
        $('#modal-confirm-rejet').on('show.bs.modal', function () {
            var pieces = piecesSignalees();
            var actuel = $.trim($motif.val() || '');
            if (pieces.length && (actuel === '' || actuel === texteAuto)) {
                texteAuto = 'Merci de corriger les pièces suivantes :\n' + pieces.map(function (p) { return '- ' + p + ' : '; }).join('\n');
                $motif.val(texteAuto);
            }
            compterMotif();
        }).on('shown.bs.modal', function () {
            $motif.trigger('focus');
        });

        // Phrases types ajoutées à la suite du motif
        $(document).on('click', '[data-motif-suggestion]', function () {
            var actuel = $motif.val() || '';
            $motif.val((actuel && !/\n$/.test(actuel) ? actuel + '\n' : actuel) + $(this).data('motif-suggestion')).trigger('focus');
            compterMotif();
        });

        // Correction de l'entreprise : la liste des activités suit le secteur choisi
        $(document).on('change', 'select[data-activites-url]', function () {
            var $cible = $($(this).data('activites-cible'));
            $.ajax({
                url: $(this).data('activites-url'),
                data: { valeur_actuel: $(this).val() },
                dataType: 'json',
                error: function (xhr) { alert(messageErreurAjax(xhr)); },
                success: function (activites) {
                    $cible.empty().append($('<option>', { value: '', text: 'Choisir l’activité…' }));
                    $.each(activites || [], function (i, a) {
                        $cible.append($('<option>', { value: a.Code, text: a.description }));
                    });
                }
            });
        });
    }

    $(function () {
        if ($.fn.dataTable) {
            // Pas de fenêtre « alert » en cas d'erreur DataTables : le tableau reste lisible
            $.fn.dataTable.ext.errMode = 'throw';

            // Listes avec recherche et exports (plusieurs pages réutilisent l'identifiant example1)
            $('table[id="example1"]').each(function () {
                initialiserTableau(this, {
                    pageLength: 25,
                    order: [],
                    layout: {
                        topStart: { buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'] },
                        topEnd: 'search',
                        bottomStart: 'info',
                        bottomEnd: 'paging'
                    }
                });
            });
            // Tableaux du tableau de bord avec exports, triés au départ sur la 6e colonne (total) décroissante
            $('table.tableau-export').each(function () {
                initialiserTableau(this, {
                    pageLength: 10, order: [[5, 'desc']],
                    layout: { topStart: { buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] }, topEnd: 'search', bottomStart: 'info', bottomEnd: 'paging' }
                });
            });
            $('table[id="example2"]').each(function () {
                initialiserTableau(this, { searching: false, lengthChange: false, order: [] });
            });

            // Tableau de bord : 50 dernières actions des agents, 25 par page (2 pages)
            $('#journal-actions').each(function () {
                initialiserTableau(this, {
                    pageLength: 25,
                    lengthChange: false,
                    order: [[0, 'desc']],
                    language: $.extend({}, FRANCAIS, { info: 'Actions _START_ à _END_ sur _TOTAL_', search: 'Filtrer :' }),
                    layout: { topStart: null, topEnd: 'search', bottomStart: 'info', bottomEnd: 'paging' }
                });
            });

            // Grandes listes : le serveur renvoie une page à la fois (data-ajax-url), la recherche porte sur toute la base
            $('table[data-ajax-url]').each(function () {
                initialiserTableau(this, {
                    serverSide: true,
                    processing: true,
                    ajax: { url: $(this).data('ajax-url'), error: function (xhr) { alert(messageErreurAjax(xhr)); } },
                    searchDelay: 500,
                    pageLength: 25,
                    lengthMenu: [10, 25, 50, 100],
                    // Tri initial « colonne,sens » et colonnes non triables, déclarés sur le tableau
                    order: [String($(this).data('tri') || '0,desc').split(',')].map(function (t) { return [parseInt(t[0], 10), t[1] || 'desc']; }),
                    columnDefs: [{ targets: String($(this).data('non-triables') || '').split(',').filter(Boolean).map(Number), orderable: false }],
                    layout: {
                        topStart: ['pageLength', { buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'] }],
                        topEnd: 'search',
                        bottomStart: 'info',
                        bottomEnd: 'paging'
                    }
                });
            });
        }

        initialiserTraitementDemande();

        // Listes : toute la ligne ouvre le détail (data-href). Ctrl/Cmd + clic ou clic molette : nouvel onglet.
        // Les liens, boutons et champs de la ligne, et la flèche des colonnes masquées (DataTables Responsive), gardent leur rôle.
        function ouvrirLigne(evenement, ligne) {
            var url = ligne.getAttribute('data-href');
            if (!url) { return; }
            if (evenement.ctrlKey || evenement.metaKey || evenement.button === 1) {
                window.open(url, '_blank', 'noopener');
            } else {
                window.location.href = url;
            }
        }
        function clicInterne(evenement) {
            return $(evenement.target).closest('a, button, input, select, textarea, label, .dtr-control, .dtr-details').length > 0
                || (window.getSelection && String(window.getSelection()).length > 0);   // sélection de texte : pas de navigation
        }
        $(document).on('click', 'tr[data-href]', function (e) {
            if (!clicInterne(e)) { ouvrirLigne(e, this); }
        });
        $(document).on('auxclick', 'tr[data-href]', function (e) {
            if (e.button === 1 && !clicInterne(e)) { e.preventDefault(); ouvrirLigne(e, this); }
        });
        $(document).on('keydown', 'tr[data-href]', function (e) {
            if (e.key === 'Enter' && e.target === this) { ouvrirLigne(e, this); }
        });

        // Calendrier des dates d'établissement des pièces : même format que le site public (jj/mm/aaaa)
        if ($.fn.datepicker) {
            $('.date_piecejointe').datepicker({ autoclose: true, endDate: new Date(), format: 'dd/mm/yyyy', weekStart: 1 });
        }

        // Infobulles Bootstrap 5
        if (window.bootstrap) {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
                bootstrap.Tooltip.getOrCreateInstance(el);
            });
        }

        // Les messages de réussite disparaissent d'eux-mêmes ; les erreurs restent jusqu'à fermeture
        setTimeout(function () {
            $('.messages-flash .alert-success').not('.alert-important').fadeOut(400);
        }, 8000);
    });
})(jQuery);
