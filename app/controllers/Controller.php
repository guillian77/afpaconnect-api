<?php


namespace App\Controller;


use App\Core\Conf;
use App\Core\Router;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Controller
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var Router
     */
    private Router $router;

    public function __construct(Environment $twig, Router $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * @param string $view
     * @param array $parameters
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $parameters = []): void
    {
        $params = array_merge($parameters, [
            'appTitle' => Conf::get('appTitle'),
            'copyright' => Conf::get('copyright'),
            'path' => $this->router,
            'session' => $_SESSION
        ]);

        $this->twig->display($view, $params);
    }
}