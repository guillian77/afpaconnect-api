<?php


namespace App\Core;


use DI\Container;

class Dispatcher
{
    /**
     * @var Router
     */
    private Router $router;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Container
     */
    private Container $container;

    public function __construct(Router $router, Request $request, Container $container)
    {
        $this->router = $router;

        $this->request = $request;

        $this->container = $container;

        $callable = $this->router->run();

        if ($callable) {
            $callable();
            return;
        }

        if (!class_exists($this->router->className)) {
            throw new \Exception("Invalid class ". $this->router->className);
        }

        if(!method_exists($this->router->className, $this->router->methodName)) {
            throw new \Exception("Invalid method ".$this->router->methodName." for ".$this->router->className);
        }

        $this->dispatch();
    }

    private function dispatch()
    {
        $this->loadMiddleware();

        switch ($this->request->type) {
            case Request::TYPE_WEB:
                $this->loadController();
                break;
            case Request::TYPE_API:
                $this->loadAPI();
                break;
            default:
                $this->loadController();
        }
    }

    private function loadController()
    {
        ob_start();

        $this->container->call([$this->router->className, $this->router->methodName]);

        $this->render(ob_get_clean());
    }

    private function loadAPI()
    {
        $this->container->call([$this->router->className, $this->router->methodName]);
    }

    private function loadMiddleware()
    {
        if (!array_key_exists($this->router->routeName, $this->router->middlewares)) {
            return false;
        }

        $middleware = $this->router->middlewares[$this->router->routeName];

        $this->container->get('\App\Middleware\\'.ucfirst($middleware));
    }

    private function render($content)
    {
        $controller = $this->container->get($this->router->className);

        $appTitle = "";

        if (!empty($controller->pageTitle)) {
            $appTitle .= $controller->pageTitle.' - ';
        }

        $appTitle .= "AfpaConnect"; // expose app name to layout

        $router = $this->router; // expose router to layout

        require VIEWS.'layout.php';
    }
}
