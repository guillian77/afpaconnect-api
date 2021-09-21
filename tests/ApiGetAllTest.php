<?php

namespace Tests;

use App\Utility\StatusCode;

class ApiGetAllTest extends BaseApiControllerTest
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
        yield [ 'users', [ 'issuer' => 'APP_AFPANIER'], StatusCode::REQUEST_SUCCESS];
        yield [ 'centers', [ 'issuer' => 'APP_AFPANIER'], StatusCode::REQUEST_SUCCESS];
        yield [ 'financials', [ 'issuer' => 'APP_AFPANIER'], StatusCode::REQUEST_SUCCESS];
        yield [ 'formations', [ 'issuer' => 'APP_AFPANIER'], StatusCode::REQUEST_SUCCESS];
        yield [ 'roles', [ 'issuer' => 'APP_AFPANIER'], StatusCode::REQUEST_SUCCESS];
    }
}
