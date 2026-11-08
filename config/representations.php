<?php

/*
|--------------------------------------------------------------------------
| Représentations CEFORE / CEFAC (page « Contacts » du site public)
|--------------------------------------------------------------------------
|
| Reprises de la section « Représentations CEFORE/CEFAC » du site www.me.bf (relevé du 08/11/2026).
| Téléphones au format burkinabè (8 chiffres), sans l'indicatif +226 qui est ajouté à l'affichage.
| Le siège (Ouagadougou) est affiché à part, en tête de page.
|
*/

return [

    'siege' => [
        'ville' => 'Ouagadougou',
        'adresse' => 'Siège de la Maison de l’Entreprise du Burkina Faso, 132, Avenue de Lyon, 11 BP 379 Ouaga 11',
        'telephones' => ['25 39 80 58', '25 39 80 60'],
    ],

    // Assistance de la plateforme e-Création (numéros affichés dans l'en-tête du site)
    'assistance' => [
        'telephones' => ['02 21 21 21', '58 80 77 77', '56 62 02 02'],
    ],

    'regions' => [
        ['ville' => 'Bagré', 'adresse' => 'En face de la station ACCESS OIL, même alignement que la Gendarmerie', 'telephones' => ['24 71 40 64', '73 87 40 23']],
        ['ville' => 'Bobo-Dioulasso', 'adresse' => 'Délégation Régionale de la Chambre de Commerce des Hauts-Bassins, secteur 01, avenue du Gouverneur Binger', 'telephones' => ['72 66 55 93', '20 98 20 30']],
        ['ville' => 'Banfora', 'adresse' => 'Délégation Consulaire Régionale des Cascades, secteur 15, Tatana', 'telephones' => ['51 99 56 79']],
        ['ville' => 'Dédougou', 'adresse' => 'Délégation Régionale de la Chambre de Commerce de la Boucle du Mouhoun, après la salle polyvalente, route de Tougan', 'telephones' => ['60 42 39 22']],
        ['ville' => 'Koudougou', 'adresse' => 'Délégation Régionale Consulaire du Centre-Ouest, non loin de l’hôtel Splendide', 'telephones' => ['61 29 41 52']],
        ['ville' => 'Kaya', 'adresse' => 'Délégation Régionale de la Chambre de Commerce du Centre-Nord, secteur 04, non loin du centre de santé Ephraïm', 'telephones' => ['52 93 22 00']],
        ['ville' => 'Tenkodogo', 'adresse' => 'Centre d’Incubation Féminin et Entreprenariat Agricole (CIFEA), secteur 06', 'telephones' => ['53 18 47 27']],
        ['ville' => 'Manga', 'adresse' => 'Délégation Consulaire Régionale du Centre-Sud, secteur 04, derrière la station PETROFA', 'telephones' => ['53 67 06 60']],
        ['ville' => 'Ziniaré', 'adresse' => 'Délégation Régionale de la Chambre de Commerce du Plateau Central, face route nationale 3', 'telephones' => ['72 21 87 32']],
        ['ville' => 'Ouahigouya', 'adresse' => 'Délégation Consulaire Régionale du Nord, secteur 01, Souly, face à la Nation 2', 'telephones' => ['24 55 25 00', '71 80 64 21']],
        ['ville' => 'Dori', 'adresse' => 'Délégation Consulaire Régionale du Sahel, côté sud de la Direction Régionale de l’Environnement', 'telephones' => ['51 12 19 01']],
        ['ville' => 'Gaoua', 'adresse' => 'Délégation Régionale de la Chambre de Commerce du Sud-Ouest, secteur 01, non loin de la gare principale, à côté du siège de la BNSP en construction', 'telephones' => ['71 60 78 07']],
        ['ville' => 'Fada N’Gourma', 'adresse' => 'Délégation Régionale de la Chambre de Commerce, secteur 6, côté sud du Bâtiment Administratif', 'telephones' => ['60 07 08 33']],
        ['ville' => 'Koupéla', 'adresse' => 'Délégation Régionale de la Chambre de Commerce du Centre-Est, avenue Mamounata Vélégda, route Saint Camille', 'telephones' => ['52 60 73 13']],
    ],

];
