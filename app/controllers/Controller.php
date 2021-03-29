<?php


namespace App\Controller;


use App\Core\Conf;
use App\Core\Router;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Controller
 * @package App\Controller
 * @author Aufrère Guillian
 */
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

    /**
     * Controller constructor.
     * @param Environment $twig
     * @param Router $router
     */
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
        $assets = $this->autoloadAssets($view);

        $params = array_merge(
            $parameters,
            [
                'appTitle' => Conf::get('appTitle'),
                'copyright' => Conf::get('copyright')
            ],
            $assets
        );

        $this->twig->display($view, $params);
    }

    /**
     * Autoload assets files : javascript | css
     *
     * @param string $viewPath
     * @return array|null
     */
    private function autoloadAssets(string $viewPath): ?array
    {
        $fileExtensions = ['.php', '.html', '.twig', '.tpl', '.blade'];

        $assets = [];

        foreach ($fileExtensions as $extension) {
            $viewPath = str_replace($extension, '', $viewPath);
        }

        $javascriptPath = 'js/features/'.$viewPath.'.js';

        $cssPath        = 'css/features/'.$viewPath.'.css';

        $assets['js'] = (file_exists($javascriptPath)) ? "<script src=\"$javascriptPath\"></script>" : null;

        $assets['css'] = (file_exists($cssPath)) ? "<link rel=\"stylesheet\" href=\"$cssPath\" />" : null;

        return $assets;
    }
}
