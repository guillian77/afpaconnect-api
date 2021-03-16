<?php
namespace App\Controller;

class UserLogout
{
    public function __construct()
    {
        unset($_SESSION['user']['uid']);
        header('Location: UserLogin');
    }
}
