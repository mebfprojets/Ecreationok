---
name: deploiement
description: Met à jour DEPLOIEMENT.md (procédure de mise en production d'e-Création) pour qu'il reflète les dernières modifications du code — nouvelle entrée datée au § 3, migrations au § 3.1, clés .env au § 3.2, points d'attention au § 3.3, vérifications au § 2.9. À utiliser dès que l'utilisateur dit « Mets à jour DEPLOIEMENT.md », « ajoute ça au document de déploiement », « qu'est-ce que je dois faire en prod ? », ou s'apprête à déployer une modification qui n'y figure pas encore, même s'il ne nomme pas le fichier.
---

# Mettre à jour DEPLOIEMENT.md

`DEPLOIEMENT.md` est le seul document que suit la personne qui déploie sur le serveur de production (Windows, Apache wamp64, SQL Server).
Elle n'a pas suivi la conversation : tout ce qui change sa manière de déployer ou de vérifier doit y être, et rien d'autre.

## 1. Établir ce qui a changé

1. Lister les modifications : `git status --short` et `git diff` (y compris les fichiers non suivis), complétés par ce qui a été fait dans la conversation.
   Ignorer ce qui figure déjà dans `DEPLOIEMENT.md` : le relire avant d'écrire.
2. Pour chaque changement, répondre à ces questions (c'est ce qui décide des sections à toucher) :

| Question | Où l'écrire |
|---|---|
| Qu'est-ce qui change pour le promoteur ou l'agent ? | § 3, entrée datée |
| Nouvelle migration ? | § 3.1 (tableau et nombre dans le titre) |
| Nouvelle clé `.env`, ou valeur à changer ? | § 3.2 |
| `composer.lock` modifié ? | § 2.4 s'applique ; le signaler au § 3.3 |
| Risque, effet sur les données existantes, action irréversible, retour arrière, réglage serveur (`php.ini`, Apache) ? | § 3.3 |
| Comment vérifier en production que ça marche ? | § 2.9 |
| Volontairement laissé pour plus tard ? | § 3.4 |

Les numéros de section peuvent avoir bougé : se repérer aux titres.

## 2. Écrire

**§ 3, entrée datée.** Les entrées sont groupées par blocs datés, par exemple
« Correctifs du 9 novembre 2026 (aucune migration, aucune clé de `.env` à ajouter) : ».
- Utiliser la date du jour, en toutes lettres.
- Ajouter au bloc du jour s'il existe ; sinon en créer un.
- La parenthèse du titre doit rester vraie. Si un changement apporte une migration ou une clé `.env`, ouvrir un bloc à part dont le titre l'annonce et renvoie aux sections concernées
  (ex. « Envoi des e-mails par Microsoft 365 (9 novembre 2026, aucune migration, **clés de `.env` à ajouter**, voir § 3.2 et § 3.3) : »).
- Chaque puce dit d'abord l'effet visible (qui voit quoi, où), puis, si utile au déploiement, le nom du fichier ou de la route.
  Mentionner l'ancien comportement quand il aide à comprendre (« au lieu de `2026-10-14` »).
- Si le § 3 décrit un déploiement déjà effectué, demander à l'utilisateur s'il faut ouvrir une nouvelle section de déploiement plutôt que d'empiler.

**§ 3.2, clés `.env`.** Tableau `Clé | Valeur attendue | Si elle manque ou est fausse`. La dernière colonne décrit le symptôme observable
(« pas d'e-mail de décision… »), pour que la personne qui déploie relie un problème à sa cause.
Ne jamais écrire de valeur secrète ni d'identifiant réel (mot de passe, secret client, ID de locataire) : dire où la trouver.

**§ 3.3, points d'attention.** Une puce par sujet, le sujet en gras en tête. Y mettre ce qui peut mal tourner et comment le reconnaître :
effet sur les données existantes, fichiers supprimés par le `git pull`, réglages serveur, erreurs probables et leur cause (un petit tableau `Erreur | Cause` aide),
retour arrière. Les commandes à lancer sur le serveur vont dans un bloc `powershell` ou `bat`, depuis le dossier de l'application.

**§ 2.9, vérifications.** Compléter les étapes numérotées existantes (site public, espace agents, journal) par le contrôle concret
à faire après le déploiement : quoi ouvrir, quoi doit s'afficher, quelle table ou colonne regarder. Ne pas créer d'étape pour chaque changement.

## 3. Style

- Français, phrases courtes, termes de l'interface entre guillemets français (« Renvoyer le code »), code et chemins entre accents graves.
- Chemins Windows pour le serveur (`storage\logs\laravel.log`), chemins du dépôt avec des barres obliques (`app/Support/…`).
- Gras réservé à ce qui peut casser la production ou se perdre.
- Ne rien affirmer qui n'ait pas été vérifié : si une étape n'a été testée qu'en local, le dire.
- Ne pas réécrire les parties de la procédure qui ne sont pas concernées.

## 4. Terminer

- Ne pas commiter : l'utilisateur le fait.
- Répondre en quelques lignes : les sections modifiées et ce que chacune dit désormais, puis les fichiers restant à commiter s'il y en a.
