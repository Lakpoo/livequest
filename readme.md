# LiveQuest

Projet Livequest Licence

## Cloner le Dépôt

```shell
git clone https://github.com/Lakpoo/livequest.git
``` 
```shell
cd livequest
```
## Installer les composer

```shell
composer install
```

## Configurez votre .env

## Créer et migrer la base de donnée 
```shell
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
## Lancer le projet

```shell
symfony serve -d
```




