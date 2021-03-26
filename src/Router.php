<?php


namespace App\Core;


use AltoRouter;
use Closure;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;

class Router
{
    /**
     * @var AltoRouter $router
     */
    private AltoRouter $router;

    /**
     * @var Container
     */
    private Container $container;

    /**
     * @var array $middlewares Middleware mapped with route name.
     */
    public array $middlewares = [];

    /**
     * @var mixed
     */
    public ?string $className = null;

    /**
     * @var mixed
     */
    public ?string $methodName = null;

    /**
     * @var mixed
     */
    public ?array $routeParams = [];

    /**
     * @var string
     */
    public ?string $routeName = null;

    public function __construct(AltoRouter $altoRouter, Container $container)
    {
        $this->router = $altoRouter;

        $this->container = $container;
    }

    /**
     * @return AltoRouter
     */
    public function getRouter(): AltoRouter
    {
        return $this->router;
    }

    /**
     * @param string $url
     * @param $target
     * @param string $name
     * @param null $middleware
     * @return $this
     * @throws Exception
     */
    public function get(string $url, $target, string $name, $middleware = null): self
    {
        $this->router->map('GET', $url, $target, $name);

        if (!is_null($middleware)) {
            $this->middlewares[$name] = $middleware;
        }

        return $this;
    }

    public function run()
    {
        $route =  $this->router->match();

        if (!$route) {
            return false;
        }

        if (!$route['target'] instanceof Closure) {
            $this->className      = $route['target'][0];

            $this->methodName     = $route['target'][1];

            $this->routeName      = $route ['name'];

            $this->routeParams    = $route['params'];

            return false;
        }

        return $route['target'];
    }

    /**
     * Generate a route from name.
     *
     * @param string $name
     * @param array $params
     * @return string|null
     * @throws Exception
     */
    public function generate(string $name, array $params = []): ?string
    {
        return $this->router->generate($name, $params);
    }
}
