<?php

/**
 * Class Response | file response.php
 *
 * @package AfpaTicket Project
 * @author @Afpa Lab Team - Guillian Aufrère
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 */

class Response {

    /**
     * Encode data to JSON
     * @param Mixed $data Data to encode
     */
    public static function json($data) {
        echo json_encode($data);
    }
}