<?php
namespace App\Utility;

class Response {

    /**
     * Encode data to JSON
     * @param Mixed $data Data to encode
     */
    public static function json($data) {
        header('Content-type: application/json');
        echo json_encode($data);
    }

    /**
     *
     * @param string $message
     * @param int $code
     */
    public static function resp(string $message, int $code = 200)
    {
        http_response_code($code);
        header('HTTP/1.0 Error');
        self::json($message);
    }
}
