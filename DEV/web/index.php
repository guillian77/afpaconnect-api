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

/**
 * Load configuration
 */
require "../modules/core/configuration.php";
$config = Configuration::get();
$_SESSION['BASE_HREF'] = $config['BASE_HREF'];

/**
 * AUTOLOAD
 *
 * - composer autoloader for tiers libraries.
 * - custom autloader for every classes on this project.
 */
require $config['PATH_CLASS'] . 'vendor/autoload.php';
require 'Autoload.php';
new Autoload($config);
new Dispatcher($config);
