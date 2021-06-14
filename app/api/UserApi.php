<?php


namespace App\Api;


use App\Core\Request;
use App\Model\UserRepository;
use App\Utility\Response;
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
            $this->response->setStatusMessage('A username should be specified.')->send(200, true);
        }

        $user = $this->repository->findOneByUsernames($username);

        $this->response
            ->setBodyContent($user)
            ->send()
        ;
    }

    /**
     * Get all users.
     */
    public function getAll()
    {
        $user = $this->repository->findAll(['password']);
        $this->response
            ->setBodyContent($user)
            ->send()
        ;
    }
}
