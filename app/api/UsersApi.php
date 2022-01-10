<?php

namespace App\Api;

use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

/**
 * @UsersApi
 *
 * @author Aufrère Guillian
 */
class UsersApi
{
    /**
     * Get all users from database.
     * Passwords are hidden.
     *
     * @return void
     */
    public function users(UserRepository $userRepository, Response $response)
    {
        $users = $userRepository->findAllWithout(['password']);


        if (!$users) {
            $response
                ->setStatusCode(StatusCode::GENERAL_FAILURE)
                ->setStatusMessage("Unable to get all users.")
                ->send(200);
        }

        $response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($users)
            ->send()
        ;
    }
}
