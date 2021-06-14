<?php


namespace App\Core;


use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;
use Firebase\JWT\JWT;

class JsonWebToken
{
    const PUBLIC_URIs = [
        'api/auth'
    ];

    /**
     * @var Certificate
     */
    private Certificate $cert;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var string|null
     */
    private ?string $bearer = null;

    /**
     * @var string|null
     */
    private ?string $issuer = null;

    private Response $response;

    public function __construct(Certificate $cert, Request $request, Response $response)
    {
        $this->cert = $cert;

        $this->request = $request;

        $this->bearer = $this->request->getToken();

        $this->response = $response;

        $this->issuer = $this->getIssuer();
    }

    public function checkToken()
    {
        if ($this->isPublicUri()) {
            return;
        }

        try {
            JWT::decode($this->bearer, $this->cert->getCertificate($this->issuer, Certificate::TYPE_PUBLIC), [
                'RS256',
                'HS256'
            ]);
        } catch (Exception $e) {
            $this->response
                ->setStatusCode(StatusCode::TOKEN_FAILURE)
                ->setStatusMessage($e->getMessage())
                ->send(400, true)
            ;
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getIssuer(): string
    {
        /** Check issuer has been sent */
        if (
            !$this->request->request()->get('issuer') &&
            !$this->request->query()->get('issuer')
        ) {
            $this->response
                ->setStatusCode(StatusCode::REQUEST_MISSING_ISSUER)
                ->setStatusMessage("Please specify an issuer.")
                ->send(400, true);
        }

        /** Define issuer */
        if (!$this->request->request()->get('issuer')) {
            return $this->request->query()->get('issuer');
        } else {
            return $this->request->request()->get('issuer');
        }
    }

    /**
     * URi is accessible without a token or not.
     *
     * @return bool|false|int
     */
    private function isPublicUri()
    {

        $match = false;

        foreach (self::PUBLIC_URIs as $public) {

            $public = str_replace('/', '\/', $public);

            $match = preg_match('/'.$public.'/', $this->request->uri);

        }

        return $match;
    }
}