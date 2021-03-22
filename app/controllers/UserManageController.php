<?php


namespace App\Controller;


class UserManageController extends Controller
{
    public string $pageTitle = "Gestion utilisateurs";

    public function index(): void
    {
        $this->render('user/user_manage');
    }
}
