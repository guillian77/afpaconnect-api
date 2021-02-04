<?php
namespace App\Api;

use App\Core\Controller;
use App\Utility\Response;
use App\Service\User as UserService;
use function App\Core\dd;

class User extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Allow user login from external app.
     */
    public function login()
    {
        if (!isset($this->request->get['user']['username'])) {
            Response::resp("Unknow user username", 403);
            return;
        } else if (!isset($this->request->get['user']['password'])) {
            Response::resp("Unknow user password", 403);
            return;
        } else if (!isset($this->request->get['user']['beneficiary'])) {
            Response::resp("Unknow user beneficiary", 403);
            return;
        } else if (!isset($this->request->get['app']['name'])) {
            Response::resp("Unknow app name", 403);
            return;
        } else if (!isset($this->request->get['app']['token'])) {
            Response::resp("Unknow app token", 403);
            return;
        } else if($this->request->get['app']['token'] != "123456789") {
            Response::resp("Token is not granted or already used", 403);
            return;
        }

        $userService = new UserService();
        $user = $userService->getUser($this->request->get['user']['username']);

        if ( !isset($user[0]) ) {
            Response::resp("No user found", 403);
            return;
        }

        Response::json($user[0]);
    }

    public function register()
    {
        dd($this->request);
    }
}
