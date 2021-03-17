<?php


namespace App\Api;


use App\Core\Controller;
use App\Middleware\JsonWebToken;
use App\Utility\Response;
use Firebase\JWT\JWT;

class Authenticate extends Controller
{

    /**
     * Authenticate an external app.
     *
     * External app should send a public key.
     *
     * The public key will be verified with local private key.
     *
     * If private and public keys match. A JWT token is send in the response.
     *
     * @return Response
     */
    public function auth()
    {
        $private_key = (new JsonWebToken())->getCert(JsonWebToken::CERT_TYPE_PRIVATE);
        $public_key = $this->request->request()->get('public_key');

        $publicKeyId = \openssl_get_publickey($public_key);
        \openssl_sign("test", $signature, openssl_get_privatekey($private_key));
        $rsaChecked = \openssl_verify("test", $signature, $publicKeyId);

        if ($rsaChecked != 1)
        {
            Response::resp('Not allowed. Please contact administrator to be allowed.', 403, true);
        }

        $payload = [
            'iss' => 'afpaconnect',
            'aud' => 'afpaticket',
            'exp' => time() + 600 // 10 minutes
        ];

        $jwt = JWT::encode($payload, $private_key, 'RS256');
        Response::resp($jwt, 200, true);
    }
}