<?php


namespace Tests;


use App\Utility\StatusCode;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    // TODO: Create seeds for tests.
    // TODO: Make multiple test case.

    /**
     * @group api
     * @group token
     * @dataProvider tokenDataProvider
     */
    public function testAuth($jwt, $publicKey)
    {
        $jwt = JWT::decode($jwt, $publicKey, [
            'RS256',
            'HS256'
        ]);

        $this->assertEquals("afpaconnect", $jwt->iss);
    }

    /**
     * @group api
     * @group register
     * @dataProvider tokenDataProvider
     */
    public function testRegister($jwt, $publicKey)
    {
        $client = new Client();

        $response=  $client->request("POST", "http://127.0.0.1:80/api/register", [
            'form_params' => [
                'issuer' => 'afpanier',
                'username' => '123456789',
                'password' => 'test',
            ],
            'headers' => [
                'Authorization' => "Bearer " . $jwt
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());

        $this->assertEquals(StatusCode::USER_REGISTER_ALREADY, $response->code);
    }

    public function tokenDataProvider()
    {
        $publicKey = file_get_contents(dirname(__DIR__)."/storage/certs/afpanier_public.key");

        $client = new Client();

        $response = $client->request("POST", "http://127.0.0.1:80/api/auth", [
            'form_params' => [
                'issuer' => 'afpanier',
                'public_key' => $publicKey
            ]
        ]);

        $response = $response->getBody()->getContents();

        return [
            [
                'jwt' => json_decode($response)->content,
                'public-key' => $publicKey
            ]
        ];
    }
}
