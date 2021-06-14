<?php


namespace App\Api;


use App\Core\Certificate;
use App\Core\Conf;
use App\Core\Request;
use App\Utility\Response;
use Exception;
use Firebase\JWT\JWT;

class Auth
{
    /**
     * @throws Exception
     */
    public function auth(Certificate $certificate, Request $request, Response $response)
    {
        $issuer = $request->request()->get('issuer');

        $private_key = ($certificate->getCertificate($issuer, Certificate::TYPE_PRIVATE));
        $public_key = $request->request()->get('public_key');

        if (!$public_key) {
            $response
                ->setStatusCode('000')
                ->setStatusMessage('Key public_key not found. You should send it under Body:form-data.')
                ->send(200, true);
        }

        $publicKeyId = \openssl_get_publickey($public_key);
        \openssl_sign("test", $signature, openssl_get_privatekey($private_key));

        $rsaChecked = \openssl_verify("test", $signature, $publicKeyId);

        if ($rsaChecked != 1) {
            $response
                ->setStatusMessage("Not allowed. Please contact administrator to be allowed.")
                ->send(403, true);
        }

        $payload = [
            'iss' => 'afpaconnect',
            'aud' => $issuer,
            'exp' => time() + Conf::get('token_duration')
        ];

        $jwt = JWT::encode($payload, $private_key, 'RS256');

        $response
            ->setBodyContent($jwt)
            ->send(200, true);

    }
}