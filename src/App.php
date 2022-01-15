<?php


namespace App\Core;


use App\Core\TwigExtension\ConfigExtension;
use App\Core\TwigExtension\RouterExtension;
use App\Core\TwigExtension\SessionExtension;
use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

define('ROOT', dirname(__DIR__) . '/');
define('SRC', ROOT.'src/');
define('APP', ROOT.'app/');
define('CONTROLLER', ROOT.'app/controllers/');
define('MODEL', ROOT.'app/models/');
define('MIDDLEWARE', ROOT.'app/middlewares/');
define('WWW', ROOT.'public/');
define('VIEWS', ROOT.'app/views/');
define('STORAGE', ROOT.'storage/');
define('DB', ROOT.'database/');

/**
 * Class App : Singleton
 * @package App\Core
 * @author Aufrère Guillian
 */
class App
{
    /**
     * @var self $_instance Instance of App.
     */
    private static ?self $_instance = null;

    /**
     * @var ContainerBuilder $containerBuilder Dependency Injection Container Builder.
     */
    private ContainerBuilder $containerBuilder;

    /**
     * @var Container $container Dependency Injection Container.
     */
    private Container $container;

    /**
     * @var Router $router
     */
    private Router $router;

    /**
     * @var FilesystemLoader
     */
    private FilesystemLoader $twigLoader;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * Always get the same instance of App.
     *
     * @return self
     */
    public static function get(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $this->containerBuilder = new ContainerBuilder();

        $this->containerBuilder->useAutowiring(true);

        $this->containerBuilder->addDefinitions(ROOT.'config/services.php');

        $this->container = $this->containerBuilder->build();

        $this->router = $this->container->get(Router::class);

        $this->twigLoader = $this->container->get(FilesystemLoader::class);

        $this->twig = $this->container->get(Environment::class);
    }

    /**
     * Boot the application.
     *
     * @throws NotFoundException
     * @throws DependencyException
     */
    public function boot()
    {
        if (Conf::get('env') == 'dev') { // Show PHP errors.
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }

        $this->container->get(Conf::get('driver'));

        session_start();

        $this->loadTemplateExtensions();

        $this->container->get(Dispatcher::class);
    }

    /**
     * @return ContainerBuilder
     */
    public function getContainerBuilder(): ContainerBuilder
    {
        return $this->containerBuilder;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Load Twig Extensions.
     *
     * @throws NotFoundException
     * @throws DependencyException
     */
    private function loadTemplateExtensions()
    {
        // Get file reference all twig extensions to load.
        $twigExtensions = require ROOT . 'config/twigExtensions.php';

        // Add any extensions.
        foreach ($twigExtensions as $extension) {
            $this->twig->addExtension($this->container->get($extension));

        }
    }
}
