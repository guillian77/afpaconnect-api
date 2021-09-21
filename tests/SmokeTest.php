<?php


namespace Tests;


use App\Utility\StatusCode;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class SmokeTest extends TestCase
{
    /**
     * @group smoke
     * @dataProvider smokeDataProvider
     */
    public function testSmoke($url, $expected) {
        $client = new Client();

        $response=  $client->request("GET", "http://127.0.0.1:8000/".$url);

        $this->assertEquals($expected, $response->getStatusCode());
    }

    public function smokeDataProvider(): array
    {
        return [
            ['', StatusCode::USER_LOGIN_SUCCESS],
            ['login', StatusCode::USER_LOGIN_SUCCESS],
            ['logout', StatusCode::USER_LOGIN_SUCCESS],
            ['user-manage', StatusCode::USER_LOGIN_SUCCESS],
            ['user-upload', StatusCode::USER_LOGIN_SUCCESS],
            ['role-manage', StatusCode::USER_LOGIN_SUCCESS],
            ['/register/enable', StatusCode::USER_LOGIN_SUCCESS],
        ];
    }
}
