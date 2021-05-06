<?php


namespace App\Api;


use App\Model\UserModel;
use App\Utility\Response;

class User
{
    /**
     * @var UserModel
     */
    private UserModel $userModel;

    /**
     * @var Response
     */
    private Response $response;

    public function __construct(UserModel $userModel, Response $response)
    {
        $this->userModel = $userModel;
        $this->response = $response;
    }

    public function getAll()
    {
        $user = $this->userModel->findAll();
        $this->response
            ->setBodyContent($user)
            ->send()
        ;
    }
}
