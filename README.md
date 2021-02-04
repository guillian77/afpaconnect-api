# AfpaConnect

AfpaConnectis est une API permettant de centraliser les données des stagiaires de l'AFPA sur une seule et même application.

Une application, peut venir s'authentifier ou s'enregistrer en faisant des requête de type XHR à l'API d'AfpaConnect.

## Installation

### Prérequis
- Composer
- URL Rewrite
- PHP 7.2
- MySQL 5.7

### Opérations d'installation
1. Clône du projet,
```
git clone https://guillian77@bitbucket.org/guillian77/afpaconnect.git
```
2. Installer les dépendances avec Composer.
```
composer install
```
3. Créer un utilisateur et une base de données "afpaconnect".
4. Éditer le fichier de configuration: **DEV\modules\core\Configuration.php**
```
/**
 * DATABASE
 */
$config["db_hostname"] = "localhost";
$config["db_username"] = "root";
$config["db_password"] = "";
$config["db_name"] = "afpaconnect";
```
5. Installer la base de donnée avec l'outil **artisan**.
```
php artisan.php make database
```
Cette commande à permis de créer la **structure** de la BBD et d'y appliquer toutes mes **mises à jour** et les **jeux de données** nécessaires.

## L'API

### Login

Cette API permet d'authentifier l'utilisateur en fonction de son nom d'utilisateur (**username**), nom numéro de bénéficiaire (**beneficiary**) et de son mot de passe (**password**).

__ATTENTION__: Toute fois, il est important que les informations concernant l'application demandant l'authentification soient présentent: **Token** et nom. 

Tous les ses paramètres doivent être envoyé par un requête de type **XmlHttpRequest** (XHR) et respecter le **format** ci-dessous:

```
URL: afpaconnect/user/login
TYPE: XHR
METHOD: GET
FORMAT REQUÊTE (JSON):
"user": {
"username": "admin",
    "password": "test",
    "beneficiary": "123456789"
},
"app": {
"name": "afpanier",
    "token": "123456789"
}

FORMAT RÉPONSE (JSON):
{
    "id_user": "1",
    "id_center": "1",
    "user_username": "admin",
    "user_password": "$argon2i$v=19$m=65536,t=4,p=1$dC93Y1JNY0NEc2lwcFljbA$YU7KpgN7B4WW1plN2nXi2rptcrYrp1lw6Uly/+xh7jc",
    "user_identifier": "12345678",
    "user_name": "admin",
    "user_firstName": "admin",
    "user_mailPro": "admin@admin.fr",
    "user_mailPerso": "admin@admin.fr",
    "user_phone": "0102030405",
    "user_address": "15 rue de l'admin",
    "user_complementAddress": "Bâtiment A",
    "user_zipCode": "34000",
    "user_city": "Montpellier",
    "user_country": "France",
    "user_gender": "1",
    "user_status": "1",
    "user_created_at": "2021-02-01",
    "user_updated_at": "2021-02-01 13:43:25"
}
```

### Register

Work In Progress