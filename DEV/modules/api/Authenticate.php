<?php


namespace App\Api;


use App\Core\Controller;
use App\Middleware\JsonWebToken;
use App\Utility\Response;
use Firebase\JWT\JWT;

class Authenticate extends Controller
{
    public function login()
    {
        $privateKey = (new JsonWebToken())->getCert(JsonWebToken::CERT_TYPE_PRIVATE);
        $publicKey = $this->request->post['public_key'];

        $publicKeyId = \openssl_get_publickey($publicKey);
        \openssl_sign("test", $signature, openssl_get_privatekey($privateKey));
        $rsaChecked = \openssl_verify("test", $signature, $publicKeyId);

        if ($rsaChecked === 1)
        {
            $payload = [
                'iss' => 'afpaconnect',
                'aud' => 'afpaticket',
                'exp' => time() + 600 // 10 minutes
            ];

            $jwt = JWT::encode($payload, $privateKey, 'RS256');
            Response::resp($jwt, 200, true);
        }

        Response::resp('Not allowed. Please contact administrator to be allowed.', 403, true);
    }
}