# Touche pas au klaxon

Touche pas au klaxon est une application de covoiturage interne à une entreprise. Elle permet aux employés de proposer des trajets entre les agences et de contacter les personnes qui les organisent.

Le projet utilise PHP avec une architecture MVC, MySQL ou MariaDB pour la base de données, ainsi que Bootstrap et Sass pour l’interface.

## Fonctionnalités

- **Visiteur** — consulter les trajets à venir qui ont encore des places disponibles, classés par date de départ.
- **Employé connecté** — consulter les coordonnées de la personne qui propose un trajet, créer un trajet et modifier ou supprimer ses propres trajets.
- **Administrateur** — consulter les utilisateurs et les trajets, supprimer un trajet et gérer les agences.

Après une création, une modification ou une suppression réussie, l’application revient à la liste correspondante et affiche un message de confirmation.

## Installation sur Windows avec XAMPP

### Prérequis

- XAMPP avec PHP 8.1 ou plus, le pilote PDO MySQL et phpMyAdmin.
- Composer pour installer et lancer PHPUnit et PHPStan.
- Le pilote PDO SQLite pour les tests de base de données.
- Node.js et npm pour recompiler les styles Sass si nécessaire.

### 1. Importer la base de données

1. Ouvrir **XAMPP Control Panel** et démarrer **Apache** et **MySQL**.
2. Ouvrir [phpMyAdmin](http://localhost/phpmyadmin/).
3. Dans l’onglet **Importer**, sélectionner `database/schema.sql`. Le script crée la base `touche_pas_au_klaxon` et ses tables.
4. Importer ensuite `database/seed.sql`. Le script ajoute les 12 agences et les 20 employés de l’annexe, ainsi qu’un compte administrateur et 9 trajets de démonstration.

**Attention** — `schema.sql` supprime puis recrée la base `touche_pas_au_klaxon` si elle existe déjà. Le réimport efface les données présentes dans cette base.

Si les paramètres de connexion à MySQL diffèrent de ceux de XAMPP, les adapter dans `config/config.php` ou avec les variables d’environnement `DB_HOST`, `DB_NAME`, `DB_USER` et `DB_PASS`.

### 2. Lancer l’application

Ouvrir PowerShell à la racine du projet, dans le dossier qui contient `composer.json` et `public`, puis lancer :

```powershell
& 'C:\xampp\php\php.exe' -S localhost:8000 -t public
```

Laisser MySQL démarré et la fenêtre PowerShell ouverte, puis accéder à [http://localhost:8000](http://localhost:8000).

### 3. Se connecter

| Rôle | Adresse e-mail | Mot de passe de démonstration |
| --- | --- | --- |
| Employé | `alexandre.martin@email.fr` | `password` |
| Administrateur | `admin@touchepasauklaxon.fr` | `password` |

## Tests et analyse du code

Depuis la racine du projet, lancer :

```powershell
composer install
composer test
composer stan
```

- **PHPUnit** vérifie les règles de validation des trajets et les opérations d’écriture sur les agences et les trajets. Les tests d’écriture utilisent SQLite en mémoire. Ils ne modifient pas la base MySQL de l’application.
- **PHPStan** analyse le code PHP du dossier `src` au niveau 5.

Lors de la vérification locale, PHPUnit a validé **9 tests et 16 assertions**, et PHPStan n’a signalé **aucune erreur**.

## Styles

Le CSS compilé est inclus dans `public/assets/css/app.css`. Après une modification des styles Sass, le recompiler avec :

```powershell
npm install
npm run build
```

La palette du projet est définie dans `assets/scss/main.scss` avec les variables de Bootstrap.

## Organisation du projet

| Dossier | Contenu |
| --- | --- |
| `public/` | Point d’entrée de l’application et ressources servies au navigateur |
| `src/` | Routeur, contrôleurs, modèles et validation des trajets |
| `templates/` | Vues et mise en page |
| `config/` | Paramètres de connexion à la base |
| `database/` | Scripts de création et d’alimentation de la base |
| `assets/scss/` | Fichiers Sass |
| `assets/img/` | MCD et MLD |
| `tests/` | Tests PHPUnit |

## Modèles de données

- [Modèle conceptuel de données (MCD)](assets/img/MCD.png)
- [Modèle logique de données (MLD)](assets/img/MLD.txt)