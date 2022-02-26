<?php


namespace App\Core;


use Exception;

class Request
{
    const TYPE_API = 'API';

    const TYPE_WEB = 'WEB';

    const METH_GET = 'GET';

    const METH_POST = 'POST';

    /**
     * @var string
     */
    public string $type;

    /**
     * @var mixed|string
     */
    public string $uri;

    /**
     * @var array
     */
    private array $query;

    /**
     * @var array
     */
    private array $request;

    /**
     * @var string
     */
    private string $lastMethod;

    public function __construct()
    {
        $this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        $this->type = (mb_strpos($this->uri, 'api')) ? self::TYPE_API : self::TYPE_WEB;
    }

    /**
     * Store query parameters and secure them.
     *
     * @return $this
     */
    public function query($escapeHTML = true):Request
    {
        $this->query = $_GET;
        $escapeHTML && array_walk_recursive($this->query, '\App\Core\Request::escapeHTML');
        $this->lastMethod = self::METH_GET;
        return $this;
    }

    /**
     * @return $this
     */
    public function request($escapeHTML = true):Request
    {
        $this->request = $_POST;
        $escapeHTML && array_walk_recursive($this->request, '\App\Core\Request::escapeHTML');
        $this->lastMethod = self::METH_POST;
        return $this;
    }

    /**
     * Return query parameter or request data.
     *
     * @param string $param Query parameter or request data.
     * @param mixed $default Default value if parameter does not exist.
     *
     * @return bool|mixed
     *
     * @throws Exception
     */
    public function get(string $param, $default = false)
    {
        if (!isset($this->lastMethod)) {
            throw new Exception('Expect query or request before.');
        }

        switch ($this->lastMethod) {
            case self::METH_GET:
                return (isset($this->query[$param])) ? $this->query[$param] : $default;
                break;
            case self::METH_POST:
                return (isset($this->request[$param])) ? $this->request[$param] : $default;
                break;
        }
    }

    /**
     * @return $this|array
     * @throws Exception
     */
    public function all()
    {
        if (!isset($this->lastMethod)) {
            throw new Exception('Expect query or request before.');
        }

        switch ($this->lastMethod) {
            case self::METH_GET:
                return $this->query;
                break;
            case self::METH_POST:
                return $this->request;
                break;
        }
    }

    public static function escapeHTML(&$value)
    {
        $value = htmlspecialchars($value);
    }

    public static function decodeHtmlSpecialChars(&$value)
    {
        $value = htmlspecialchars_decode($value);
    }

    /**
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
     * @return string|null
     */
    public function getToken(): ?string
    {
        $header = getallheaders();

        if ( !isset($header['Authorization']) || substr($header['Authorization'], 0, 7) !== 'Bearer ') {
            return null;
        }

        return trim(str_replace("Bearer", "", $header['Authorization']));
    }

    /**
     * Return request remote address.
     *
     * @return false|mixed
     */
    public function getRemoteAdress()
    {
        if (!isset($_SERVER['REMOTE_ADDR'])) {
            return false;
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}
