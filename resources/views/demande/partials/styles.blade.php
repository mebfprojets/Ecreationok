{{-- Styles communs à « Mes demandes », au détail d'une demande et au paiement (côté promoteur).
     Couleurs du logo MEBF : vert #1B9925 / #13731C / #0B4A12, jaune #FCE400, rouge #C51425 (comme le parcours de demande). --}}
<style>
    .ed-page {
        --mebf-vert: #1B9925; --mebf-vert-fonce: #13731C; --mebf-vert-nuit: #0B4A12; --mebf-vert-pale: #eaf6eb;
        --mebf-jaune: #FCE400; --mebf-jaune-pale: #fffbd6; --mebf-rouge: #C51425; --mebf-rouge-pale: #fdecee;
        --mebf-bordure: #e3e9e5; --mebf-fond: #f6f9f7; --mebf-texte-doux: #5b6b60;
        max-width: 1140px; margin: 32px auto 48px; padding: 0 16px;
    }
    .ed-titre { font-weight: 700; margin: 0; color: var(--mebf-vert-nuit); text-transform: none; }
    .ed-sous-titre { color: var(--mebf-texte-doux); margin: 4px 0 0; }
    .ed-page a:not(.btn) { color: var(--mebf-vert-fonce); }
    .ed-page a:not(.btn):hover { color: var(--mebf-vert-nuit); }

    /* Boutons aux couleurs du logo (les boutons Orange Money / Moov Money gardent les leurs) */
    .ed-page .btn-success { background: var(--mebf-vert); border-color: var(--mebf-vert); color: #fff; }
    .ed-page .btn-success:hover, .ed-page .btn-success:focus { background: var(--mebf-vert-fonce); border-color: var(--mebf-vert-fonce); color: #fff; }
    .ed-page .btn-outline-success { color: var(--mebf-vert-fonce); border-color: var(--mebf-vert); }
    .ed-page .btn-outline-success:hover, .ed-page .btn-outline-success:focus { background: var(--mebf-vert); border-color: var(--mebf-vert); color: #fff; }
    .ed-page .btn-warning { background: var(--mebf-jaune); border-color: #e6cf00; color: var(--mebf-vert-nuit); font-weight: 600; }
    .ed-page .btn-warning:hover, .ed-page .btn-warning:focus { background: #ecd500; border-color: #d4bd00; color: var(--mebf-vert-nuit); }
    .ed-page .btn-danger { background: var(--mebf-rouge); border-color: var(--mebf-rouge); }
    .ed-page .btn-danger:hover, .ed-page .btn-danger:focus { background: #a4101f; border-color: #a4101f; }
    .ed-page .btn-outline-danger { color: var(--mebf-rouge); border-color: var(--mebf-rouge); }
    .ed-page .btn-outline-danger:hover, .ed-page .btn-outline-danger:focus { background: var(--mebf-rouge); border-color: var(--mebf-rouge); color: #fff; }
    .ed-page .text-success { color: var(--mebf-vert) !important; }
    .ed-page .text-danger { color: var(--mebf-rouge) !important; }
    .ed-page .alert { border-radius: 10px; }
    .ed-page .alert-danger { background: var(--mebf-rouge-pale); border-color: #f3c2c8; color: #8a0f1b; }
    .ed-page .alert-warning { background: var(--mebf-jaune-pale); border-color: #f0df5c; color: #5c5000; }

    /* Cartes */
    .ed-carte { background: #fff; border: 1px solid var(--mebf-bordure); border-radius: 12px; box-shadow: 0 2px 8px rgba(11, 74, 18, .05); overflow: hidden; }
    section.ed-carte { padding: 0; } /* le thème du site ajoute 70px de marge à toutes les <section> */
    .ed-carte + .ed-carte { margin-top: 16px; }
    .ed-carte-entete { padding: 16px 20px; border-bottom: 1px solid var(--mebf-bordure); display: flex; align-items: center;
                       justify-content: space-between; gap: 12px; flex-wrap: wrap; background: linear-gradient(90deg, var(--mebf-vert-pale), #fff 70%); }
    .ed-carte-entete h2, .ed-carte-entete h3 { font-size: 1.05rem; font-weight: 700; margin: 0; text-transform: none; color: var(--mebf-vert-nuit); }
    .ed-carte-corps { padding: 18px 20px; }
    .ed-carte-pied { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: .5rem; padding: .65rem 1rem; background: var(--mebf-fond); border-top: 1px solid var(--mebf-bordure); }
    /* Liste : un liseré à gauche selon l'état de la demande */
    .ed-carte[class*="ed-etat-"] { border-left-width: 5px; }
    .ed-etat-warning { border-left-color: var(--mebf-jaune); }
    .ed-etat-info    { border-left-color: #8fd19e; }
    .ed-etat-danger  { border-left-color: var(--mebf-rouge); }
    .ed-etat-primary { border-left-color: var(--mebf-vert-fonce); }
    .ed-etat-success { border-left-color: var(--mebf-vert); }

    /* Badges d'état */
    .ed-badge { display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; font-weight: 600;
                padding: 5px 11px; border-radius: 999px; white-space: nowrap; border: 1px solid transparent; }
    .ed-badge.warning { background: var(--mebf-jaune-pale); border-color: #f0df5c; color: #5c5000; }
    .ed-badge.info    { background: var(--mebf-fond); border-color: #b9dcc0; color: var(--mebf-vert-fonce); }
    .ed-badge.danger  { background: var(--mebf-rouge-pale); border-color: #f3c2c8; color: #9b0f1d; }
    .ed-badge.success { background: var(--mebf-vert); color: #fff; }
    .ed-badge.primary { background: var(--mebf-vert-pale); border-color: #b9dcc0; color: var(--mebf-vert-nuit); }
    .ed-meta { display: flex; flex-wrap: wrap; gap: 6px 22px; color: #4a5a4f; font-size: .9rem; }
    .ed-meta i { color: var(--mebf-vert); width: 16px; }

    /* Compteurs de la liste */
    .ed-compteurs { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1.25rem; }
    .ed-compteur { display: inline-flex; align-items: center; gap: .5rem; padding: .45rem .85rem; border-radius: 10px; background: #fff;
                   border: 1px solid var(--mebf-bordure); font-size: .88rem; color: #3d4a41; }
    .ed-compteur strong { font-size: 1.05rem; color: var(--mebf-vert-nuit); }
    .ed-compteur i { color: var(--mebf-vert); }
    .ed-compteur.alerte { border-color: #f3c2c8; background: var(--mebf-rouge-pale); }
    .ed-compteur.alerte i, .ed-compteur.alerte strong { color: var(--mebf-rouge); }
    .ed-compteur.attente { border-color: #f0df5c; background: var(--mebf-jaune-pale); }
    .ed-compteur.attente i { color: #8a7a00; }

    /* Frise de suivi */
    .ed-frise { display: flex; list-style: none; padding: 0; margin: 0; }
    .ed-frise li { flex: 1; text-align: center; position: relative; font-size: .78rem; color: #8a968e; }
    .ed-frise li::before { content: ''; position: absolute; top: 13px; left: -50%; width: 100%; height: 3px; background: var(--mebf-bordure); z-index: 0; }
    .ed-frise li:first-child::before { display: none; }
    .ed-frise .rond { position: relative; z-index: 1; width: 28px; height: 28px; border-radius: 50%; margin: 0 auto 6px;
                      display: flex; align-items: center; justify-content: center; background: #dfe6e1; color: #5b6b60; font-size: .8rem; font-weight: 700; }
    .ed-frise li.fait { color: var(--mebf-vert-fonce); }
    .ed-frise li.fait .rond, .ed-frise li.fait::before, .ed-frise li.encours::before, .ed-frise li.erreur::before { background: var(--mebf-vert); color: #fff; }
    .ed-frise li.encours { color: var(--mebf-vert-nuit); font-weight: 700; }
    .ed-frise li.encours .rond { background: var(--mebf-jaune); color: var(--mebf-vert-nuit); box-shadow: 0 0 0 4px rgba(252, 228, 0, .35); }
    .ed-frise li.erreur { color: var(--mebf-rouge); font-weight: 700; }
    .ed-frise li.erreur .rond { background: var(--mebf-rouge); color: #fff; box-shadow: 0 0 0 4px rgba(197, 20, 37, .18); }

    /* Lecture des informations */
    .ed-infos { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 14px 24px; margin: 0; }
    .ed-infos dt { font-size: .76rem; text-transform: uppercase; letter-spacing: .03em; color: #6b7a70; font-weight: 700; }
    .ed-infos dd { margin: 3px 0 0; color: #1f2a22; font-weight: 600; word-break: break-word; }

    /* Rubriques : un fond léger et une couleur d'accent par bloc, dans la palette du logo */
    .ed-rubrique { border-radius: 10px; padding: 14px 16px 16px; border-left: 4px solid var(--accent); background: var(--fond); }
    .ed-rubrique + .ed-rubrique { margin-top: 14px; }
    .ed-rubrique-titre { font-size: .95rem; font-weight: 700; margin: 0 0 12px; color: var(--accent); text-transform: none; }
    .ed-rubrique-titre i { margin-right: 6px; }
    .ed-rubrique-identite    { --fond: #eef7ef; --accent: #13731C; }
    .ed-rubrique-activite    { --fond: #fffbe3; --accent: #7a6c00; }
    .ed-rubrique-siege       { --fond: #f2f6f3; --accent: #0B4A12; }
    .ed-rubrique-capital     { --fond: #fffbe3; --accent: #7a6c00; }
    .ed-rubrique-personne    { --fond: #eef7ef; --accent: #13731C; }
    .ed-rubrique-coordonnees { --fond: #fffbe3; --accent: #7a6c00; }
    .ed-infos .large { grid-column: 1 / -1; }
    .ed-vide { color: #9aa69e; font-style: italic; font-weight: 400; }
    .ed-page textarea.form-control { min-height: 110px; height: auto; } /* le thème fixe la hauteur des champs */
    .ed-page .form-control:focus, .ed-page .form-select:focus { border-color: var(--mebf-vert); box-shadow: 0 0 0 .2rem rgba(27, 153, 37, .2); }

    /* Rejet */
    .ed-rejet { border: 1px solid #f3c2c8; border-left: 5px solid var(--mebf-rouge); background: #fff8f8; }
    .ed-rejet .ed-carte-entete { background: linear-gradient(90deg, var(--mebf-rouge-pale), #fff8f8 70%); border-bottom-color: #f6d3d7; }
    .ed-rejet .ed-carte-entete h2 { color: var(--mebf-rouge); }
    .ed-rejet .motif { background: #fff; border: 1px dashed #e5a5ad; border-radius: 8px; padding: 12px 14px; white-space: pre-line; }
    .ed-etapes-correction { counter-reset: etape; list-style: none; padding: 0; margin: 14px 0 0; }
    .ed-etapes-correction li { counter-increment: etape; position: relative; padding: 0 0 10px 36px; }
    .ed-etapes-correction li::before { content: counter(etape); position: absolute; left: 0; top: 0; width: 24px; height: 24px;
                                       border-radius: 50%; background: var(--mebf-rouge); color: #fff; font-size: .8rem; font-weight: 700;
                                       display: flex; align-items: center; justify-content: center; }

    /* Historique */
    .ed-historique { list-style: none; padding: 0; margin: 0; }
    .ed-historique li { position: relative; padding: 0 0 14px 26px; border-left: 2px solid var(--mebf-bordure); margin-left: 8px; }
    .ed-historique li:last-child { border-left-color: transparent; padding-bottom: 0; }
    .ed-historique li::before { content: ''; position: absolute; left: -7px; top: 3px; width: 12px; height: 12px; border-radius: 50%;
                                background: var(--mebf-vert); box-shadow: 0 0 0 3px var(--mebf-vert-pale); }
    .ed-historique li.rejet::before { background: var(--mebf-rouge); box-shadow: 0 0 0 3px var(--mebf-rouge-pale); }
    .ed-historique .date { font-size: .8rem; color: #8a968e; }

    /* Pièces jointes */
    .ed-pieces { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 12px; }
    .ed-piece { display: flex; align-items: center; gap: 12px; border: 1px solid var(--mebf-bordure); border-left: 4px solid var(--mebf-vert);
                border-radius: 10px; padding: 10px 12px; background: #fff; }
    .ed-piece .icone { font-size: 1.4rem; color: var(--mebf-rouge); }
    .ed-piece .nom { flex: 1; font-weight: 600; font-size: .9rem; color: #1f2a22; }

    /* Paiement */
    .ed-page-etroite { max-width: 900px; }
    .ed-montant .libelle { font-size: .8rem; text-transform: uppercase; letter-spacing: .03em; color: #6b7a70; font-weight: 700; }
    .ed-montant .valeur { font-size: 1.7rem; font-weight: 800; color: var(--mebf-vert-fonce); line-height: 1.2; }
    .ed-paiement-option { height: 100%; display: flex; flex-direction: column; align-items: center; text-align: center;
                          padding: 22px 18px; border: 2px solid var(--mebf-bordure); border-radius: 12px; background: #fff; transition: border-color .15s, box-shadow .15s; }
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
                                       background: var(--accent-paiement, var(--mebf-vert-fonce)); color: #fff; font-weight: 700; font-size: .85rem;
                                       display: flex; align-items: center; justify-content: center; }
    .ed-etapes-paiement > li:last-child { padding-bottom: 0; }
    .ed-securite { font-size: .85rem; color: #6c757d; }

    @media (max-width: 576px) {
        .ed-frise li { font-size: .68rem; }
        .ed-carte-corps, .ed-carte-entete { padding: 14px; }
    }
</style>
