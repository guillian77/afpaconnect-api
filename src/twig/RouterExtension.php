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
    /**
     * @var Router
     */
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
     * @param string $url
     * @param array $params
     * @return string|null
     * @throws Exception
     */
    public function generatePath(string $url, array $params = [])
    {
        return $this->router->generate($url, $params);
    }
}