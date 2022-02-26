<?php

namespace Tests;

use App\Core\Conf;
use App\Utility\StatusCode;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private $publicKey;
    private $jwt;
    private Client $client;

    /**
     * @throws GuzzleException
     */
    public function setUp(): void
    {
        $publicKey = file_get_contents(dirname(__DIR__)."/storage/certs/afpanier_public.key");

        $this->client = new Client();

        $response = $this->client->request("POST", Conf::get('tld') . "/api/auth", [
            'form_params' => [
                'issuer' => 'APP_AFPANIER',
                'public_key' => $publicKey
            ]
        ]);

        $response = $response->getBody()->getContents();
        $this->jwt = json_decode($response)->content;
        $this->publicKey = $publicKey;
    }


    /**
     * @group api
     * @group token
     */
    public function testAuth()
    {
        $jwt = JWT::decode($this->jwt, $this->publicKey, [
            'RS256',
            'HS256'
        ]);

        $this->assertEquals("afpaconnect", $jwt->iss);
    }


    /**
     * @group api
     * @group register
     */
    public function testRegister()
    {
        $client = new Client();

        $response=  $client->request("POST", Conf::get('tld') . "/api/register", [
            'form_params' => [
                'issuer' => 'APP_AFPANIER',
                'username' => 'pro_admin@mail.fr',
                'password' => 'test',
                'role_id' => '1,2,3'
            ],
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());
        $this->assertEquals(StatusCode::USER_REGISTER_ALREADY, $response->code);
    }

    /**
     * @throws GuzzleException
     */
    public function tokenDataProvider(): array
    {
        $response = $this->client->request("POST", Conf::get('tld') . "/api/auth", [
            'form_params' => [
                'issuer' => 'afpanier',
                'public_key' => $this->publicKey
            ]
        ]);

        $response = $response->getBody()->getContents();

        return [
            [
                'jwt' => json_decode($response)->content,
                'public-key' => $this->publicKey
            ]
        ];
    }

    /**
     * @group api
     * @dataProvider apiPostDataProvider
     */
    public function testPostApiRoutes($url, $params, $expected) {
        $response=  $this->client->request("POST", Conf::get('tld') . "/api/".$url, [
            'form_params' => $params,
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());
        $this->assertEquals($expected, $response->code);
    }

    public function apiPostDataProvider(): \Generator
    {
        yield
        [
            'register',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => 'pro_admin@mail.fr',
                'password' => 'test',
                'role_id' => '1,2,3'
            ],
            StatusCode::USER_REGISTER_ALREADY,
        ];

        yield [
            'user-edit',
            [
                'issuer' => 'APP_AFPANIER',
                'uid' => '1',
                'beneficiary' => '123456788',
                'firstname' => 'test',
                'email' => 'test@test.fr',
                'phone' => '0102030405',
                'center' => '1',
                'financial' => '1',
                'address' => '9 rue du test',
                'complementAddress' => 'test',
                'zip' => 'test',
                'city' => 'test',
                'country' => 'test',
                'gender' => '1',
            ],
            StatusCode::REQUEST_SUCCESS,
        ];
    }


    /**
     * @group api
     * @group login
     * @dataProvider apiDataProvider
     */
    public function testLogin($url, $params, $expected)
    {
        $response=  $this->client->request("GET", Conf::get('tld') . "/api/". $url, [
            'query' => $params,
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());
        $this->assertEquals($expected, $response->code);

    }
    public function apiDataProvider(): \Generator
    {
        yield [
            'login',
            'params' => [
                'issuer' => 'APP_AFPANIER',
                'username' => '123456789',
                'password' => 'iojarire',
                'role_id' => '1,2,3'
            ],
            StatusCode::USER_LOGIN_BAD_PASSWORD
        ];
    }
}
