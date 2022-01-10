<?php


namespace App\Api;


use App\Core\Request;
use App\Model\AppUserRole;
use App\Model\User;
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
    private UserRepository $repository;

    private Response $response;

    private Request $request;

    public function __construct(UserRepository $repository, Response $response, Request $request)
    {
        $this->repository = $repository;
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * Get one user from his username.
     *
     * @throws Exception
     */
    public function getOneByUsername()
    {
        $username = $this->request->query()->get('username');

        if (!$username) {
            $this->response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage('A username should be specified.')
                ->send(200, true);
        }

        $user = $this->repository->findOneByUsernames($username);

        if (!$user) {
            $this->response
                ->setStatusCode(StatusCode::USER_NOT_FOUND)
                ->setStatusMessage('No user found.')
                ->send(200, true);
        }

        if (!$user->password) {
            $this->response
                ->setStatusCode(StatusCode::USER_NOT_REGISTERED)
                ->setStatusMessage("User exist but is not registered yet.")
                ->setBodyContent($user)
                ->send(200, true);
        }

        $this->response
            ->setStatusCode(StatusCode::USER_REGISTERED)
            ->setStatusMessage("User exist and is registered.")
            ->setBodyContent($user)
            ->send(200);
    }

    /**
     * Get all users.
     */
    public function index()
    {
        $users = $this->repository->findAllWithout(['password']);


        if (!$users) {
            $this->response
                ->setStatusCode(StatusCode::GENERAL_FAILURE)
                ->setStatusMessage("Unable to get all users.")
                ->send(200);
        }

        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($users)
            ->send()
        ;
    }
}
