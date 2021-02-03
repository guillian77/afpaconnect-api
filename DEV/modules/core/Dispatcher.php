<?php
namespace App\Core;


use App\Middleware\Authenticate;
use App\Utility\Response;

class Dispatcher
{
    public $request;

    private $config;

    /**
     * Dispatcher constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->request = new Request();

        Authenticate::check($this->request);

        // Select STD HTML response or API response.
        if ( !$this->request->isXhrRequest() )
        {
            $this->loadController();
        } else {
            $this->loadApiClass();
        }
    }

    /**
     * Load controller.
     */
    public function loadController()
    {
        $controllerPath = $this->config['PATH_CLASS'] . $this->request->controller . ".php";

        if ( file_exists($controllerPath) )
        {
            $class = "\App\Controller\\" . ucfirst($this->request->controller);
            new $class();
        } else {
            $this->notFound();
        }
    }

    /**
     * Load API class where XHR request is detected.
     */
    public function loadApiClass()
    {
        if (empty($this->request->controller))
        {
            Response::resp("Empty target method.", 404);
            return;
        }

        $apiPath = $this->config['PATH_CLASS'] . "api/" . $this->request->controller . ".php";

        if (!file_exists($apiPath))
        {
            Response::resp("API " . $this->request->controller . " not found.", 404);
            return;
        }

        $class = "\App\Api\\" . ucfirst($this->request->controller);
        new $class();
    }

    public function notFound()
    {
        http_response_code(404);
        header('HTTP/1.0 404 page not found');
        require $this->config['PATH_FILES'] . "404.php";
    }
}
