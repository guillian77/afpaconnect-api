<?php
namespace App\Middleware;

use App\Core\Controller;
use App\Core\Request;
use App\Utility\Response;
use Exception;
use Firebase\JWT\JWT;
use function App\Core\dd;

class JsonWebToken extends Controller
{
    const CERT_TYPE_PUBLIC = 'public';
    const CERT_TYPE_PRIVATE = 'private';

    public function verify()
    {
        // TODO: Don't allow all request from local. This is not secure. Found an other way. Maybe Token CSRF can be great.

        if (Authenticate::isLogged() || trim($this->request->url, "/") == "api/auth")
        {
            return;
        }

        $publicKey = $this->getCert(self::CERT_TYPE_PUBLIC);
        $bearer = Request::getBearerToken();

        try {
            $jwt = JWT::decode($bearer, $publicKey, ['RS256', 'HS256']);
        } catch (Exception $e) {
            Response::resp($e->getMessage(), 400, true);
        }
    }

    /**
     * Get certificate string chain.
     *
     * Type should be specified to know if public or private certificate is chose.
     *
     * @param string $type Use these class constant.
     *
     * @return false|string
     */
    public function getCert(string $type)
    {
        $certsPath = $this->config['PATH_SSL']; // Define certificates path
        $certFilePath = $certsPath . $this->getIssuer() . "_". $type . ".key";

        if (!file_exists($certFilePath)) { // Check public key file exist
            Response::resp('Oups, contact administrator. Something went wrong.', 404, true);
        }

        return file_get_contents($certFilePath);
    }

    /**
     * Find issuer
     *
     * @return mixed
     */
    public function getIssuer()
    {
        if ( // Check issuer has been sent
            (!isset($this->request->post['issuer']) || empty($this->request->post['issuer'])) &&
            (!isset($this->request->get['issuer']) || empty($this->request->get['issuer']))
        ) {
            Response::resp("I need to know who is talking to me. Please specify an issuer.", 400, true);
        }

        // Define issuer
        if (!isset($this->request->post['issuer']) || empty($this->request->post['issuer'])) {
            return $this->request->get['issuer'];
        } else {
            return $this->request->post['issuer'];
        }
    }
}