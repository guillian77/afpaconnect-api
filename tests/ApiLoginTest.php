<?php

namespace Tests;

use App\Utility\StatusCode;

class ApiLoginTest extends BaseApiControllerTest
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
            'login',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => '123456789',
                'password' => 'test',
            ],
            StatusCode::USER_LOGIN_SUCCESS,
        ];
        yield [
            'login',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => '123456789',
                'password' => 'bad_password',
            ],
            StatusCode::USER_LOGIN_BAD_PASSWORD,
        ];
        yield [
            'login',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => 'unknown-user',
                'password' => 'test',
            ],
            StatusCode::USER_NOT_FOUND,
        ];
        yield [
            'login',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => 'pro_lucas@mail.fr',
                'password' => 'test',
            ],
            StatusCode::USER_LOGIN_NOT_ACTIVATED,
        ];
        yield [
            'login',
            [
                'issuer' => 'APP_AFPANIER',
                'username' => 'pro_unregistered_user@mail.fr',
                'password' => 'test',
            ],
            StatusCode::USER_NOT_REGISTERED,
        ];
    }
}
