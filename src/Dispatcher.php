<?php


namespace App\Core;


use App\Controller\Controller;
use App\Middleware\CrossOrigin;
use App\Utility\Response;
use Closure;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use phpDocumentor\Reflection\Types\Callable_;

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

    /**
     * @var Session
     */
    private Session $session;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Router $router, Request $request, Container $container, Session $session)
    {
        $this->router = $router;

        $this->request = $request;

        $this->container = $container;

        $this->session = $session;

        require ROOT.'routes/web.php';

        require ROOT.'routes/api.php';

        $match = $this->router->run();

        if ($match instanceof Closure) {
            $match();
            return;
        }

        $this->dispatch();
    }

    /**
     * Dispatch between WEB or API request.
     *
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    private function dispatch()
    {
        switch ($this->request->type) {
            case Request::TYPE_WEB:
                $this->loadMiddleware();
                $this->loadController();
                break;
            case Request::TYPE_API:
                $this->loadAPI();
                break;
            default:
                $this->loadController();
        }
    }

    /**
     * Load method of a controller.
     *
     * @throws Exception
     */
    private function loadController()
    {
        try {
            $this->container->call([$this->router->className, $this->router->methodName]);
        } catch (Exception $exception) {
            $this->showException($exception);
            require VIEWS . '404.html';
        }
    }

    /**
     * Load an API class.
     *
     * @throws Exception
     */
    private function loadAPI()
    {
        if (!$this->session->has('user')) {
            $this->container->call([JsonWebToken::class, 'checkToken']);
            $this->container->call([CrossOrigin::class, 'sameOrigin']);
        }

        try {
            $this->container->call([$this->router->className, $this->router->methodName]);
        } catch (Exception $exception) {
            $this->showException($exception);
        }
    }

    /**
     * Load a middleware.
     *
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function loadMiddleware(): void
    {
        if (!array_key_exists($this->router->routeName, $this->router->middlewares)) {
            return;
        }

        $middleware = $this->router->middlewares[$this->router->routeName];

        $this->container->get('\App\Middleware\\'.ucfirst($middleware));
    }

    /**
     * @throws Exception
     */
    private function showException($exception)
    {
        if (Conf::get('env') == 'dev') { // Show PHP errors.
            throw new \Exception($exception);
        }
    }
}
