<?php

/**
 * Class Sender | fichier sender.php
 *
 * @package AfpaTicket Project
 * @subpackage Curl sender
 * @author @Afpa Lab Team - Guillian Aufrère
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 */
class Sender
{
    /**
     * Post
     *
     * @param string $url
     * @param array $data
     * @return object
     */
    public static function post(string $url,array $data):object
    {
        // Transform array data to a query string
        $query = http_build_query($data, '', '&');

        // Concat query parameters with URL
        $url = $url . "?" . $query;

        // Init curl
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);

        // Send request  and catch response
        $response = curl_exec($ch);

        // Close curl channel
        curl_close($ch);

        // Convert json string to a standard PHP array
        return json_decode($response);
    }
}