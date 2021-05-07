<?php


namespace App\Api;


use App\Core\Request;
use App\Model\UserRepository;
use App\Utility\Response;

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

    public function register()
    {
        // TODO: Implement this feature.
    }
}