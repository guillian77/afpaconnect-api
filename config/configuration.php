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
    | token_duration = default to 600 seconds (10 minutes).
    */
    'token_duration' => 600,

    /*
    |----------------------------------------------------------------
    | Application title
    |----------------------------------------------------------------
    */
    'appTitle' => 'AfpaConnect',

    /*
    |----------------------------------------------------------------
    | Application copyright
    |----------------------------------------------------------------
    */
    'copyright' => '2021 - Developped by Aufrère Guillian & Campillo Lucas for AFPA'
];
