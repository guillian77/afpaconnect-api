<?php


namespace App\Controller;


class UserUploadController extends Controller
{
    public function index(): void
    {
        $this->render('user/upload.html.twig');
    }
}
