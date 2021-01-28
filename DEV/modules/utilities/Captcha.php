<?php

require "Sender.php";

/**
 * Class Sender | fichier sender.php
 *
 * @package AfpaTicket Project
 * @subpackage Curl sender
 * @author @Afpa Lab Team - Guillian Aufrère
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 */
class Captcha
{
    /**
     * Check captcha
     *
     * @return boolean TRUE if captcha is correct
     */
    public static function check(string $recaptchaResponse):bool
    {
        if ( !isset($recaptchaResponse) ) { return FALSE; }

        // Get configuration before
        $config = Configuration::getGlobalsINI();

        $payload = [
            'secret'    => $config['SERVER_KEY'],
            'response'  => $recaptchaResponse
        ];

        $response = Sender::post("https://www.google.com/recaptcha/api/siteverify", $payload);

        /**
         * API Response from Google
         *
         * {
         *      "success": true|false,
         *      "error-codes": [...]
         * }
         *
         * See https://developers.google.com/recaptcha/docs/verify
         */
        return $response->success;
    }
}