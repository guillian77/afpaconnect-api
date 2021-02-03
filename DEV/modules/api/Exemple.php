<?php
namespace App\Api;

use App\Core\Controller;
use App\Utility\Response;

class Exemple extends Controller
{
    public function __construct()
    {
        Response::json("Am called Example");
    }
}
