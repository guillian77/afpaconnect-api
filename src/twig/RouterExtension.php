<?php

namespace App\Core\TwigExtension;


use App\Core\Router;
use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class RouterExtension
 * @package App\Core\TwigExtension
 * @author Aufrère Guillian
 */
class RouterExtension extends AbstractExtension
{
    private Router $router;

    /**
     * RouterExtension constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('path', [$this, 'generatePath'])
        ];
    }

    /**
     * Generate URL strings from route.
     *
     * @param string $routeName Route name to get URL string.
     * @param array $params Additional optional parameters to transmit.
     *
     * @return string|null
     *
     * @throws Exception
     */
    public function generatePath(string $routeName, array $params = [])
    {
        return $this->router->generate($routeName, $params);
    }
}
