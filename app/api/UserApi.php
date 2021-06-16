<?php


namespace App\Api;


use App\Core\Request;
use App\Model\User;
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

    /**
     * Edit user.
     */

    public function edit() {

        $newUser = $this->request->request();
    
        $currentUser = User::whereId($newUser->get('uid'))->first();
   

        $currentUser->identifier = $newUser->get('beneficiary');
        $currentUser->lastname = $newUser->get('lastname');
        $currentUser->firstname = $newUser->get('firstname');
        $currentUser->mailPerso = $newUser->get('email');
        $currentUser->phone = $newUser->get('phone');
        $currentUser->center_id = $newUser->get('center');
        $currentUser->financial_id = $newUser->get('financial');
        //TODO : USER ROLE EDIT

        try {
                $currentUser->saveOrFail();
            } catch (Exception $e) {
                
                Response::resp("Erreur: l'utilisateur ".$currentUser->lastname ." ".$currentUser->lastname." n'a pas pu être mis à jour." , 400);
                return;
            }
//TODO : Error msg
        Response::resp(".", 200);

    }
}
