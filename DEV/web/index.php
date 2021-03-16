<?php
namespace App\Core;

/**
 * Start session
 */
session_start();

// TODO: Remove theses devs functions or place theses somewhere else.

/**
 * Die and debug function
 * @param $toDebug
 */
function dd($toDebug)
{
    echo '<pre>';
    print_r($toDebug);
    echo '</pre>';
    echo '<hr/>';
    die();
}

/**
 * Only debug function.
 * @param $toDebug
 */
function debug($toDebug)
{
    echo '<pre>';
    print_r($toDebug);
    echo '</pre>';
    echo '<hr/>';
}

if (!file_exists('../modules/vendor/autoload.php') || !file_exists('../modules/core/Configuration.php'))
{
    echo "<h1>Vous êtes nouveau içi ? 😅</h1>";
    echo "<p>Vous devez d'abord installer les dépendances nécessaires au fonctionnement de l'application.</p>";
    echo "<p>Exécutez cette commande dans la racine du répertoire du projet: <b>php artisan install</b></p>";
    die();
}

/**
 * Load configuration
 */
require "../modules/core/Configuration.php";
$config = Configuration::get();

if ($config['DEV']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$_SESSION['BASE_HREF'] = $config['BASE_HREF'];

require $config['PATH_CLASS'] . 'vendor/autoload.php';
require 'Autoload.php';
new Autoload($config);
