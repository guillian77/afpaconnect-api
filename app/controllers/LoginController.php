<?php


namespace App\Controller;


class LoginController extends Controller
{
    public function index():void
    {
        $this->render('user/login.html.twig', [

        ]);
    }
}
