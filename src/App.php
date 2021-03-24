<?php


namespace App\Core;


use DI\Container;
use DI\ContainerBuilder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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

    public function boot()
    {
        session_start();

        require ROOT.'routes/web.php';

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
}
