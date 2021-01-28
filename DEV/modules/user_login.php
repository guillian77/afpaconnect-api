<?php

class User_login
{
    public function __construct()
    {
        if (isset($_POST['username']))
        {
            $_SESSION['user']['id'] = 1;
            header('Location: user_manage');
        }
    }
}