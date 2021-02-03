<?php
namespace App\Controller;

class User_logout
{
    public function __construct()
    {
        unset($_SESSION['user']['uid']);
        header('Location: user_login');
    }
}
