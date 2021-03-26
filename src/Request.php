<?php


namespace App\Core;


class Request
{
    public string $type;

    public string $uri;

    const TYPE_API = 'API';

    const TYPE_WEB = 'WEB';

    public function __construct()
    {
        $this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        $this->type = $this->isXhrRequest() ? self::TYPE_API : self::TYPE_WEB;
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
}
