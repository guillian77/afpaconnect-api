<?php


namespace App\Controller;


use App\Core\Session;
use Exception;

class LogoutController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Session $session):void
    {
        $session->remove('user');

        $this->redirect('home');
    }
}
