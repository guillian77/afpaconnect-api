<?php
namespace App\Controller;

use App\Core\Controller;

class User_manage extends Controller
{
    public function __construct()
    {
        $this->render("user_manage");
    }
}