<?php


namespace App\Controller;


class LogoutController extends Controller
{
    public function index():void
    {
        $this->render('user/logout');
    }
}
