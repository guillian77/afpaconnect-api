<?php

namespace Tests;

use App\Core\App;
use App\Core\Conf;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class BaseApiControllerTest extends TestCase
{
    public $publicKey;
    public $jwt;
    public $client;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setUp(): void
    {
        App::get(); // Boot App.

        $this->publicKey = file_get_contents(dirname(__DIR__)."/storage/certs/afpanier_public.key");

        $this->client = new Client();

        $response = $this->client->request("POST", Conf::get('tld') . "/api/auth", [
            'form_params' => [
                'issuer' => 'afpanier',
                'public_key' => $this->publicKey
            ]
        ]);

        $response = $response->getBody()->getContents();
        $this->jwt = json_decode($response)->content;
    }

    /**
     * @group api
     * @dataProvider apiDataProvider
     */
    public function testApi($url, $params, $expected)
    {
        $response=  $this->client->request("GET", Conf::get('tld') . "/api/". $url, [
            'query' => $params
            ,
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());
        $this->assertEquals($expected, $response->code);
    }
}