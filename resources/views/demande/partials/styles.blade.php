{{-- Styles communs à « Mes demandes » et au détail d'une demande (côté promoteur) --}}
<style>
    .ed-page { max-width: 1140px; margin: 32px auto 48px; padding: 0 16px; }
    .ed-titre { font-weight: 700; margin: 0; }
    .ed-sous-titre { color: #6c757d; margin: 4px 0 0; }
    .ed-carte { background: #fff; border: 1px solid #e3e7ea; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, .04); }
    section.ed-carte { padding: 0; } /* le thème du site ajoute 70px de marge à toutes les <section> */
    .ed-carte + .ed-carte { margin-top: 16px; }
    .ed-carte-entete { padding: 16px 20px; border-bottom: 1px solid #eef1f3; display: flex; align-items: center;
                       justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .ed-carte-entete h2, .ed-carte-entete h3 { font-size: 1.05rem; font-weight: 700; margin: 0; text-transform: none; }
    .ed-carte-corps { padding: 18px 20px; }
    .ed-badge { display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; font-weight: 600;
                padding: 5px 10px; border-radius: 999px; white-space: nowrap; }
    .ed-badge.warning { background: #fff4d6; color: #8a6100; }
    .ed-badge.info { background: #dff3fb; color: #0b6a8a; }
    .ed-badge.danger { background: #fde4e4; color: #a01e1e; }
    .ed-badge.success { background: #e1f5e7; color: #17663a; }
    .ed-badge.primary { background: #e3edff; color: #1e4fa8; }
    .ed-meta { display: flex; flex-wrap: wrap; gap: 6px 22px; color: #555; font-size: .9rem; }
    .ed-meta i { color: #8a949c; width: 16px; }

    /* Frise de suivi */
    .ed-frise { display: flex; list-style: none; padding: 0; margin: 0; }
    .ed-frise li { flex: 1; text-align: center; position: relative; font-size: .78rem; color: #8a949c; }
    .ed-frise li::before { content: ''; position: absolute; top: 13px; left: -50%; width: 100%; height: 3px; background: #e3e7ea; z-index: 0; }
    .ed-frise li:first-child::before { display: none; }
    .ed-frise .rond { position: relative; z-index: 1; width: 28px; height: 28px; border-radius: 50%; margin: 0 auto 6px;
                      display: flex; align-items: center; justify-content: center; background: #e3e7ea; color: #fff; font-size: .8rem; }
    .ed-frise li.fait { color: #17663a; }
    .ed-frise li.fait .rond, .ed-frise li.fait::before, .ed-frise li.encours::before, .ed-frise li.erreur::before { background: #1b8a4a; }
    .ed-frise li.encours { color: #1e4fa8; font-weight: 700; }
    .ed-frise li.encours .rond { background: #1e4fa8; box-shadow: 0 0 0 4px #dbe6ff; }
    .ed-frise li.erreur { color: #a01e1e; font-weight: 700; }
    .ed-frise li.erreur .rond { background: #c82333; box-shadow: 0 0 0 4px #fbd5d5; }

    /* Lecture des informations */
    .ed-infos { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 14px 24px; margin: 0; }
    .ed-infos dt { font-size: .8rem; text-transform: uppercase; letter-spacing: .03em; color: #3c4a55; font-weight: 700; }
    .ed-infos dd { margin: 3px 0 0; color: #1d1d1d; word-break: break-word; }

    /* Rubriques : un fond léger et une couleur d'accent par bloc pour faciliter la lecture */
    .ed-rubrique { border-radius: 8px; padding: 14px 16px 16px; border-left: 4px solid var(--accent); background: var(--fond); }
    .ed-rubrique + .ed-rubrique { margin-top: 14px; }
    .ed-rubrique-titre { font-size: .95rem; font-weight: 700; margin: 0 0 12px; color: var(--accent); text-transform: none; }
    .ed-rubrique-titre i { margin-right: 6px; }
    .ed-rubrique-identite    { --fond: #eef7f1; --accent: #1b6b3a; }
    .ed-rubrique-activite    { --fond: #edf3fc; --accent: #1e4fa8; }
    .ed-rubrique-siege       { --fond: #fdf6ea; --accent: #9a5b00; }
    .ed-rubrique-capital     { --fond: #f4effb; --accent: #5b3a99; }
    .ed-rubrique-personne    { --fond: #eef7f1; --accent: #1b6b3a; }
    .ed-rubrique-coordonnees { --fond: #edf3fc; --accent: #1e4fa8; }
    .ed-infos .large { grid-column: 1 / -1; }
    .ed-vide { color: #adb5bd; font-style: italic; }
    .ed-page textarea.form-control { min-height: 110px; height: auto; } /* le thème fixe la hauteur des champs */

    /* Rejet */
    .ed-rejet { border: 1px solid #f3c2c2; border-left: 5px solid #c82333; background: #fff6f6; }
    .ed-rejet .motif { background: #fff; border: 1px dashed #e5a5a5; border-radius: 8px; padding: 12px 14px; white-space: pre-line; }
    .ed-etapes-correction { counter-reset: etape; list-style: none; padding: 0; margin: 14px 0 0; }
    .ed-etapes-correction li { counter-increment: etape; position: relative; padding: 0 0 10px 36px; }
    .ed-etapes-correction li::before { content: counter(etape); position: absolute; left: 0; top: 0; width: 24px; height: 24px;
                                       border-radius: 50%; background: #c82333; color: #fff; font-size: .8rem; font-weight: 700;
                                       display: flex; align-items: center; justify-content: center; }

    /* Historique */
    .ed-historique { list-style: none; padding: 0; margin: 0; }
    .ed-historique li { position: relative; padding: 0 0 14px 26px; border-left: 2px solid #e3e7ea; margin-left: 8px; }
    .ed-historique li:last-child { border-left-color: transparent; padding-bottom: 0; }
    .ed-historique li::before { content: ''; position: absolute; left: -7px; top: 3px; width: 12px; height: 12px; border-radius: 50%; background: #1b8a4a; }
    .ed-historique li.rejet::before { background: #c82333; }
    .ed-historique .date { font-size: .8rem; color: #8a949c; }

    /* Pièces jointes */
    .ed-pieces { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 12px; }
    .ed-piece { display: flex; align-items: center; gap: 12px; border: 1px solid #e3e7ea; border-radius: 8px; padding: 10px 12px; }
    .ed-piece .icone { font-size: 1.4rem; color: #c82333; }
    .ed-piece .nom { flex: 1; font-weight: 600; font-size: .9rem; }

    /* Paiement */
    .ed-page-etroite { max-width: 900px; }
    .ed-montant .libelle { font-size: .8rem; text-transform: uppercase; letter-spacing: .03em; color: #6c757d; font-weight: 700; }
    .ed-montant .valeur { font-size: 1.7rem; font-weight: 800; color: #1b6b3a; line-height: 1.2; }
    .ed-paiement-option { height: 100%; display: flex; flex-direction: column; align-items: center; text-align: center;
                          padding: 22px 18px; border: 2px solid #e3e7ea; border-radius: 12px; background: #fff; transition: border-color .15s, box-shadow .15s; }
    .ed-paiement-option:hover { box-shadow: 0 6px 18px rgba(0, 0, 0, .07); }
    .ed-paiement-option[data-carte-cliquable] { cursor: pointer; }
    .ed-paiement-option.orange:hover { border-color: #ff7900; }
    .ed-paiement-option.moov:hover { border-color: #0066b3; }
    .ed-paiement-option img { width: 88px; height: 88px; object-fit: contain; margin-bottom: 10px; }
    .ed-paiement-option h3 { font-size: 1.1rem; font-weight: 700; margin: 0 0 6px; text-transform: none; }
    .ed-paiement-option p { color: #6c757d; font-size: .9rem; flex: 1; }
    .ed-paiement-option form { width: 100%; }
    .btn-orange { background: #ff7900; border-color: #ff7900; color: #fff; }
    .btn-orange:hover, .btn-orange:focus { background: #e56d00; border-color: #e56d00; color: #fff; }
    .btn-moov { background: #0066b3; border-color: #0066b3; color: #fff; }
    .btn-moov:hover, .btn-moov:focus { background: #005799; border-color: #005799; color: #fff; }
    .btn-orange:disabled { background: #ff7900; border-color: #ff7900; color: #fff; opacity: .65; }
    .btn-moov:disabled { background: #0066b3; border-color: #0066b3; color: #fff; opacity: .65; }
    .ed-ussd { display: inline-flex; align-items: center; gap: 10px; background: #fff7ef; border: 1px dashed #ff9f4a;
               border-radius: 8px; padding: 8px 12px; margin-top: 6px; }
    .ed-ussd code { font-size: 1.15rem; font-weight: 700; color: #b35500; background: none; letter-spacing: .04em; }
    .ed-etapes-paiement { counter-reset: etape; list-style: none; padding: 0; margin: 0; }
    .ed-etapes-paiement > li { counter-increment: etape; position: relative; padding: 0 0 18px 42px; }
    .ed-etapes-paiement > li::before { content: counter(etape); position: absolute; left: 0; top: 0; width: 28px; height: 28px; border-radius: 50%;
                                       background: var(--accent-paiement, #1b6b3a); color: #fff; font-weight: 700; font-size: .85rem;
                                       display: flex; align-items: center; justify-content: center; }
    .ed-etapes-paiement > li:last-child { padding-bottom: 0; }
    .ed-securite { font-size: .85rem; color: #6c757d; }

    @media (max-width: 576px) {
        .ed-frise li { font-size: .68rem; }
        .ed-carte-corps, .ed-carte-entete { padding: 14px; }
    }
</style>
