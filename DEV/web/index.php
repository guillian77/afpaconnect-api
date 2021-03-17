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
    var_dump($toDebug);
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
    var_dump($toDebug);
    echo '</pre>';
    echo '<hr/>';
}

require dirname(__DIR__).'/modules/core/App.php';

(App::getInstance())->initialize();
