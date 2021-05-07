<?php


namespace App\Api;


use App\Core\Request;
use App\Model\UserRepository;
use App\Utility\Response;
use Exception;

/**
 * Class Login
 * @package App\Api
 * @author Aufrère Guillian
 * @version 1.0
 */
class LoginApi
{
    private UserRepository $userModel;

    private Request $request;

    private Response $response;

    public function __construct(UserRepository $repository, Request $request, Response $response)
    {
        $this->userModel = $repository;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Login a user from an external app.
     *
     * Route: /api/login Method: GET
     *
     * @throws Exception
     */
    public function login()
    {
        $username = $this->request->query()->get('username');
        $password = $this->request->query()->get('password');

        if (!$username || !$password) {
            $this->response
                ->setStatusCode('000') // TODO: Replace with good status code
                ->setStatusMessage('Username or password are missing.') // TODO: Replace with good message
                ->send(200, true);
        }

        $user = $this->userModel->findOneByUsernames($username); // TODO: Hydrate/add jointures on this request.

        if (!$user) {
            $this->response
                ->setStatusCode('000') // TODO: Replace with good status code
                ->setStatusMessage('User not found.') // TODO: Replace with good message
                ->send(200, true);
        }

        // TODO: Check password is correct with password_verify

        $this->response
            ->setStatusCode("000") // TODO: Replace with good status code
            ->setBodyContent($user)
            ->send()
        ;
    }
}