![EcoloCoach Banner](public/uploads/readme/banner.webp)

# EcoloCoach 🌿

Une application web ludique, interactive et bienveillante, conçue pour accompagner
les français dans leur transition écologique, sans contrainte ni culpabilité.

---

## 💡 À propos du projet

### Contexte de développement

Ce projet a été entièrement pensé, conçu et développé dans le cadre de ma
**première année de formation en tant que Développeuse Full Stack**.

L'objectif de cet exercice était de mettre en pratique l'ensemble des compétences acquises durant l'année :
de la gestion de projet (méthodologie agile, gestion de backlog) à l'implémentation technique
(frontEnd, backEnd, base de données), tout en intégrant des notions essentielles
d'**éco-conception** et d'**accessibilité**.

L'application présentée ici est un **MVP (Produit Minimum Viable)** destiné à évoluer de manière itérative.

### La Problématique

Selon l'ADEME (agence de la transition écologique), **90 % des Français** se disent préoccupés par les questions
environnementales. Pourtant, seuls **20 à 25 %** d'entre eux parviennent à adapter significativement
leur mode de vie au quotidien.

### La Solution : EcoloCoach

**EcoloCoach** a été créé pour accompagner pas à pas et sans contrainte ces français dans leur transition écologique.

En m'inspirant des mécaniques d'apprentissage ludiques et de la *gamification* (popularisées par des applications
comme Duolingo), l'application propose un accompagnement individuel, pas à pas.
Elle décompose un grand objectif global en petites actions quotidiennes, concrètes et mesurables.

Ma philosophie repose sur un pilier central indispensable à la réussite de l'utilisateur :
**100 % d'encouragement, 0 % de culpabilisation**.

---

## ✨ Fonctionnalités de l'application

### Fonctionnalités actuelles

La version actuelle de l'application se concentre sur l'essentiel de l'expérience individuelle
pour valider les bases techniques et pédagogiques du concept :

* **Parcours d'accompagnement :** Accès à des sessions d'apprentissage composées de quiz interactifs
  pour assimiler les enjeux environnementaux de manière ludique et à son propre rythme.
