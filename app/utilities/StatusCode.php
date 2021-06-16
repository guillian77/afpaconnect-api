<?php


namespace App\Utility;


class StatusCode
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL
    |--------------------------------------------------------------------------
    */
    const GENERAL_FAILURE           = "000";
    const MISSING_REQUEST_PARAMETER = "001";
    const REQUEST_SUCCESS           = "003";
    const REQUEST_MISSING_ISSUER    = "004";
    const TOKEN_FAILURE             = "005";
    const CERTIFICATE_NOT_FOUND     = "006";

    /*
    |--------------------------------------------------------------------------
    | USERS GLOBAL
    |--------------------------------------------------------------------------
    */
    const USER_NOT_FOUND            = "100";
    const USER_REGISTERED           = "101";
    const USER_NOT_REGISTERED       = "102";

    /*
    |--------------------------------------------------------------------------
    | USERS LOGIN
    |--------------------------------------------------------------------------
    */
    const USER_LOGIN_SUCCESS        = "200";
    const USER_LOGIN_FAILURE        = "201";
    const USER_LOGIN_BAD_PASSWORD   = "202";

    /*
    |--------------------------------------------------------------------------
    | USERS REGISTER
    |--------------------------------------------------------------------------
    */
    const USER_REGISTER_SUCCESS     = "300";
    const USER_REGISTER_FAILURE     = "301";
    const USER_REGISTER_ALREADY     = "302";
}