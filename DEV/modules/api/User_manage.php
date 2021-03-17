<?php
namespace App\Api;

use App\Core\Controller;
use App\Service\User;
use App\Utility\Response;

class user_manage extends Controller
{
    /**
     * user_manage constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $users = $user->getUsersSecured();

        Response::json($users);
    }
}
