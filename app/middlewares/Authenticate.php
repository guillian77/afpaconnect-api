<?php


namespace App\Middleware;


use App\Core\App;
use App\Core\Router;

class Authenticate
{
    private Router $router;

    public function __construct()
    {
        $this->router = App::get()->getRouter();
        
        if (empty($_SESSION['user']['uid'])) {
            header('Location: ' . $this->router->generate('login'));
        }
    }
}
