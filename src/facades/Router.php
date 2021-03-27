<?php


namespace App\Core\Facade;


use App\Core\App;

/**
 * @method static get(string $path, Mixed|\Closure $target, string $name, Mixed|null $middleware = null)
 * @method static post(string $path, Mixed|\Closure $target, string $name, Mixed|null $middleware = null)
 */
class Router
{
    public static function __callStatic($method, $arguments)
    {
        $router = App::get()->getContainer()->get(\App\Core\Router::class);
        return call_user_func_array([$router, $method], $arguments);
    }
}
