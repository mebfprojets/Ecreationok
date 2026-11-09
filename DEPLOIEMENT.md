# Déploiement en production — e-Création (creerentreprise.me.bf)

Procédure de mise en production depuis la branche `main`.
La première partie vaut pour chaque déploiement ; la seconde liste ce qui est propre au déploiement de novembre 2026.

Serveur : Windows, Apache (wamp64), PHP 8.1 avec le pilote SQL Server, base SQL Server.
Toutes les commandes `php` et `composer` se lancent **depuis le dossier du projet**, avec le PHP 8.1 de wamp
(celui qui contient l'extension `sqlsrv`), par exemple `C:\wamp64\bin\php\php8.1.28\php.exe`.

---

## 1. Avant de déployer (poste du développeur)

1. Tout est commité et poussé sur la branche de travail (`git status` ne montre plus rien).
2. La branche est fusionnée dans `main`, puis `main` est poussée :

   ```bash
   git checkout main
   git merge <branche>
   git push origin main
   ```

---

## 2. Procédure de mise en production (serveur)

### 2.1 Sauvegardes

- Base de données SQL Server (sauvegarde complète).
- Fichier `.env` du serveur.
- Dossier `storage\app` (pièces jointes, signatures, formalités) si le déploiement touche aux fichiers.

### 2.2 Maintenance

```bash
php artisan down
```

### 2.3 Récupération du code

> **Attention au `.env` (déploiement de novembre 2026 et tout serveur encore sur un ancien `main`)** :
> le fichier `.env` était suivi par git dans les anciennes versions de `main` et ne l'est plus.
> Le `git pull` qui apporte ce changement **supprime le `.env` du serveur** (ou refuse de s'exécuter si le fichier a été modifié).
> Copier le `.env` **hors du dossier du projet** avant le `pull`, puis le remettre en place :
>
> ```bat
> copy .env ..\env-production-sauvegarde.txt
> ```
>
> Si `git pull` refuse à cause de modifications locales du `.env` (la copie ci-dessus étant faite) :
>
> ```bat
> git checkout -- .env
> ```

```bash
git pull origin main
```

Remettre ensuite le `.env` de production en place et vérifier qu'il n'apparaît plus dans `git status` (il est ignoré) :

```bat
copy ..\env-production-sauvegarde.txt .env
git status --short
```

### 2.4 Dépendances PHP (si `composer.lock` a changé)

```bash
composer install --no-dev --optimize-autoloader
```

Si une commande `php artisan` échoue ensuite avec `Class "Facade\Ignition\IgnitionServiceProvider" not found`,
le cache des paquets cite encore un paquet de développement : supprimer les deux fichiers générés puis le reconstruire.

```bat
del bootstrap\cache\packages.php bootstrap\cache\services.php
php artisan package:discover
```

### 2.5 Fichier `.env`

Comparer avec `.env.example` et ajouter les clés manquantes (voir § 3.2). Ne jamais commiter le `.env`.

### 2.6 Base de données

Toujours regarder d'abord ce qui va s'exécuter :

```bash
php artisan migrate:status
```

Si seules les migrations attendues sont « Pending » :

```bash
php artisan migrate --force
```

Si d'anciennes migrations inattendues apparaissent aussi en « Pending », ne pas lancer `migrate` seul :
passer les migrations attendues une par une avec `php artisan migrate --force --path=database/migrations/<fichier>.php`.

### 2.7 Caches

```bash
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

> Ne pas lancer `php artisan route:cache` : `routes/api.php` contient une route définie par une fonction anonyme,
> ce que Laravel 8 ne sait pas mettre en cache.

### 2.8 Remise en service

```bash
php artisan up
```

### 2.9 Vérifications

1. Contrôles de sécurité (rapport horodaté enregistré dans `scripts\`) :

   ```powershell
   powershell -ExecutionPolicy Bypass -File .\scripts\verifier-recommandations-anssi.ps1 -SansPorts
   ```

   Le contrôle des ports (sans `-SansPorts`) se lance depuis un réseau extérieur (4G, autre fournisseur).

2. Site public : accueil (ni bandeau de maintenance ni bouton « Vérifier un nom commercial » dans l'en-tête), page Contacts,
   inscription (code reçu par e-mail ; dans la base, `created_at` et `email_verified_at` du nouveau compte ont une heure, pas `00:00:00`),
   connexion, mot de passe oublié, formulaire « Enregistrement du promoteur » (pied de page en bas de l'écran, fenêtre de confirmation),
   formulaire de demande (bouton « Ajouter usager ») **enregistré jusqu'au bout avec une demande de test** : la page suivante s'affiche
   et le fichier `signature.png` est créé dans `storage\app\public\files\<id du promoteur>\`.
3. Espace agents : tableau de bord, une liste avec un filtre de période, détail d'une demande (aperçu des pièces,
   rubrique « Activité du promoteur » avec ses onglets Parcours, Connexions et E-mails), validation et rejet d'une demande de test (l'e-mail doit partir).
4. Journal des erreurs : `storage\logs\laravel.log` ne doit pas contenir de nouvelle erreur.

### 2.10 En cas de problème

- Remettre le site en maintenance (`php artisan down`), revenir au commit précédent (`git checkout <commit>`),
  vider les caches (§ 2.7), puis `php artisan up`.
- Les migrations de ce déploiement ne modifient aucune donnée existante (création de tables et d'index, ajout de colonnes) :
  l'ancien code continue de fonctionner avec la base migrée.

---

## 3. Déploiement de novembre 2026 (branche `barro`)

Contenu : corrections ANSSI, espace agents AdminLTE 4 / Bootstrap 5.3, tableau de bord (indicateurs, période,
décisions par agent), listes paginées côté serveur avec filtre de période, page de traitement des demandes,
historique des e-mails et activité des promoteurs, reprise de signature, réinitialisation des comptes agents,
refonte des pages publiques (accueil, parcours de demande, Contacts).

Compléments du 8 novembre 2026 :

- Bandeau « Maintenance en cours » retiré de l'en-tête public, avec le réglage `maintenance_banner` de `config/app.php`.
- Bouton « Vérifier un nom commercial » retiré de l'en-tête (la vérification reste dans la carte « Avant de commencer » de l'accueil).
- Formulaire « Enregistrement du promoteur » (`/create/usager`) : pied de formulaire refait, fenêtre de confirmation revue,
  ancien formulaire « personne morale » caché supprimé. La page s'affichait en mode dégradé (pied de page étiré, grande zone vide).
- Formulaire de demande : les boutons « Ajouter usager » / « Créer Dirigeant » ouvrent de nouveau la fenêtre de création d'usager.
- Table `users` : `created_at`, `updated_at` et `email_verified_at` sont de nouveau enregistrés avec l'heure (voir § 3.3).

Correctifs du 9 novembre 2026 (aucune migration, aucune clé de `.env` à ajouter) :

- **Enregistrement des demandes rétabli** : depuis l'ajout de la reprise de signature, toute création de demande échouait avec le message
  « La demande n’a pas pu être enregistrée… » (erreur `must be of type App\Models\Usager, stdClass given` dans `storage\logs\laravel.log`).
- Fichier de signature : de nouveau nommé `signature.png` dans `storage\app\public\files\<id du promoteur>\`
  (au lieu de `signature-<date>-<aléatoire>.png`).

### 3.1 Migrations attendues (5)

| Migration | Effet |
|---|---|
| `2026_10_29_150000_create_journal_actions_table` | Journal des actions des agents, rempli avec l'historique des validations et des rejets (peut prendre un moment) |
| `2026_10_29_170000_add_index_colonnes_liaison` | Index sur les colonnes de liaison (accélère les listes) |
| `2026_10_31_090000_add_vu_promoteur_le_to_journal_actions` | Notifications « Nouveau » des promoteurs |
| `2026_10_31_100000_create_activites_promoteur_table` | Connexions et modifications faites par les promoteurs |
| `2026_10_31_120000_create_envois_mail_table` | Historique des e-mails envoyés |

### 3.2 Clés du `.env` à vérifier ou ajouter

| Clé | Valeur attendue | Si elle manque ou est fausse |
|---|---|---|
| `APP_ENV` | `production` | — |
| `APP_DEBUG` | `false` | erreurs détaillées affichées (ANSSI Vul-001) |
| `APP_URL` | `https://creerentreprise.me.bf` | liens erronés dans les e-mails, en-tête Host non filtré (Vul-005) |
| `SESSION_SECURE_COOKIE` | `true` | cookies sans attribut Secure (Vul-006) |
| `CSP_MODE` | `enforce` | la CSP n'est envoyée qu'en observation (rapport de suivi ANSSI) |
| `FNRCCM_URL`, `FNRCCM_UTILISATEUR`, `FNRCCM_MOT_DE_PASSE` | identifiants de l'API du Fichier national RCCM | « Vérifier un nom commercial » répond « momentanément indisponible » |
| `FNRCCM_VERIFIER_SSL` | `true` | — |
| `FNRCCM_API_CLE` et/ou `FNRCCM_API_IPS` | clé longue et aléatoire (transmise au FNRCCM, en-tête `X-Api-Key`) et/ou adresses IP du FNRCCM | **le FNRCCM ne peut plus consulter `/api/fnrccm` (erreur 403)** |
| `MAIL_*` | serveur SMTP de production | pas d'e-mail de décision, de code d'inscription ni de réinitialisation |
| `SESSION_INACTIVITE_AGENTS` | `30` (minutes) | valeur par défaut : 30 |
| `AUTH_REMEMBER_MINUTES` | `10080` (7 jours) | valeur par défaut : 7 jours |
| `MAINTENANCE_BANNER` | à supprimer | sans effet : le bandeau n'existe plus |

`CSP_MODE=enforce` a été testé sur l'ensemble des pages en local. Si une page devait se bloquer en production,
passer temporairement `CSP_MODE=report`, puis `php artisan config:cache`, et signaler la page.

### 3.3 Points d'attention

- **`.env` : le `git pull` le supprime** (il n'est plus suivi par git) : appliquer la sauvegarde puis la remise en place décrites au § 2.3.
  Le même problème touche tout poste de développement qui passe de l'ancien `main` à une version récente.
- **Secrets dans l'historique git** : d'anciennes versions du `.env` (avec le mot de passe SQL Server, celui de la messagerie,
  les accès à l'API Moov et la clé `APP_KEY`) restent dans l'historique du dépôt. Changer ces mots de passe, et désactiver
  le compte `sa` au profit d'un compte applicatif aux droits limités (ANSSI Vul-003). Pour `APP_KEY`, voir avant de la changer :
  elle invalide les sessions ouvertes et les données chiffrées avec l'ancienne clé.
- **`public\upload` : sauvegarder ce dossier avant le `git pull`.** Les 224 images de signatures qu'il contenait
  (accessibles sans connexion, ANSSI Vul-009) sont retirées du dépôt : le `git pull` les supprime du serveur.
  Elles restent récupérables dans l'historique git.
- **Dates de la table `users`** : les colonnes sont déjà de type `datetime`, mais le modèle `User` n'envoyait que la date
  (redéfinition de `getDateFormat()` en `'Y-d-m'`, supprimée) : tous les comptes existants sont à `00:00:00`.
  **Aucune migration** : la correction est dans le code et s'applique dès le `git pull`. Les nouveaux comptes et les
  mises à jour gardent l'heure ; les heures déjà perdues ne sont pas récupérables (les dates restent justes).
- **Demandes refusées avant le correctif du 9 novembre** : l'échec survenait avant toute écriture de la demande ; rien n'est enregistré à moitié
  et les pièces déposées sont conservées. Les promoteurs concernés doivent simplement renvoyer leur demande une fois le correctif déployé.
- **Signature : un seul fichier par promoteur.** Le nom étant fixe, une nouvelle demande ou une reprise de signature remplace le fichier `signature.png`
  précédent, et toutes les demandes du promoteur qui pointent vers ce fichier affichent la dernière signature.
  Les fichiers déjà créés sous l'ancien nom (`signature-<date>-<aléatoire>.png`) restent valables : leur chemin est enregistré en base.
- Dépendances : `composer.lock` contient des mises à jour mineures, donc `composer install` est nécessaire (§ 2.4).
- Pages publiques retirées : les anciennes vues Jetstream et les modèles inutilisés ont été supprimés.
  Les adresses `/admin` et `/dash` n'existent plus (ANSSI Vul-004).
- Les en-têtes de sécurité (HSTS, X-Frame-Options, nosniff, version masquée) restent configurés dans Apache :
  ne pas les retirer de `httpd.conf`.

### 3.4 Hors de ce déploiement

- Pare-feu : ports 21, 22, 135, 139, 445, 1433, 3306 et 5985 encore ouverts sur Internet au 27/10/2026 (ANSSI Vul-003).
- Montée de version de Laravel 8 et de PHP 8.1, qui ne sont plus maintenus (ANSSI Vul-007 ; `composer audit` signale
  des failles corrigées seulement dans les versions récentes).
