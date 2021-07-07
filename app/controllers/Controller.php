<?php


namespace App\Controller;


use App\Core\App;
use App\Core\Conf;
use App\Core\Router;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use http\Client;
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
     * Render a view from path.
     *
     * @param string $view
     * @param array $parameters
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws DependencyException
     * @throws NotFoundException
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

        $twig = App::get()
            ->getContainer()
            ->get(Environment::class);

        $twig->display($view, $params);
    }

    /**
     * Render the error view.
     *
     * A message can be set to be displayed.
     *
     * @param string $message   An error message.
     * @param bool $stop        Stop code execution.
     *
     * @throws DependencyException
     * @throws LoaderError
     * @throws NotFoundException
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function renderError(string $message, bool $stop = false)
    {
        $this->render('error.html.twig', [
            'error' => $message
        ]);

        $stop && die();
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

    /**
     * Redirect to a target route.
     *
     * @param string $target Target route.
     *
     * @throws Exception
     */
    public function redirect(string $target)
    {
        $router = App::get()->getRouter();

        $route = $router->generate($target);

        header('Location: '.$route);
    }
}
