<?php

/*
|--------------------------------------------------------------------------
| Configuration
|--------------------------------------------------------------------------
|
| Here is registered configuration for the application.
|
*/

return [
    /*
    |----------------------------------------------------------------
    | URL BASE PATH
    |----------------------------------------------------------------
    | Here you can set the base path.
    | Useful if you are running your application from a subdirectory.
    | If you don't need. Leave it to empty string.
    | Sample:
    |       If your URL is http://localhost:80/afpaconnect.
    |       Set base_path to 'base_path' => "/afpaconnect".
    */
    'base_path' => "",

    /*
    |----------------------------------------------------------------
    | Database
    |----------------------------------------------------------------
    | db_host   string
    | > Database DSN or hostname. [0.0.0.0|localhost]
    |
    | db_port   int
    | > Database port, default: 3306
    */
    'driver' => \App\Core\Database\EloquentDriver::class,

    'db_host' => "database",
    'db_port' => 3306,
    'db_name' => "afpaconnect",
    'db_username' => "afpaconnect",
    'db_password' => "afpaconnect",

    /*
    |----------------------------------------------------------------
    | Environment : dev | prod
    |----------------------------------------------------------------
    |
    | Here the environment can be switched has your need.
    | If environment is defined to dev, some developer tools will be activated.
    | Also, cache will be switched off.
    |
    */
    'env' => 'dev',

    /*
    |----------------------------------------------------------------
    | API
    |----------------------------------------------------------------
    | token_duration        =   Default to 600 seconds (10 minutes).
    | authorized_address    =   List of whitelisted IP address used to
    |                           filter API request.
    */
    'token_duration' => 1200,
    'authorized_address' => [
        '::1',
        'localhost',
        '127.0.0.1',
        '172.18.0.1',
        '172.23.0.1',
        '172.21.0.1'
    ],

    /*
    |----------------------------------------------------------------
    | Application
    |----------------------------------------------------------------
    | appTitle              =   AfpaConnect
    | tld                   =   afpaconnect.eloce-formation-afpa.com
    | copyright             =   App copyright
    */
    'appTitle' => 'AfpaConnect',

    'contactEmail' => 'contact@afpaconnect.fr',

    'tld' => 'http://127.0.0.1:8000',

    'copyright' => '2021 - Developped by Aufrère Guillian, Moreau Eloïse and Campillo Lucas for AFPA'
];
