<?php
namespace App\Core;


class Dispatcher
{
    public $request;

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->request = new Request();

        $this->loadController();
    }

    public function loadController()
    {
        $controllerPath = $this->config['PATH_CLASS'] . $this->request->controller . ".php";

        if ( file_exists($controllerPath) )
        {
            $class = "\App\Controller\\" . ucfirst($this->request->controller);
            new $class();
        }
    }
}
