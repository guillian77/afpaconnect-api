<?php


namespace App\Api;


use App\Core\Request;
use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;

/**
 * Class UserApi
 * @package App\Api
 */
class UserApi
{
    /**
     * Get one user from his username.
     *
     * @throws Exception
     */
    public function getOneByUsername(UserRepository $repository, Response $response, Request $request): void
    {
        $username = $request->query()->get('username');

        if (!$username) {
            $response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage('A username should be specified.')
                ->send(200, true);
        }

        $user = $repository->findOneByUsernames($username);

        if (!$user) {
            $response
                ->setStatusCode(StatusCode::USER_NOT_FOUND)
                ->setStatusMessage('No user found.')
                ->send(200, true);
        }

        if (!$user->password) {
            $response
                ->setStatusCode(StatusCode::USER_NOT_REGISTERED)
                ->setStatusMessage("User exist but is not registered yet.")
                ->setBodyContent($user)
                ->send(200, true);
        }

        $response
            ->setStatusCode(StatusCode::USER_REGISTERED)
            ->setStatusMessage("User exist and is registered.")
            ->setBodyContent($user)
            ->send(200);
    }
}
