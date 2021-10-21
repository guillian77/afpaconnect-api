<?php


namespace App\Controller;

use App\Core\Request;
use App\Model\AppRole;
use App\Model\AppUserRole;
use App\Model\AppUserRoleRepository;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Response;
use Exception;

class UserManageController extends Controller
{

    private UserRepository $repository;

    private Request $request;
    /**
     * @var AppUserRole
     */
    private AppUserRole $appUserRole;

    public function __construct(UserRepository $repository, AppUserRoleRepository $aur_repository, Request $request, AppUserRole $appUserRole)
    {
        $this->repository = $repository;
        $this->aur_repository = $aur_repository;
        $this->request = $request;
        $this->appUserRole = $appUserRole;
    }


    public function index(): void
    {
        $this->render('user/manage.html.twig');
    }

    public function edit(Response $response)
    {
        $newUser = $this->request->request()->all();

        $currentUser = User::whereId($newUser['uid'])->first();

        $currentUser->identifier = $newUser['beneficiary'];
        $currentUser->lastname = $newUser['lastname'];
        $currentUser->firstname = $newUser['firstname'];
        $currentUser->mail2 = $newUser['email'];
        $currentUser->phone = $newUser['phone'];


        $currentUser->center_id = $newUser['center'];
        $currentUser->financial_id = $newUser['financial'];
        $currentUser->address = $newUser['address'];
        $currentUser->complementAddress = $newUser['complementAddress'];
        $currentUser->zip = $newUser['zip'];
        $currentUser->city = $newUser['city'];
        $currentUser->country = $newUser['country'];
        $currentUser->gender = $newUser['gender'];

        // Clean all user roles before.
        
        $currentUser->roles()->sync([]);
        $user_roles = [];

        // Assign roles to this user.
        foreach($newUser as $key => $value) {
          
            if(str_starts_with($key,'app_role')) {
        
                
                foreach($value as $role_id) {
                    
                    array_push($user_roles,['app_id' => explode('_',$key)[2] , 'user_id' => $newUser['uid'], 'role_id' => $role_id ]);
                    
                } 
                
            }
 
            
        } 

        $currentUser->roles()->sync($user_roles);
        
        if (!$currentUser->update()) {
            $response
                ->setStatusCode('400')
                ->setStatusMessage("Erreur: l'utilisateur " . $currentUser->lastname . " " . $currentUser->lastname . " n'a pas pu être mis à jour.")
                ->send(400, true);
        }

        $this->redirect('user.manage');
    }
}
