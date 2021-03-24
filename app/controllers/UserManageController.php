<?php


namespace App\Controller;


class UserManageController extends Controller
{
    public function index(): void
    {
        $this->render('user/manage.html.twig');
    }
}
