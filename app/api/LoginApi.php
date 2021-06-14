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
                ->setStatusCode('005')
                ->setStatusMessage('Missing information. Password or username is empty.')
                ->send(200, true);
        }

        $user = $this->userModel->findOneByUsernames($username);

        if (!$user) {
            $this->response
                ->setStatusCode('004')
                ->setStatusMessage('User not found.')
                ->send(200, true);
        }

        $check = password_verify($password, $user->password);

        if (!$check) {
            $this->response
                ->setStatusCode('003')
                ->setStatusMessage('Wrong password.')
                ->send(200, true);
        }

        $this->response
            ->setStatusCode("001")
            ->setStatusMessage("User logged successfully.")
            ->setBodyContent($user)
            ->send()
        ;
    }
}