<?php

class Authenticate {

    /**
     * Check if user is admin
     * IF NOT: Don't display the page asked.
     */
    public static function isAdmin() {
        // TODO: REWORK

        // if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 1)
        // {
        //     header('Location: unallow');
        //     die();
        // }
    }
}