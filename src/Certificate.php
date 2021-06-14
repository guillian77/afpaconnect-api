<?php


namespace App\Core;


use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;

class Certificate
{
    const TYPE_PUBLIC   = 'public';

    const TYPE_PRIVATE  = 'private';

    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getCertificate(string $name, string $type)
    {
        $certPath = STORAGE.'certs/'.$name.'_'.$type.'.key';

        if (!file_exists($certPath)) {
            $this->response
                ->setStatusCode(StatusCode::CERTIFICATE_NOT_FOUND)
                ->setStatusMessage("Certificate not found")
                ->send(404, true);
        }

        return file_get_contents($certPath);
    }
}
