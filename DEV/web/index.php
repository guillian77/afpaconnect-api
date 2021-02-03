<?php
namespace App\Core;

/**
 * Start session
 */
session_start();

function dd($toDebug)
{
    echo '<pre>';
    print_r($toDebug);
    echo '<pre>';
//    die();
}

/**
 * Load configuration
 */
require "../modules/core/configuration.php";
$config = \App\Core\Configuration::get();
$_SESSION['BASE_HREF'] = $config['BASE_HREF'];

/**
 * Autoloader
 */
require $config['PATH_CLASS'] . 'vendor/autoload.php';
require 'Autoload.php';
new Autoload($config);
new Dispatcher($config);

die();













// Class dynamic
if ((isset($_GET["page"])) && ($_GET["page"] != ""))
{
	$monPHP= $_GET["page"];
}
else
{
	if ((isset($_POST["page"])) && ($_POST["page"] != ""))
	{
		$monPHP= $_POST["page"];
	}
	else
	{
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
			$monPHP = "admin_dashboard";
		} else if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
			$monPHP = "ticket_list";
		} else {
			$monPHP = "user_login";
		}
	}
}

/**
 * Offline pages authorized
 */
$publicPages = [
	"user_login"
];

if(!isset($_SESSION['user']['uid']) ||(isset($_SESSION['user']['uid']) && $_SESSION['user']['uid'] == ""))	{
	if(!in_array($monPHP, $publicPages)){
		$monPHP = "user_login";
	}
}

$myClass = ucfirst($monPHP);

$path_controller = $config["PATH_CLASS"] . $monPHP . ".php";

if (!(file_exists($path_controller))) { // 404: Not Found
    header('HTTP/1.0 404 Not Found');
    $monPHP = "unfound";
    require $config["PATH_CLASS"] . "unfound.php";
}
else { // 200: load and call class
    require $path_controller;
    $oMain = new $myClass();
}

// Load front router
require $config["PATH_FILES"] . "layout.html";


unset($oMain);

