<?php
namespace App\Core;


use App\Utility\Response;

class Request
{
    /**
     * @var string The URL.
     */
    public $url;

    /**
     * @var string The root of the URL.
     */
    public $base;

    /**
     * @var array URL exploded.
     */
    public $exploded;

    public $controller;
    public $action;
    public $params;

    public $get;
    public $post;

    /**
     * @var string Bearer token
     */
    public $token;

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

        // TODO: secure GET, POST && FILE superglobals.

        $this->get = $_GET;
        $this->post = $_POST;
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

    public function defineBaseURL()
    {
        $url = "http://";
        if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
        {
            $url = "https://";
        }

        $url .= $_SERVER['SERVER_NAME'];

        $config = Configuration::get();

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
}
