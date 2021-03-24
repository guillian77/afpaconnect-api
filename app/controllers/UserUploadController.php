<?php


namespace App\Controller;


class UserUploadController extends Controller
{
    public string $pageTitle = "Ajout utilisateur";

    public function index(): void
    {
        $this->render('user/upload.html.twig');
    }
}
