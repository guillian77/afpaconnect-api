<?php


namespace App\Core;


use App\Controller\Controller;
use App\Middleware\CrossOrigin;
use App\Utility\Response;
use Closure;
use DI\Container;
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

    private function loadController()
    {
        try {
            $this->container->call([$this->router->className, $this->router->methodName]);
        } catch (Exception $exception) {
            $this->showExeption($exception);
            require VIEWS . '404.html';
        }
    }

    private function loadAPI()
    {
        if (!$this->session->has('user')) {
            $this->container->call([JsonWebToken::class, 'checkToken']);
            $this->container->call([CrossOrigin::class, 'sameOrigin']);
        }

        try {
            $this->container->call([$this->router->className, $this->router->methodName]);
        } catch (Exception $exception) {
            $this->showExeption($exception);
            Response::resp('Class not found', 404, true);
        }
    }

    private function loadMiddleware()
    {
        if (!array_key_exists($this->router->routeName, $this->router->middlewares)) {
            return false;
        }

        $middleware = $this->router->middlewares[$this->router->routeName];

        $this->container->get('\App\Middleware\\'.ucfirst($middleware));
    }

    private function showExeption($exception)
    {
        if (Conf::get('env') == 'dev') { // Show PHP errors.
            dump($exception);
        }
    }
}
