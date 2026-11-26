<?php

/*
 * Tarifs des demandes (les montants de base sont dans la table montant_demandes).
 *
 * IFU non facturé : pour les entreprises des provinces listées dans le paramètre 19 (« Localités dont le IFU n'est pas
 * pris en compte » : BAZEGA et GANZOURGOU, rattachées au CEFORE OUA), le coût de l'IFU est retiré de la colonne montant,
 * puis les 2 % de frais sont recalculés et ajoutés (DemandeController::calculerMontant).
 * Lus ici, et non par env() dans le contrôleur : après « php artisan config:cache », env() renvoie null hors des fichiers
 * de config, et la remise valait alors 0 (IFU facturé).
 */
return [
    'ifu_non_facture' => [
        'personne_physique' => (int) env('montant_individuel_ss_ifu', 5000),
        'personne_morale' => (int) env('montant_societaire_ss_ifu', 7500),
    ],
];
