<?php


namespace Tests;


use App\Core\App;
use App\Core\Conf;
use App\Utility\StatusCode;
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

        App::get();

        $tld = Conf::get('tld');
        $response=  $client->request("GET", "$tld/".$url);

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
