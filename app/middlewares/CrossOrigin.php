<?php


namespace App\Middleware;


use App\Core\Conf;
use App\Core\Request;
use App\Utility\Response;
use App\Utility\StatusCode;

class CrossOrigin
{
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Check if request come from same network.
     */
    public function sameOrigin()
    {
        $whitelist = Conf::get('authorized_address');

        if (in_array($this->request->getRemoteAdress(), $whitelist)) {
            return;
        }

        $this->response
            ->setStatusCode(StatusCode::ORIGIN_UNAUTHORIZED_HOST)
            ->setStatusMessage("You are not allowed to emit request to this API.")
            ->send(403, true);
    }
}