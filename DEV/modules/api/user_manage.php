<?php
namespace App\Api;

use App\Core\Controller;
use App\Service\User;
use App\Utility\Response;
use function App\Core\dd;

class user_manage extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $userService = new User();
        $users = $userService->getUsersSecured();

        Response::json($users);
    }
}
