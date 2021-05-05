<?php


namespace App\Middleware;


use App\Core\App;
use App\Core\Router;
use App\Core\Session;

class Authenticate
{
    private Router $router;

    public function __construct(Session $session)
    {
        $this->router = App::get()->getRouter();

        if (!$session->has('user')) {
            header('Location: ' . $this->router->generate('login'));
        }
    }
}