* **Défis concrets du quotidien :** Proposition de challenges pratiques et réalistes (adaptés au niveau de
  l'utilisateur) pour passer facilement de la théorie à l'action.
* **Calcul et visualisation de l'impact :** Un tableau de bord personnalisé permettant à l'utilisateur de visualiser
  son empreinte carbone évitée et de mesurer l'impact positif réel de ses nouvelles habitudes via des comparaisons
  imagées.

### Aperçu de l'application et Parcours Utilisateur

#### 1. Le Tableau de Bord (Home In-App)

Une fois connecté, l'utilisateur accède à sa page d'accueil personnalisée construite sous la forme d'un parcours
linéaire de progression (style *Duolingo*).

* **Mécanique de déblocage :** Les leçons et les défis se débloquent les uns après les autres au fur et à mesure
  de l'avancement. Tant qu'une étape n'est pas validée, les étapes suivantes restent verrouillées.
* **En-tête dynamique :** Un compteur affiche en temps réel les kilogrammes de CO2 économisés par l'utilisateur.
* **Astuces :** Au milieu de la progression d'un niveau, un bloc "Astuce" vient
  contextualiser le titre du niveau actuel suivi.
* **Navigation :** Un menu burger (`burger_menu.webp`) accessible permet de naviguer rapidement
* entre les différentes sections de l'application.

![Mon Parcours - Vue globale](public/uploads/readme/home_in_app.webp)
![Mon Parcours - Défilement et Astuce niveau](public/uploads/readme/home_in_app_scroll.webp)
![Menu de navigation](public/uploads/readme/burger_menu.webp)

#### 2. L'Espace d'Apprentissage (Leçons)

Le cœur de la sensibilisation repose sur des modules interactifs permettant de valider ses connaissances.

* **Interface Question (`lesson_question.webp`) :** Un système de quiz à choix multiples (QCM) épuré, surmonté
  d'une barre de progression visuelle pour indiquer l'avancée de la leçon en cours.
* **Interface Réponse & Pédagogie (`lesson_answer.webp`) :** Lors de la validation, un bandeau de feedback s'affiche.
  Qu'elle soit bonne ou mauvaise, chaque réponse est accompagnée d'une explication détaillée et sourcée,
  permettant d'ancrer les savoirs de manière positive.

![Interface d'une question de quiz](public/uploads/readme/lesson_question.webp)
![Explication détaillée après validation](public/uploads/readme/lesson_answer.webp)

#### 3. Les Défis du Quotidien

Passer de la théorie à la pratique se fait via des défis clairs et engageantes.

* **Consultation d'un défi (`challenge.webp`) :** Chaque défi affiche sa thématique (ex. : Transport),
  son niveau d'impact (Fort, Moyen) et l'estimation exacte des économies de CO2 associées.
* **Flexibilité totale (Sans culpabilité) :** L'utilisateur a le choix d'**Accepter** ou de **Refuser** le défi proposé.
  *Aucune pénalité :* tous les défis refusés sont réinjectés dans l'application et peuvent être réacceptés
  ultérieurement
* lorsque l'utilisateur se sentira prêt.

![Fiche détaillée d'un défi](public/uploads/readme/challenge.webp)

#### 4. Suivi de l'Impact & Éco-comparateur

La page d'impact permet de valoriser concrètement les efforts fournis par l'utilisateur.

* **Visualisation imagée (`impact_page.webp`) :** Le volume total de CO2 économisé est traduit par une comparaison
* concrète et illustrée basée sur les données du **comparateur officiel de l'ADEME**.
* **Gestion des challenges en cours :** Cette page centralise également le récapitulatif des défis acceptés.
* En cliquant sur l'un d'eux, une fenêtre surgissante (`pop_up_challenge.webp`) permet à l'utilisateur de déclarer
* le défi comme **Validé !** pour mettre à jour son score, ou de le **Quitter** s'il souhaite l'abandonner pour le
  moment.

![Page d'impact et équivalence ADEME](public/uploads/readme/impact_page.webp)
![Fenêtre contextuelle de validation d'un défi](public/uploads/readme/pop_up_challenge.webp)

### Feuille de route (Roadmap)

Pensée de manière itérative, l'application a vocation à s'enrichir prochainement de fonctionnalités axées sur le
collectif et l'ultra-personnalisation :

* **L'Écologie en équipe (Social & Gamification) :**
    * Possibilité de se connecter avec des amis.
    * Création et gestion d'équipes personnalisées.
    * Lancement de défis collectifs et collaboratifs.
    * Visualisation de l’impact écologique global et cumulé de l’équipe.

Pré-visualisation via la maquette Figma :

![Maquette Figma de la page communauté](public/uploads/readme/community_page_figma.webp)

* **Parcours sur-mesure (Quiz d'orientation) :** Intégration d'un questionnaire initial lors de la première connexion
  pour évaluer le profil, les contraintes et les habitudes ancrées de l'utilisateur, afin de l'orienter automatiquement
  vers le parcours
  d'accompagnement le plus adapté.

### Vision à long terme (Périmètre futur)

Pour garder un focus absolu sur la stabilité du MVP, certaines fonctionnalités complexes ont été volontairement
écartées de la version actuelle. Elles constituent la feuille de route à long terme pour transformer l'application
en une plateforme complète :

* **Onboarding & Accessibilité :** Intégration d'un guide interactif de l'application dès la première connexion
  pour accompagner l'utilisateur dans sa prise en main.
* **Gamification poussée :**
    * Mise en place d'une vue globale permettant la visualisation de tous les niveaux du parcours.
    * Intégration d'un système d'avancée rapide dans un parcours en fonction des habitudes déjà ancrées de
      l'utilisateur (système de test de niveau).
    * Instauration de challenges dynamiques quotidiens et hebdomadaires.
* **Social & Engagement :** Création d'un système de parrainage pour inviter ses proches et agrandir la communauté.
* **Espace Personnel & Administration :**
    * Développement d'une page de profil utilisateur complète et personnalisable.
    * Création d'un compte administrateur dédié pour la gestion, la création et la mise à jour des parcours
      d'accompagnement directement depuis l'interface.
* **Fonctionnalités géolocalisées :** Intégration d'une carte interactive répertoriant les points de tri,
  les composteurs et les commerces écoresponsables à proximité.

---

## Stack Technique

### Backend

| Technologie                                                                                                                                   |  Version   | Utilisation                     |
|:----------------------------------------------------------------------------------------------------------------------------------------------|:----------:|:--------------------------------|
| [![Symfony](https://img.shields.io/badge/Symfony-000000?style=flat-square&logo=symfony&logoColor=white)](https://symfony.com)                 | `5.17 CLI` | Framework PHP full-stack        |
| [![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net)                             |   `8.5`    | Langage backend                 |
| [![Doctrine](https://img.shields.io/badge/Doctrine-E34C26?style=flat-square&logo=doctrine&logoColor=white)](https://www.doctrine-project.org) |   `2.4`    | ORM pour abstraction BDD        |
| [![Composer](https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white)](https://getcomposer.org)          |   `2.9`    | Gestionnaire de dépendances PHP |

### Frontend

| Technologie                                                                                                                                                             | Utilisation                          |
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------|:-------------------------------------|
| [![Twig](https://img.shields.io/badge/Twig-37383A?style=flat-square&logo=twig&logoColor=white)](https://twig.symfony.com)                                               | Moteur de templates sécurisé         |
| [![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)](https://developer.mozilla.org/fr/docs/Web/CSS)                          | Variables, Grid, Flexbox, Responsive |
| [![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)](https://developer.mozilla.org/fr/docs/Web/JavaScript) | Async/Await, Modal                   |

### Base de Données

| Technologie                                                                                                                   | Justification                             |
|:------------------------------------------------------------------------------------------------------------------------------|:------------------------------------------|
| [![SQLite](https://img.shields.io/badge/SQLite-07405E?style=flat-square&logo=sqlite&logoColor=white)](https://www.sqlite.org) | SGBD relationnel léger, idéal pour un MVP |

---

### Hébergement & Infrastructure

| Technologie                                                                                                                               | Justification                                                                  |
|:------------------------------------------------------------------------------------------------------------------------------------------|:-------------------------------------------------------------------------------|
| [![Alwaysdata](https://img.shields.io/badge/Alwaysdata-0284c7?style=flat-square&logo=icloud&logoColor=white)](https://www.alwaysdata.com) | Solution PaaS française offrant un environnement managé optimisé pour Symfony. |

---

## Architecture et Choix Techniques

### Le Modèle MVC (Architecture Actuelle)

L'application repose sur le modèle de conception **MVC (Modèle-Vue-Contrôleur)** natif du framework Symfony.
Ce choix d'architecture monolithique a permis de centraliser la logique métier et de maximiser la rapidité de
développement du MVP :

* **Modèle (Model) :** Géré par l'ORM Doctrine. Les entités PHP définissent la structure des données et
  s'interfacent de manière transparente avec le fichier de base de données SQLite via des requêtes optimisées.
* **Vue (View) :** Propulsée par le moteur de templates Twig. Les pages HTML sont générées côté serveur,
  intégrant dynamiquement les données utilisateur avant d'être envoyées au navigateur.
* **Contrôleur (Controller) :** Les contrôleurs Symfony interceptent les requêtes HTTP, orchestrent l'appel aux
  services (calculs d'impact carbone, gestion du cycle de déblocage des leçons) et retournent la vue Twig appropriée.

### 🌱 Éco-conception & Numérique Responsable (Green IT)

[![Ecoindex](https://bff.ecoindex.fr/badge/?theme=light&url=https://ecolocoach.alwaysdata.net/)](https://bff.ecoindex.fr/redirect/?url=https://ecolocoach.alwaysdata.net/)

L'impact environnemental du numérique a été placé au centre des arbitrages techniques du projet.
L'application décroche une excellente note sur l'analyse **Ecoindex**, matérialisée par plusieurs choix stricts :

* **Hébergement localisé et engagé :** Le choix de la plateforme *Alwaysdata* garantit que les serveurs sont
  physiquement situés en **France**. Cela limite la distance parcourue par les paquets réseau (routage) et assure
  l'utilisation d'un mix énergétique bas-carbone.
* **Sobriété du code et des assets :**
    * Utilisation exclusive du format standard **WebP** pour les visuels, divisant le poids des images par rapport au
      PNG/JPG.
    * Intégration d'un CSS et d'un JavaScript natifs épurés, limitant le volume de fichiers à télécharger à la première
      connexion.
    * Cohérence de visuel entre la version Mobile et Desktop pour limiter les fichiers de style et donc les lignes de
      code.

---

## 🚀 Installation et Déploiement

### Accès à l'application en ligne

L'application est déployée de manière continue et accessible publiquement à l'adresse suivante :
👉 **[https://ecolocoach.alwaysdata.net/](https://ecolocoach.alwaysdata.net/)**

---

### Installation en local (Mode Développeur)

Grâce à l'utilisation de Symfony AssetMapper et de SQLite, le projet a été pensé pour être cloné
et lancé en moins de 5 minutes, sans infrastructure lourde.

#### Prérequis

* **PHP** : Version 8.4 ou supérieure
* **Composer** : Version 2.*

#### Étapes d'installation pas à pas

**1. Cloner le dépôt et se rendre dans le dossier :**

```bash
git clone [https://github.com/CDasse/ecolocoach_project.git](https://github.com/CDasse/ecolocoach_project.git)
cd ecolocoach_project
```

**2. Installer les dépendances PHP :**

```bash
composer install
```

**3. Configuration de l'environnement :**
Créez un fichier .env.local à la racine du projet en dupliquant le fichier .env.
Par défaut, la configuration SQLite est déjà prête à l'emploi. Vous n'avez aucune variable de base de données à
modifier pour un test local.

**4. Initialiser la base de données et les assets :**

```bash
# Création du fichier SQLite et exécution des migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# (Optionnel) Charger un jeu de fausses données si des fixtures sont configurées
php bin/console doctrine:fixtures:load -n

# Télécharger les dépendances front-end via AssetMapper
php bin/console importmap:install
```

**5. Lancer le serveur local :**

```bash
symfony server:start
```

L'application sera alors accessible sur http://127.0.0.1:8000.

---

### Intégration et Déploiement Continus (CI/CD)

[![Tests](https://github.com/CDasse/ecolocoach_project/actions/workflows/tests.yml/badge.svg)](https://github.com/CDasse/ecolocoach_project/actions/workflows/tests.yml)
[![Green IT](https://github.com/CDasse/ecolocoach_project/actions/workflows/green-it-analysis.yml/badge.svg)](https://github.com/CDasse/ecolocoach_project/actions/workflows/green-it-analysis.yml)
[![SonarCloud Scan](https://github.com/CDasse/ecolocoach_project/actions/workflows/sonar-analysis.yml/badge.svg)](https://github.com/CDasse/ecolocoach_project/actions/workflows/sonar-analysis.yml)
[![Package and Deploy](https://github.com/CDasse/ecolocoach_project/actions/workflows/build-artefact-and-deploy.yml/badge.svg)](https://github.com/CDasse/ecolocoach_project/actions/workflows/build-artefact-and-deploy.yml)

Afin d'automatiser entièrement le cycle de vie du code, l'application s'appuie sur une suite de 4 workflows automatisés
via GitHub Actions. Plutôt que de tout lancer en parallèle, l'infrastructure est configurée sous forme de pipeline en
cascade : chaque étape ne se déclenche que si la précédente s'est terminée avec un succès total.

```plaintext
[ Push / PR Main ]
│
▼

1. Tests Automatiques (Unitaires, E2E & accessibilité)
   │
   ▼ (si succès)
2. Analyse Éco-conception (Green IT Ecoindex >= 85)
   │
   ▼ (si succès)
3. Quality Gate & Sécurité (SonarCloud Scan)
   │
   ▼ (si succès)
4. Build de Production & Déploiement (Alwaysdata)
```

---

## 🛡️ Qualité du Code, Sécurité et Accessibilité

### Qualité du Code & Analyse Statique (Clean Code)

Afin de maintenir une base de code saine, évolutive et exempte de dette technique, l'ensemble du projet est audité
automatiquement à chaque modification.

#### La "Quality Gate" SonarCloud

Le projet utilise **SonarCloud** pour l'analyse statique du code PHP, HTML, CSS et JavaScript.

[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=ecolocoach)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=ecolocoach)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=ecolocoach)

[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=bugs&token=4edefe02594b471d481dfb7d35f7b05672910de3)](https://sonarcloud.io/summary/new_code?id=ecolocoach)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=ecolocoach)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=ecolocoach)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=ecolocoach)

[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=ecolocoach)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=ecolocoach)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=ecolocoach&metric=coverage)](https://sonarcloud.io/summary/new_code?id=ecolocoach)

#### Lancement des Tests en Local

Pour s'assurer qu'aucune régression n'est introduite lors d'une modification, vous pouvez exécuter la suite de tests
unitaires, end to end et d'accessibilité via la commande suivante :

```bash
npm run test
```

Un script bash a été rédigé afin d'implémenter la base de données fictive (via le fichier de fixtures)
avant et après les tests.

### Performances & Expérience Utilisateur

L'application atteint l'excellence sur les rapports Google Lighthouse :

![Google Lighthouse Analyse](public/uploads/readme/google_lighthouse.webp)

**Stratégie d'optimisation :** Si c'était à refaire aujourd'hui, je m'orienterais vers une architecture de type SPA
(Single Page Application, avec Vue.js ou React, couplé à une API Symfony).
Cela limiterait les rechargements serveurs, offrant beaucoup plus de dynamisme et de meilleures performances,
notamment pour les utilisateurs en connexion réduite (3G), ce qui rejoint ma démarche d'accessibilité et d'
éco-conception.

### Sécurité & Durcissement de l'Infrastructure

#### Sécurisation du Serveur de Déploiement

Pour éviter qu'une clé SSH compromise dans les secrets de GitHub ne donne un accès total au serveur d'hébergement, la
sécurité a été durcie au niveau du serveur Alwaysdata :

La clé SSH utilisée par GitHub Actions est restreinte à une seule et unique commande.

Même si un attaquant parvenait à intercepter cette clé, il lui serait strictement impossible d'ouvrir un terminal
interactif ou de parcourir les fichiers du serveur. La connexion SSH force l'exécution immédiate et exclusive du script
/home/ecolocoach/deploy.sh, limitant les droits au strict périmètre de la mise à jour applicative.

#### Sécurité Réseau & Chiffrement

L'application web est auditée via l'outil de référence Mozilla Observatory et décroche un score exceptionnel de 110 /
100 grâce à l'implémentation rigoureuse de politiques de sécurité HTTP (Headers) :

* Content Security Policy (CSP) : Restriction stricte des sources d'exécution des scripts et du chargement des styles
  pour
  bloquer les failles de type XSS (Cross-Site Scripting).

* HSTS (HTTP Strict Transport Security) : Redirection forcée en HTTPS avec interdiction absolue de repasser sur un canal
  non sécurisé.

* X-Content-Type-Options & X-Frame-Options : Protections natives contre le vol de cookies, le reniflage de types de
  fichiers (MIME sniffing) et le détournement de clics (Clickjacking).

![Mozilla observatory Analyse](public/uploads/readme/mozilla_observatory.webp)

#### Accessibilité & Inclusion

Parce que la transition écologique concerne tout le monde, l'application est conçue pour être accessible au plus grand
nombre, y compris aux personnes en situation de handicap numérique ou visuel. Les critères majeurs des référentiels WCAG
et RGAA ont été intégrés dès la phase de maquettage :

* **Contrastes des Couleurs :** Toutes les palettes de couleurs (notamment le vert thématique de l'éco-conception et les
  boutons d'action) ont été testées pour respecter un ratio de contraste minimal de 4.5:1 (exigence WCAG AA),
  garantissant
  une lisibilité parfaite pour les personnes malvoyantes ou daltoniennes.

* **Navigation au Clavier & Sémantique HTML :**
    * L'ensemble de l'interface (menus, formulaires, cartes de défis) est
      entièrement navigable à l'aide de la touche Tab du clavier.
    * L'utilisation d'une structure HTML5 sémantique stricte (main, nav, aria-label, textes alternatifs
      alt sur l'ensemble des visuels WebP) permet aux lecteurs d'écran de restituer fidèlement et logiquement l'ensemble
      des parcours pédagogiques.
