<?php


namespace Tests;


use App\Utility\StatusCode;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class ApiUserTest extends BaseApiControllerTest
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return \Generator
     */
    public function apiDataProvider(): \Generator
    {
        yield [
            'user',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => '123456789',
            ],
            StatusCode::USER_REGISTERED,
        ];
        yield [
            'user',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => '12345678',
            ],
            StatusCode::USER_NOT_FOUND,
        ];
        yield [
            'user',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => 'pro_unregistered_user@mail.fr',
            ],
            StatusCode::USER_NOT_REGISTERED,
        ];
        yield [
            'user',
            [
                'issuer' => 'APP_AFPANIER',
            ],
            StatusCode::MISSING_REQUEST_PARAMETER,
        ];
    }
}
