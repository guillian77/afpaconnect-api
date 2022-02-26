<?php

namespace App\Api;

use App\Model\User;
use App\Utility\Response;
use App\Utility\StatusCode;

/**
 * API to get user table columns.
 * @UserTableApi
 * @package API\User
 * @author Aufrère Guillian
 * @version 1.0.0
 */
class UserTableApi
{
    public function table(Response $response)
    {
        /** @var User $user */
        $user = User::first();

        $columns = array_keys($user->getOriginal());

        $response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setStatusMessage('List of user table columns.')
            ->setBodyContent($columns)
            ->send();
    }
}