<?php

namespace Tests;

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
        $this->publicKey = file_get_contents(dirname(__DIR__)."/storage/certs/afpanier_public.key");

        $this->client = new Client();

        $response = $this->client->request("POST", "http://127.0.0.1:8000/api/auth", [
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
        $response=  $this->client->request("GET", "http://127.0.0.1:8000/api/". $url, [
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