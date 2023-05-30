# TPI - AeroModel

## Pré-requis

* WSL 2
* Laravel 10
* JetStream 3 avec Inertia
* Docker
* Visual Studio Code
  * Extensions
    * Docker
    * DevConatainers
* Php 8.1
* Composer
* MySQL

## Installation - developpement

### Instller WSL 2 et une distribution Linux

Premièrement il faut que WSL 2 soit activé sur votre machine.

Ensuite installez une distribution Linux (Ubuntu, Debian, Kali, etc...) depuis le windows store.

### Cloner le repository depuis WSL

Exécutez WSL pour accéder à votre linux puis clonez le repository dans le dossier que vous souhaitez

### Exécuter le projet

Ouvrez VSCode dans le dossier du projet s'appelant "TPI". 

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

Ouvrez ensuite la shell de VSCode puis exécutez la commande suivante pour installer les dépendences:

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

Finalement, il ne vous reste plus qu'à exécuter les migrations et les seeders pour vous générer une base de données prête à l'emploi avec les données de tests.

Exécutez la commande suivante dans la shell de VSCode pour créer la base de données, les tables, un utilisateur par défaut possédant l'adresse email `test@doe.ch` et le mot de passe `password` et des modèles réduits. 

Vous pouvez changer ces valeurs dans les fichiers correspondant dans le répertoire `./database/seeders` et dans la factory `./database/factories/UserFactory.php`:
 
```bash
php artisan migrate:fresh --seed
```

Les données générées sont les suivantes:

* 3 hélices
* 2 moteurs
* 2 télécommandes
* 4 batteries
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

Tout les modèles réduits sont liés à l'utilisateur qui à été crée à l'étape prcéédente. 

Vous pouvez trouver les images des modèles réduits dans le dossier `./storage/app/RcModelsImages`.

Elles sont nommées de la manière suivante: `{id_du_modèle_réduit}.jpg`

L'installation du projet est terminée. Pour `run` l'application, exécutez la commande suivante:

```bash
npm run dev
```

Vous pouvez y accédez depuis votre navigateur en allant sur l'adresse que vous avez entrée dans les fichier de configuration ou sur l'addresse suivante: `http://localhost`

## Installation - production

TODO
