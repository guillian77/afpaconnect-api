<?php

class TokenVerifier
{
    public static function isAuthorized($request)
    {
        if ( !isset($request->token) )
        {
            http_response_code(403);
            return false;
        }

        if ( empty($request->token) )
        {
            http_response_code(403);
            return false;
        }

        return true;
    }
}
