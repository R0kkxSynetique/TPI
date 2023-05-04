# TPI - AeroModel

## Pré-requis

* WSL 2
* Laravel 10
* JetStream 3 with Inertia
* Docker
* Visual Studio Code
  * Extensions
    * Docker
    * DevConatainers
* Php 8.1
* Composer
* MySQL

## Installation developpement

### Instller WSL 2 et une distribution Linux

Premièrement il faut que WSL 2 soit activé sur votre machine.

Ensuite installez une distribution Linux (Ubuntu, Debian, Kali, etc...) depuis le windows store.

### Cloner le repository depuis WSL

Exécutez WSL pour accéder à votre linux puis clonez le repository dans le dossier que vous souhaitez

### Exécuter le projet

Ouvrez VSCode dans le sous dossier du projet s'appelant "AeroModel". 

```bash
cd /path/to/project/pre-tpi/AeroModel
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

Dès que la commande est terminée, exécutez la commande suivante pour ouvrir VSCode dans le dossier courant:

```bash
code .
```

Une fois le projet ouvert dans VSCode il vous sera sûrement proposé de `réouvrir le dossier dans un conteneur`. Acceptez.

Si vous ne voyez pas cette option, ouvrez le menu de VSCode et cliquez sur "Reopen in Container".

Ouvrez ensuite la shell de VSCode puis exécutez la commande suivante pour installer les dépendences:

```bash
npm i
```

Il faut encore copier le ficher `.env.example` et le renommer en `.env` et changer la configuration du fichier `vite.config.js` pour que le projet soit accessible depuis votre machine.

```bash
server: {
        hmr: {
            // host: '192.168.1.10', // <-- votre ip locale
            host: 'localhost',
            protocol: 'ws',
        }
    }
```

Finalement, il ne vous reste plus qu'à exécuter les migrations et les seeders pour vous trouver avec une base de données prête à l'emploi et des données de tests.

Exécutez la commande suivante dans la shell de VSCode pour créer la base de données et les tables et un utilisateur par défaut possédant l'adresse email `test@doe.ch` et le mot de passe `password` 

Vous pouvez changer ces valeurs dans le fichier `DatabaseSeeder.php` et dans la factory `UserFactory.php`:
 
```bash
php artisan migrate:fresh --seed
```

Puis exécutez le script SQL `ManualSeeder.sql` pour créer les données de tests.

Ce script se trouve dans le dossier `./database/scripts` et vous Créera les données suivantes:
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

Elles sont nommées de la manière suivante: `id_du_modèle_réduit.jpg`

L'installation du projet est terminée.Pour `run` l'application, exécutez la commande suivante:

```bash
npm run dev
```

Vous pouvez y accédez depuis votre navigateur en allant sur l'adresse suivante: `http://localhost`