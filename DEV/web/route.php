<?php

/**
 * Start session
 */
session_start();

function dd($toDebug)
{
    echo '<pre>';
    var_dump($toDebug);
    echo '<pre>';
    die();
}

/**
 * Load configuration
 */
require "../modules/core/configuration.php";
$config = Configuration::get();
$_SESSION['BASE_HREF'] = $config['BASE_HREF'];

/**
 * Load Authenticate class
 */
require $config['PATH_CORE'] . "Authenticate.php";

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

/**
 * Load called class
 *
 * bJSON	TRUE	API MODE
 * bJSON	FALSE	STD MODE
 */
$myClass = ucfirst($monPHP);

if ((isset($_GET["bJSON"])) && ($_GET["bJSON"] == 1)) {
	/**
	 * API MODE
	 * Load class called inside "modules/api"
	 */
	$path_api = $GLOBALS_INI["PATH_HOME"] . $GLOBALS_INI["PATH_CLASS"] . "api/" . $monPHP . ".php";

	if (!file_exists($path_api)) { // 404: not found
		header('HTTP/1.0 404 API Class not Found');
	}
	else { // 200: response JSON from loaded class
		require $path_api;
		$oMain = new $myClass();
	}
}
else {
	/**
	 * STANDARD MODE
	 * Load class called inside "modules/"
	 * Call HTML router (route.html) to render view.
	 */
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
}

unset($oMain);

