# TPI - AeroModel

## Pré-requis

### Développement

* WSL 2
* Laravel 10
* JetStream 3 avec Inertia
* Docker
* Visual Studio Code
  * Extensions
    * Docker
    * DevConatainers
* Php 8.1^
* Composer
* MySQL

### Production

* Php 8.1^
* Composer
* MySQL

## Installation - developpement

### Instller WSL 2 et une distribution Linux

Premièrement il faut que WSL 2 soit activé sur votre machine.

Ensuite installez une distribution Linux (Ubuntu, Debian, Kali, etc...) depuis le Windows store.

### Cloner le repository depuis WSL

Exécutez WSL pour accéder à votre Linux puis clonez le repository dans le dossier que vous souhaitez

### Exécuter le projet

Naviguez jusqu'au dossier du projet

```bash
cd /path/to/the/project/TPI
```

Ensuite exécuter la commande docker suivante:

```bash
docker run --rm \
            -u "$(id -u):$(id -g)" \
            -v "$(pwd):/var/www/html" \
            -w /var/www/html \
            laravelsail/php81-composer:latest \
            composer install --ignore-platform-reqs
```

Dès que la commande est terminée, ouvrez VSCode dans le dossier courant.

Une fois le projet ouvert dans VSCode il vous sera sûrement proposé de `réouvrir le dossier dans un conteneur`. Acceptez.

Si vous ne voyez pas cette option, ouvrez le menu de VSCode (`ctrl + shift + p`) et cliquez sur "Reopen in Container".

Ouvrez ensuite la shell de VSCode puis exécutez la commande suivante pour installer les dépendances:

```bash
npm i
```

Il faut encore copier le ficher `.env.example` et le renommer en `.env` et changer la configuration du fichier `vite.config.js` pour que le projet soit accessible depuis votre machine.

```bash
#.env
APP_DEBUG=true
APP_URL=http://localhost # <--- Changer cette valeur

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=MyDatabase # <--- Changer cette valeur
DB_USERNAME=MyUser # <--- Changer cette valeur
DB_PASSWORD=MyPassword # <--- Changer cette valeur
```

```js
// vite.config.js
server: {
        hmr: {
            host: 'localhost', // <--- Changer cette valeur
            protocol: 'ws',
        }
    }
```

Finalement, il ne vous reste plus qu'à exécuter les migrations et les seeders pour vous générer une base de données prête à l'emploi avec les données de test.

Exécutez la commande suivante dans la shell de VSCode pour créer la base de données, les tables, un utilisateur par défaut possédant l'adresse email `test@doe.ch` et le mot de passe `password` et des modèles réduits. 

Vous pouvez changer ces valeurs dans les fichiers correspondant dans le répertoire `./database/seeders` et dans la factory `./database/factories/UserFactory.php`:
 
```bash
php artisan migrate:fresh --seed
```

Les données générées sont les suivantes:

* 16 hélices
* 10 moteurs
* 10 télécommandes
* 126 batteries
* 5 modèles réduits:
  * Mitsubishi A6m zero
    * 1 moteur
    * 1 hélice
    * 3 batteries
  * Hawker Hurricane
    * 1 moteur
    * 1 hélice
    * 3 batteries
  * Sopwith Triplane
    * 1 moteur
    * 1 hélice
    * 2 batteries
  * Consolidated B-24 Liberator
    * 4 moteurs
    * 4 hélices
    * 4 batteries
  * de Havilland DH.98 Mosquito
    * 2 moteurs
    * 2 hélices
    * 2 batteries
* 1 vol pour le premier modèle réduit

Tous les modèles réduits sont liés à l'utilisateur qui a été créé à l'étape précédente. 

Vous pouvez trouver les images des modèles réduits dans le dossier `./storage/app/RcModelsImages`.

Elles sont nommées de la manière suivante: `{id_du_modèle_réduit}.jpg`

L'installation du projet est terminée. Pour `run` l'application, exécutez la commande suivante:

```bash
npm run dev
```

Vous pouvez y accéder depuis votre navigateur en allant sur l'adresse que vous avez entrée dans les fichiers de configuration ou sur l'adresse suivante: `http://localhost`

## Installation - production

### Cloner le repository

Clonez le repository dans le dossier que vous souhaitez

### Installer les dépendences

Exécutez la commande suivante pour installer les dépendances composer

```bash
composer install --ignore-platform-reqs
```

Ensuite exécutez la commande suivante pour installer les dépendances npm

```bash
npm i
```

Il faut encore copier le ficher `.env.example` et le renommer en `.env` et changer sa configuration pour que le projet soit accessible depuis le serveur.

```bash
#.env
APP_DEBUG=false
APP_URL=http://localhost # <--- Changer cette valeur

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=MyDatabase # <--- Changer cette valeur
DB_USERNAME=MyUser # <--- Changer cette valeur
DB_PASSWORD=MyPassword # <--- Changer cette valeur
```

Finalement, il ne vous reste plus qu'à exécuter les migrations et les seeders pour vous générer une base de données prête à l'emploi avec les données nécessaire.

Par défaut, un utilisateur de test sera créé si vous choisissez de peupler la base de données. Vous pouvez changer ces valeurs dans les fichiers correspondant dans le répertoire `./database/seeders` et dans la factory `./database/factories/UserFactory.php`

> Notez que si vous ne souhaitez pas peupler la base de données avec les seeders, vous devrez créer des moteurs, batteries, télécommandes et hélices manuellement si vous souhaitez les rendre publiques.
 
Voici la commande pour exécuter les migrations ainsi que les seeders.

```bash
php artisan migrate:fresh --seed
```

Dans le cas où vous n'avez pas peuplé la base de données, veuillez supprimer les images déjà présentes dans le dossier `./storage/app/RcModelsImages`.

Vous pouvez maintenant `build` l'application en exécutant la commande suivante:

```bash
npm run build
```

l'application est maintenant prête et déployée.
