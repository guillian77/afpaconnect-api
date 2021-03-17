<?php
namespace App\Core;


use App\Middleware\Authenticate;
use App\Middleware\JsonWebToken;
use App\Utility\Response;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;

class Dispatcher
{
    public $request;

    private $config;

    /**
     * Dispatcher constructor.
     *
     * @param $config
     *
     * @throws ReflectionException
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->request = new Request();

        if ( !$this->request->isApiRequest($this->request->exploded) ) // API or Legacy HTTP request
        {
            Authenticate::check($this->request);
            $this->loadController();
        } else {
            (new JsonWebToken)->verify();
            $this->loadApiClass();
        }
    }

    /**
     * Load controller.
     *
     * @throws ReflectionException
     */
    public function loadController()
    {
        $controllerPath = $this->config['PATH_CLASS'] . $this->request->controller . ".php";

        if ( file_exists($controllerPath) )
        {
            $class = "\App\Controller\\" . ucfirst($this->request->controller);
            new $class(...Dependencies::getClassDependencies($class));
        } else {
            $this->notFound();
        }
    }

    /**
     * Load API class where API request is detected.
     *
     * API request is detect by /api/ path at the beginning of the URL.
     *
     * @throws ReflectionException
     */
    public function loadApiClass()
    {
        $routes = $this->loadApiRoutes();

        $pathCalled = str_replace("api/", "", $this->request->url);

        // Browse any routes in routes.yml
        foreach ($routes as $routeName => $route) {
            if (!isset($route['path'])) { // Check route.yaml path is correct
                Response::resp("Fatal error: " . $routeName . " should have a path.", 500, true);
            }

            if (!isset($route['controller'])) { // Check route.yaml controller is correct
                Response::resp("Fatal error: " . $routeName . " should have a controller.", 500, true);
            }

            $routerPath = trim($route['path'], "/"); // Trim slashes
            $pathExploded = explode("/", $routerPath); // Explode route with slashes

            $pathParameters = $this->getParametersFromUrl($pathExploded); // Extract parameters from route path

            if ($pathCalled == $this->getUrlCleaned($routerPath)) { // If request URL == a route path referred in routes.yml

                // Explode controller from route.yml
                $explodedController = explode("::", $route['controller']);

                // Extract classname with namespace
                $className = $explodedController[0];

                // Extract method name
                $methodName = $explodedController[1];

                $class = new $className(); // Initialize object from classname

                $associatedParameters = $this->associateParameters($class, $methodName, $pathParameters);

                (new $class(...Dependencies::getClassDependencies($class)))->$methodName(...$associatedParameters);

                return;
            }
        }
    }

    /**
     * Load API routes from routes.yml.
     *
     * This method return an array of all API routes.
     *
     * If something is wrong, false is returned.
     *
     * @return false|mixed
     */
    private function loadApiRoutes()
    {
        $routeFile = $this->config['PATH_CLASS'] . "api/routes.yaml";

        if(!file_exists($routeFile)) {
            Response::resp('Internal error with API routing. Please contact administrator.', 500, false);
            return false;
        }

        try {
            $routes = Yaml::parse(file_get_contents($routeFile));
        } catch (\Exception $exception) {
            Response::resp($exception, 500, false);
            return false;
        }

        return $routes;
    }

    /**
     * Get parameters from route.yml paths and extract them.
     *
     * @param array $pathExploaded
     *
     * @return array
     */
    private function getParametersFromUrl(array $pathExploaded): array
    {
        $parameters = [];

        foreach ($pathExploaded as $key => $value) {
            $matched = preg_match('({.*})', $value, $matches);

            if ($matched) {
                $matches = str_replace("{", "", $matches);
                $matches = str_replace("}", "", $matches);

                if ($this->request->query()->get($matched[0]))
                {
                    $parameters[$matches[0]] = $this->request->query()->get($matched[0]);
                }
            }
        }

        return $parameters;
    }

    /**
     * Clean URL from parameters and trim slashed.
     *
     * Sometime we need cleaned URL without parameters.
     *
     * @param $url
     *
     * @return string
     */
    public function getUrlCleaned($url):string
    {
        $matched = preg_match('({.*})', $url, $param);

        if ($matched) {
            return trim(str_replace($param, "", $url), "/");
        }

        return $url;
    }

    /**
     * Associate route parameters to method parameters.
     *
     * Parameters form routes.yml need to be ordered with method order.
     *
     * @param $class
     * @param string $method
     * @param array $parameters
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function associateParameters($class, string $method, array $parameters):array
    {
        $orderedParameters = [];

        $m = new \ReflectionMethod($class, $method);

        foreach ($m->getParameters() as $mk => $mparam) {
            $mParamName = $mparam->name;

            if (isset($parameters[$mParamName])) {
                $orderedParameters[$mk] = $parameters[$mParamName];
            }
        }

        return $orderedParameters;
    }

    public function notFound()
    {
        http_response_code(404);
        header('HTTP/1.0 404 page not found');
        require $this->config['PATH_FILES'] . "404.php";
    }
}
