<?php

class User_logout
{
    public function __construct()
    {
        // Destroy SESSION user ID
        unset($_SESSION['user']['uid']);
        header('Location: user_login');
    }
}
