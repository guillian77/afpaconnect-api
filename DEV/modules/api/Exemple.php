<?php
namespace App\Api;

use App\Utility\Response;

class Exemple
{
    public function __construct()
    {
        Response::json("Am called Example");
//        Response::resp("Salut les gens", 403);
    }
}
