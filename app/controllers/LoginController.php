<?php


namespace App\Controller;


class LoginController extends Controller
{
    public $pageTitle = "Connexion";

    public function index():void
    {
        $this->render('user/login', [
            'appTitle' => "Mon titre de page",
            'test' => "<script>alert('Salut les gens')</script>"
        ]);
    }
}
