<?php


namespace App\Controller;

use App\Core\Request;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Response;
use Exception;

class UserManageController extends Controller
{

    private UserRepository $repository;

    private Request $request;

    public function __construct(UserRepository $repository, Request $request)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    
    public function index(): void
    {
        $this->render('user/manage.html.twig');
    }

    public function edit(Response $response) {

        $newUser = $this->request->request()->all();

        $currentUser = User::whereId($newUser['uid'])->first(); 

        $currentUser->identifier = $newUser['beneficiary'];
        $currentUser->lastname = $newUser['lastname'];
        $currentUser->firstname = $newUser['firstname'];
        $currentUser->mailPerso = $newUser['email'];
        $currentUser->phone = $newUser['phone'];
        $currentUser->center_id = $newUser['center'];
        $currentUser->financial_id = $newUser['financial'];
        //TODO : USER ROLE EDIT

        try {
                $currentUser->saveOrFail();
            } catch (Exception $e) {
                $response
                    ->setStatusCode('400')
                    ->setStatusMessage("Erreur: l'utilisateur ".$currentUser->lastname ." ".$currentUser->lastname." n'a pas pu être mis à jour.")
                    ->send();
                return;
            }
               $this->redirect('user.manage');

    }
}
