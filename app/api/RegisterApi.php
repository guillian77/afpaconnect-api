<?php


namespace App\Api;


use App\Core\Request;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;
use Faker\Factory;
use Throwable;

/**
 * Class RegisterApi
 * @package App\Api
 * @author Aufrère Guillian
 * @version 1.0
 */
class RegisterApi
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
     * Register a user.
     *
     * @throws Throwable
     */
    public function register()
    {
        $username = $this->request->get('username');
        $password = $this->request->get('password');

        $this->checkParameter($username, "username");
        $this->checkParameter($password, "password");

        /** @var User $user */
        $user = $this->userModel->findOneByUsernames($username);

        $this->checkUserState($user);

        $user->password = $password;

        try { // Try to save user.
            $user->saveOrFail();
        } catch (Exception $exception) { // Show available table columns to user.
            $this->response
                ->setStatusCode(StatusCode::USER_REGISTER_FAILURE)
                ->setStatusMessage('Unable to register user.')
                ->send(200, true);
        }

        $this->response
            ->setStatusCode(StatusCode::USER_REGISTER_SUCCESS)
            ->setStatusMessage('User has been registered successfully.')
            ->setBodyContent($user)
            ->send(200);
    }

    /**
     * Check if user is already registered or not.
     *
     * @param User $user User
     */
    private function checkUserState(User $user):void
    {
        if (!empty($user->password)) {
            $this->response
                ->setStatusCode(StatusCode::USER_REGISTER_ALREADY)
                ->setStatusMessage('User is already registered. You have to use route /api/login instead.')
                ->setBodyContent($user)
                ->send(200, true);
        }
    }

    /**
     * Check request parameter presence.
     *
     * @param string $key
     * @param string $name
     * @param string $code
     * @return void
     */
    private function checkParameter(string $key, string $name, string $code = "000"):void
    {
        if ($key) {
            return;
        }

        $this->response
            ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
            ->setStatusMessage("Key $name should be specified.")
            ->send(200, true);
    }
}