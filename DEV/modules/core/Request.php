<?php
namespace App\Core;

/**
 * Class Request : Singleton
 *
 * @package App\Core
 *
 * @author Aufrère Guillian
 */
class Request
{
    /** @var Request $_instance */
    private static $_instance;

    /** @var string The URL */
    public $url;

    /** @var string $base The root of the URL */
    public $base;

    /** @var false|string[] $exploded Exploded URL */
    public $exploded;

    /** @var mixed|string $controller Controller called by the URL */
    public $controller;

    /** @var false|string[] $params Parameters set inside URL just after the controller: /ControllerName/param1/param2 */
    public $params;

    /** @var array $query $_GET data */
    private $query;

    /** @var array $request $_POST data */
    private $request;

    /** @var array $session $_SESSION data */
    private $session;

    /** @var string $lastMethod Determine last method used. */
    private $lastMethod;

    const METH_POST = "POST";
    const METH_GET  = "GET";
    const METH_SESSION  = "SESSION";

    /** @var false|mixed Bearer token  */
    public $token;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Request();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $this->token = self::getBearerToken(); // Get bearer token

        $this->defineBaseURL();
        $this->controller = "UserLogin"; // Default controller called

        if (isset($_SERVER['PATH_INFO']))
        {
            $this->url = trim($_SERVER['PATH_INFO'], "/");
            $this->exploded = explode("/", $this->url);

            if (!$this->isApiRequest($this->exploded))
            {
                $this->controller = $this->exploded[0];
                $this->params = array_slice($this->exploded, 1);
            }
        }
    }

    /**
     * Check if request is send in XHR or not.
     *
     * @return bool
     */
    public function isXhrRequest():bool
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Check if request is send to API or not.
     *
     * Detect if there is /api/ at the beginning of the URL.
     *
     * @param mixed $explodedURL
     *
     * @return bool
     */
    public function isApiRequest($explodedURL):bool
    {
        if (isset($explodedURL[0]) && !empty($explodedURL[0]) && $explodedURL[0] == "api") {
            return true;
        }

        return false;
    }

    /**
     * Define application base URL.
     */
    public function defineBaseURL()
    {
        $url = "http://";
        if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
        {
            $url = "https://";
        }

        $url .= $_SERVER['SERVER_NAME'];

        $config = (App::getInstance())->configuration();

        $this->base = $url . ":" . $config['PORT'] . $config["BASE_HREF"];
        $this->url = $this->base . $this->controller;
    }

    /**
     * Get Bearer token from request header.
     *
     * If application is requested in API, we need to verify this token.
     *
     * @return mixed
     */
    public static function getBearerToken()
    {
        $header = getallheaders();

        if ( !isset($header['Authorization']) || substr($header['Authorization'], 0, 7) !== 'Bearer ') {
            return false;
        }

        return trim(str_replace("Bearer", "", $header['Authorization']));
    }

    /**
     * Check if request come from same IP address.
     *
     * @return bool
     */
    public static function isSameOrigin()
    {
        if (
            isset($_SERVER['REMOTE_ADDR']) &&
            (
                $_SERVER['REMOTE_ADDR'] == "::1" ||
                $_SERVER['REMOTE_ADDR'] == "127.0.0.1" ||
                $_SERVER['REMOTE_ADDR'] == "localhost"
            )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get query parameters come from request.
     *
     * @param bool $secure Securize external data or not.
     *
     * @return $this
     */
    public function query(bool $secure = true):Request
    {
        $this->query = $_GET;
        ($secure) && array_walk_recursive($this->query, '\App\Core\Request::escapeHTML');
        $this->lastMethod = self::METH_GET;
        return $this;
    }

    /**
     * Get request parameters come from request payload.
     *
     * @param bool $secure Securize external data or not.
     *
     * @return $this
     */
    public function request(bool $secure = true):Request
    {
        $this->request = $_POST;
        ($secure) && array_walk_recursive($this->request, '\App\Core\Request::escapeHTML');
        $this->lastMethod = self::METH_POST;
        return $this;
    }

    /**
     * Get session data.
     *
     * @param bool $secure
     *
     * @return $this
     */
    public function session(bool $secure = false):Request
    {
        $this->session = $_SESSION;
        ($secure) && array_walk_recursive($this->session, '\App\Core\Request::escapeHTML');
        $this->lastMethod = self::METH_SESSION;
        return $this;
    }

    /**
     * Get one parameter from query, request or session properties.
     *
     * @param $param
     *
     * @return false|mixed
     */
    public function get($param)
    {
        switch ($this->lastMethod) {
            case self::METH_GET:
                return (isset($this->query[$param])) ? $this->query[$param] : false;
                break;
            case self::METH_POST:
                return (isset($this->request[$param])) ? $this->request[$param] : false;
                break;
            case self::METH_SESSION:
                return (isset($this->session[$param])) ? $this->session[$param] : false;
                break;
        }
    }

    /**
     * Get all parameters from query, request or session properties.
     *
     * @return mixed
     */
    public function all()
    {
        switch ($this->lastMethod) {
            case self::METH_GET:
                return $this->query;
                break;
            case self::METH_POST:
                return $this->request;
                break;
            case self::METH_SESSION:
                return $this->session;
                break;
        }
    }

    /**
     * Escape HTML tags from values.
     *
     * @param $value
     */
    public static function escapeHTML(&$value)
    {
        $value = htmlspecialchars($value);
    }

    /**
     * Decode encoded HTML tags.
     *
     * @param $value
     */
    public static function decodeHtmlSpecialChars(&$value)
    {
        $value = htmlspecialchars_decode($value);
    }
}
