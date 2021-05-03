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
    |--------------------------------
    | Database
    |--------------------------------
    */
    'db_host' => "127.0.0.1",
    'db_name' => "afpaconnect",
    'db_username' => "afpaconnect",
    'db_password' => "afpaconnect",

    /*
    |--------------------------------
    | Environment : dev | prod
    |--------------------------------
    |
    | Here the environment can be switched has your need.
    | If environment is defined to dev, some developer tools will be activated.
    | Also, cache will be switched off.
    |
    */
    'env' => 'dev',

    /*
    |--------------------------------
    | API
    |--------------------------------
    | token_duration = default to 600 seconds (10 minutes).
    */
    'token_duration' => 600,

    /*
    |--------------------------------
    | Application title
    |--------------------------------
    */
    'appTitle' => 'AfpaConnect',

    /*
    |--------------------------------
    | Application copyright
    |--------------------------------
    */
    'copyright' => '2021 - Developped by Aufrère Guillian & Campillo Lucas for AFPA'
];
