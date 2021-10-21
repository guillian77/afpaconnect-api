<?php

namespace App\Utility;

class Valid
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Check key presence.
     *
     * @param string $key
     * @param string $name
     * @param string $code
     * @return void
     */
    public function has(string $key, string $name, string $code = "000"):void
    {
        if ($key) {
            return;
        }

        $this->response
            ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
            ->setStatusMessage("Key $name should be specified.")
            ->send(200, true);
    }
}