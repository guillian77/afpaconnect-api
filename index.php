<?php

/**
 * REQUIRE
 */
require 'src/Configuration.php';
require 'src/Database.php';
require 'src/TokenVerifier.php';

$request = json_decode( file_get_contents('php://input') );

$check = TokenVerifier::isAuthorized($request);

if (!$check)
{
    echo json_encode("Bad token");
}

$db = new Database();
$req = $db->handle->query('SELECT * FROM algo_exercices');
var_dump($req->fetch());