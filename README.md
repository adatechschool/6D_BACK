# DOCUMENTAION

Source à partir de la ligne 111



## INSTALLATION

- Vérifier que composer est bien installé :
> composer --version

- Installer les dépendances
> composer install

- Lancer le serveur
> php -S localhost:8000 -t public
> 
Une fois le serveur lancé, il faut un nouveau terminal pour entrer des lignes de commandes


## CONFIGURER LA BASE DE DONNÉE

Dans le fichier .env, rentrer l'url de la database que l'on va créer en suivant ce modèle. La base de donnée ne doit pas être créee sur PHPMyAdmin, on lui écrit seulement l'url, c'est doctrine qui va la faire. Entre {} ce qui est à modifier (ces informations peuvent être trouvées via PHPMyAdmin) :

DATABASE_URL="mysql://{username}:{passeword}@127.0.0.1:{portDuServeur}/{nomDeLaBDD}?serverVesion={versionDeMySQL}&{typeDeL'Encodage}" 

- Ensuite, entrer la commande suivante :
> php bin/console doctrine:database:create

- Créer une classe entité, qui représentera une table 
> php bin/console make:entity

Dans la console, l'interface de configuration des colonnes va se lancer automatiquement après la commande précédente. Ses attributs seront à remplir, sauf l'id, qui sera présent par défaut ainsi que ses  ses paramètres (not null, auto incrémntation). 
Par exemple : 

********************************************************************************************
Class name of the entity to create or update:
> MyTable

New property name (press <return> to stop adding fields):
> name

Field type (enter ? to see all types) [string]:
> string

Field length [255]:
> 255

Can this field be null in the database (nullable) (yes/no) [no]:
> no

New property name (press <return> to stop adding fields):
> price

Field type (enter ? to see all types) [string]:
> integer

Can this field be null in the database (nullable) (yes/no) [no]:
> no

New property name (press <return> to stop adding fields):
>
(press enter again to finish)
********************************************************************************************


Un nouveau fichier src/Entity/MyTable.php est alors créé. A la création de la classe, ses attributs sont créés, les getters et les setters aussi. Ses attributs peuvent être modifiés dans MyTable.php ou en relançant la commande
> php bin/console make:entity

qui permet d'update la table en renseignant un nom déja existant, par exemple :

Class name of the entity to create or update:
> MyTable

Ajouter MyTable au dossier migration, qui génère du SQL pour l'envoyer dans la BDD (MyTable n'est pour l'instant qu'une classe) :
> php bin/console make:migration

Run le SQL présent dans le nouveau fichier migration pour l'ajouter à la base de donnée :
> php bin/console doctrine:migrations:migrate

!! Important !! : à chaque mofification de la table ou de ses attributs, il est nécessaire de run à nouveau :
> php bin/console make:migration

puis :

> php bin/console doctrine:migrations:migrate

pour updater la BDD aveec les changements de la table. 

Il faut ensuite générer un controller, qui créera un nouveau fichier dans lequel on écrira les fonctions répondant aux méthodes HTPP :
> php bin/console make:controller MyTableController

On accède aux réponses des méthodes manipulant les données en retrant la route définie dans le fichier 

Exemple : 

```class MyTableController extends MyTable
    #[Route('/myTableShowData', name: 'create_data_my_table')]
```


l'url sera : http://localhost:8000/myTableShowData
(Pour y accéder, le port sera toujours 8000 et pas celui renseigné dans l'url de la base de donnée dans le .env)

!! Attention !! Ne pas oublier de lancer le serveur à nouveau avec la commande
> php -S localhost:8000 -t public

(Penser à vérifier la bonne exécution des méthodes en utilisant Bruno ou Postman)


## Sources :

- Utilisation de doctrine, mise en place de la BDD, des tables, utilisation des controllers et des entités :
https://symfony.com/doc/current/doctrine.html


- Créer des routes, les faire matcher des méthodes HTPP, etc :
https://symfony.com/doc/current/routing.html


- Définition d'un ORM :
https://www.base-de-donnees.com/orm/
