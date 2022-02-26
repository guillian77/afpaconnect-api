<?php

namespace App\Api;

use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

/**
 * API to get all users.
 *
 * @UsersApi
 * @package API\User
 * @author Aufrère Guillian
 * @version 1.0.0
 * @example test
 */
class UsersApi
{
    /**
     * Get all users from database.
     * Passwords will not be shown in results.
     *
     * @param UserRepository $userRepository (DI) UserRepository object.
     * @param Response $response (DI) Response object.
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
