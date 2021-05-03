<?php
namespace App\Utility;

class Response {

    /**
     * Output JSON encoded data.
     *
     * @param Mixed $data Data to encode
     */
    public static function json($data)
    {
        header('Content-type: application/json');
        echo json_encode($data);
    }

    /**
     * Output JSON encoded data and a status code.
     *
     * By default, status code is set to 200.
     *
     * Code execution can be stopped has needed.
     *
     * @param string $message
     * @param int $code
     * @param bool $stop stop code execution ?
     */
    public static function resp($message, int $code = 200, bool $stop = false)
    {
        http_response_code($code);
        header('HTTP/1.0 '.$code);
        self::json($message);

        if ($stop) { die(); }
    }
}
