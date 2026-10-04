# SAE développement web PHP

### Statut du projet & Qualité
[![CI](https://github.com/QuiEstCe-IUT/BUT-R3.01-SAE/actions/workflows/ci.yml/badge.svg)](https://github.com/QuiEstCe-IUT/BUT-R3.01-SAE/actions/workflows/ci.yml)
[![Deploy](https://github.com/QuiEstCe-IUT/BUT-R3.01-SAE/actions/workflows/deploy.yml/badge.svg)](https://github.com/QuiEstCe-IUT/BUT-R3.01-SAE/actions/workflows/deploy.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=QuiEstCe-IUT_BUT-R3.01-SAE&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=QuiEstCe-IUT_BUT-R3.01-SAE)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=QuiEstCe-IUT_BUT-R3.01-SAE&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=QuiEstCe-IUT_BUT-R3.01-SAE)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=QuiEstCe-IUT_BUT-R3.01-SAE&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=QuiEstCe-IUT_BUT-R3.01-SAE)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=QuiEstCe-IUT_BUT-R3.01-SAE&metric=bugs)](https://sonarcloud.io/summary/new_code?id=QuiEstCe-IUT_BUT-R3.01-SAE)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=QuiEstCe-IUT_BUT-R3.01-SAE&metric=coverage)](https://sonarcloud.io/summary/new_code?id=QuiEstCe-IUT_BUT-R3.01-SAE)
![Last Commit](https://img.shields.io/github/last-commit/QuiEstCe-IUT/BUT-R3.01-SAE?style=flat)

> Site déployé : **https://mathiasm.alwaysdata.net**
> 
> Documentation : **https://quiestce-iut.github.io/BUT-R3.01-SAE/**
### Technologie
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-4169E1?style=flat&logo=postgresql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)
![Sass / SCSS](https://img.shields.io/badge/SCSS-CC6699?style=flat&logo=sass&logoColor=white)
![GitHub Actions](https://img.shields.io/badge/GitHub%20Actions-2088FF?style=flat&logo=githubactions&logoColor=white)
![SonarQube Cloud](https://img.shields.io/badge/SonarQube%20Cloud-F3702A?style=flat&logo=sonarqubecloud&logoColor=white)
![Repo Size](https://img.shields.io/github/repo-size/QuiEstCe-IUT/BUT-R3.01-SAE?style=flat-square&logo=github&logoColor=white)

## Équipe de réalisation

![Contributors](https://img.shields.io/github/contributors/QuiEstCe-IUT/BUT-R3.01-SAE?style=flat&color=blue)
- Audren METERY-DROUIN [![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/AmadeusTdev)
- Mathias MALLET [![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/eabc2318)
- Lauriol-Torcq Mathis [![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/Mathis-LAURIOL-TORCQ)
- Vinh Tan Thomas Nguyen [![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/Nguyen-Thomas1)
- Lucas Franceschi--Pinson [![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/FRANCESCHI-PINSON-Lucas-25008772)

## Architecture

```text
.
├── .github
│   └── workflows
│       ├── ci.yml          # Qualité : PHPStan, PHPCS, PHPUnit, audit, SonarQube Cloud
│       └── deploy.yml      # Déploiement automatique vers AlwaysData (sur push main)
├── _assets
│   ├── includes            # Autoloader et includes PHP internes
│   └── utils                # Fonctions utilitaires PHP
├── config
│   ├── database.example.php # Modèle à copier en config/database.php (non versionné)
│   └── database.php         # Identifiants réels, IGNORÉ par Git
├── database
│   └── dump.sql
├── kernel
│   └── model.php            # Classe Model abstraite : connexion PDO/PostgreSQL partagée
├── public                   # Unique répertoire exposé sur le Web (document root)
│   ├── assets
│   ├── favicon.ico
│   └── index.php            # Routeur central
├── src
│   ├── controllers
│   ├── models
│   └── views
├── tests
│   ├── bootstrap.php        # Charge l'autoloader Composer + l'autoloader maison pour PHPUnit
│   └── SmokeTest.php
├── .gitignore
├── composer.json
├── composer.lock
├── phpcs.xml                 # Norme PSR-12
├── phpstan.neon               # Analyse statique
├── phpunit.xml
├── sonar-project.properties
└── README.md
```

> `vendor/`, `config/database.php` et `coverage/` ne sont pas versionnés : voir [Installation locale](#installation-locale).

## Installation locale

**Prérequis :** PHP 8.3, [Composer](https://getcomposer.org/), un serveur PostgreSQL (local ou accès à celui de dev/prod, voir équipe).

```bash
git clone https://github.com/QuiEstCe-IUT/BUT-R3.01-SAE.git
cd BUT-R3.01-SAE
composer install
cp config/database.example.php config/database.php
# éditer config/database.php avec vos identifiants (jamais commité)
php -S localhost:8000 -t public
```

Le site est alors accessible sur `http://localhost:8000`.

## Pages et conventions

**Pages de l'application**
- `public/index.php` : routeur, relie controllers / views / models entre eux
- `src/views/` : vues (HTML)
- `_assets/styles/` (ou `public/assets/styles/`) : apparence des vues (CSS/SCSS)
- `src/controllers/` : logique de chaque page
- `src/models/` : requêtes SQL

**Pages disponibles**

| Nom de page | Rôle |
|---|---|
| `home` | Page d'accueil |
| `login` | Authentification (connexion) |
| `signUp` | Inscription |
| `forgottenPwd` | Mot de passe oublié |
| `legalNotice` | Mentions légales |
| `map` | Plan du site |

> Les noms de pages ont été renommés en anglais au cours du projet (`accueil` → `home`, `authentification` → `login`, `inscription` → `signUp`), conformément à la convention de nommage du sujet. Vérifiez que la liste blanche de routes dans `public/index.php` reflète bien ces noms.

**Nommage des fichiers**

Pour chaque page : `nameController` (PHP) / `nameView` (PHP) / `nameModel` (SQL) / `nameStyle` (CSS). Exemple pour la page `login` : `loginController.php`, `loginView.php`, `loginModel.php`, `loginStyle.css`.

**Noyau**

`kernel/model.php` : classe abstraite `Model`, gère la connexion PDO/PostgreSQL partagée, dont héritent tous les modèles. Les identifiants sont lus depuis `config/database.php` (jamais codés en dur, jamais commités).

**Wip**

Pour changer de page : `header('Location: index.php?action=accueil');`
Pour qu'un bouton redirige vers le routeur + choisir la page : `<a href="index.php?action=profil">Aller au profil</a>`
> ⚠️ À vérifier/actualiser : ce paramètre doit correspondre exactement à celui lu par `public/index.php` (`$_GET[...]`) et aux noms de pages ci-dessus.

## Qualité de code (en local)

Avant tout push, vérifiez que ces trois commandes passent :

```bash
composer cs     # PHP_CodeSniffer — norme PSR-12
composer stan   # PHPStan — analyse statique
composer test   # PHPUnit — tests unitaires
```

`composer test` s'appuie sur `tests/bootstrap.php`, qui charge l'autoloader Composer (`vendor/autoload.php`) et l'autoloader du projet (`_assets/includes/autoloader.php`), de façon à ce que les classes du projet soient utilisables dans les tests indépendamment du dossier d'exécution.

## CI/CD

Le projet est intégré à une chaîne CI/CD complète sur GitHub Actions, avec déploiement automatique sur AlwaysData.

### Modèle de branches

```
feature/* ──PR + CI──▶ dev ──PR + review + CI + Sonar──▶ main ──déploiement auto──▶ AlwaysData
```

- **`feature/*`** : une branche par fonctionnalité/correctif (`git checkout -b feature/nom` ou `fix/nom`), voir [Workflow de développement](#workflow-de-développement).
- **`dev`** : branche d'intégration, branche par défaut du dépôt. Protégée : PR + 1 review + CI (`quality`) obligatoires avant merge.
- **`main`** : branche de production. Mêmes protections que `dev`. Chaque merge déclenche un déploiement réel vers AlwaysData.

### `.github/workflows/ci.yml`

Déclenché sur chaque Pull Request (vers `dev` ou `main`) et sur chaque push vers `dev`. Étapes :

1. Installation des dépendances (`composer install`)
2. Validation de `composer.json` (`composer validate`)
3. Audit de sécurité des dépendances (`composer audit`)
4. Normes de code — PHP_CodeSniffer (PSR-12)
5. Analyse statique — PHPStan
6. Tests unitaires — PHPUnit, avec rapport de couverture
7. Analyse qualité et sécurité — SonarQube Cloud (sauté lors d'un déploiement direct sur `main`)

### `.github/workflows/deploy.yml`

Déclenché uniquement sur un push vers `main` (donc après une PR `dev → main` mergée) :

1. Relance la CI ci-dessus (`workflow_call`) — aucun déploiement n'a lieu si elle échoue
2. `composer install --no-dev --optimize-autoloader`
3. Connexion SSH via une clé dédiée au déploiement (pas une clé personnelle)
4. Synchronisation (`rsync`) du projet vers AlwaysData, à l'exclusion des fichiers de développement et de `config/database.php` (jamais écrasé ni supprimé en production)
5. Vérification (*smoke test*) que les répertoires internes (`kernel/`, `src/`, `database/`, `tests/`) ne sont pas accessibles publiquement

### Secrets GitHub utilisés

Configurés dans *Settings > Secrets and variables > Actions* :

| Secret | Usage |
|---|---|
| `SONAR_TOKEN` | Authentification SonarQube Cloud |
| `ALWAYSDATA_SSH_KEY` | Clé privée SSH dédiée au déploiement |
| `ALWAYSDATA_KNOWN_HOSTS` | Empreinte du serveur AlwaysData |
| `ALWAYSDATA_USER` | Utilisateur SSH dédié au déploiement |
| `ALWAYSDATA_HOST` | Hôte SSH AlwaysData (`ssh-mathiasm.alwaysdata.net`) |

### Sécurité et bonnes pratiques appliquées

- Identifiants de base de données externalisés dans `config/database.php`, ignoré par Git (jamais commité, jamais écrasé par le déploiement)
- Clé SSH de déploiement dédiée, distincte des accès personnels (principe du moindre privilège)
- `public/` est l'unique répertoire exposé sur le Web ; `kernel/`, `src/`, `database/`, `tests/`, `vendor/` sont hors du document root et vérifiés inaccessibles après chaque déploiement
- Erreurs de connexion à la base journalisées côté serveur (`error_log`), jamais affichées au visiteur
- Révision obligatoire (1 approbation) et CI verte requises avant tout merge vers `dev` ou `main`

## Workflow de développement

1. Créer une branche et s'y déplacer : `git checkout -b TYPE/nom` (ex. `fix/readme` ou `feature/loginController`), à partir de `dev`
2. Coder la fonctionnalité ou le correctif
3. Vérifier en local : `composer cs`, `composer stan`, `composer test`
4. Commit : `git add .` puis `git commit -m "description"`
5. Push : `git push --set-upstream origin TYPE/nom`
6. Créer une Pull Request vers `dev` depuis GitHub
7. Attendre que la CI passe et obtenir une review
8. Merge depuis GitHub

## Figma et tâches à faire (WIP)

- [Consulter l'interface sur Figma](https://www.figma.com/site/8oDWB7jazMQrtPeLXBzpkZ/Maquette-Qui-est-ce?node-id=0-1&p=f&t=6JdjGxCOOWHijIBQ-0)
