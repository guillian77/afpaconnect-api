<?php
namespace App\Utility;

class Response {
    /** @var string */
    private $statusMessage;

    /** @var int */
    private $statusCode;

    private $bodyContent;

    private int $jsonFlags = 0;

    /**
     * Output JSON encoded data.
     *
     * @param Mixed $data Data to encode.
     *
     * @deprecated Don't use static methods, call class directly.
     */
    public static function json($data)
    {
        header('Content-type: application/json');
        header('charset: utf-8');

        echo json_encode($data);
    }

    /**
     * Output JSON encoded data and a status code.
     *
     * By default, status code is set to 200.
     *
     * Code execution can be stopped has needed.
     *
     * @param mixed $message
     * @param int $code
     * @param bool $stop stop code execution ?
     *
     * @deprecated Don't use static methods, call class directly.
     */
    public static function resp($message, int $code = 200, bool $stop = false)
    {
        http_response_code($code);
        header('HTTP/1.0 '.$code);
        self::json($message);

        if ($stop) { die(); }
    }

    /**
     * Define JSON constants
     *
     * @link https://www.php.net/manual/en/json.constants.php
     *
     * @param $flags
     *
     * @return Response
     */
    public function setJsonFlags($flags): self
    {
        $this->jsonFlags = $flags;

        return $this;
    }

    /**
     * @return string
     */
    private function getStatusMessage(): ?string
    {
        return $this->statusMessage;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setStatusMessage(string $message): self
    {
        $this->statusMessage = $message;

        return $this;
    }

    /**
     * @return string
     */
    private function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setStatusCode(string $code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    private function getBodyContent()
    {
        return $this->bodyContent;
    }

    /**
     * @param mixed $bodyContent
     * @return $this
     */
    public function setBodyContent($bodyContent): self
    {
        $this->bodyContent = $bodyContent;

        return $this;
    }

    public function send(int $httpResponseCode = 200, bool $stop = false)
    {
        header('Content-type: application/json');
        header('charset: utf-8');

        http_response_code($httpResponseCode);

        header('HTTP/1.0 '.$httpResponseCode);

        echo json_encode([
            'code' => $this->getStatusCode(),
            'message' => $this->getStatusMessage(),
            'content' => $this->bodyContent,
        ], $this->jsonFlags);

        if ($stop) { die(); }
    }
}
