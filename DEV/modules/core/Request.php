<?php
namespace App\Core;


class Request
{
    public $url;
    public $base;

    public $controller;
    public $params;

    public $get;
    public $post;

    public function __construct()
    {
        $this->defineBaseURL();
        $this->controller = "user_login"; // Default controller called

        if (isset($_SERVER['PATH_INFO']))
        {
            $this->url = trim($_SERVER['PATH_INFO'], "/");
            $exploded = explode("/", $this->url);

            $this->controller = $exploded[0];
            $this->params = array_slice($exploded, 1);

            $this->url = htmlspecialchars($this->url);

            foreach ($this->params as $k => $v) {
                $this->params[$k] = htmlspecialchars($v);
            }
        }

        foreach ($_GET as $k => $v) {
            $this->get[$k] = htmlspecialchars($v);
        }

        foreach ($_POST as $k => $v) {
            $this->post[$k] = htmlspecialchars($v);
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
}
