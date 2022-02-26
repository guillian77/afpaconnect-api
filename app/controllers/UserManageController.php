<?php


namespace App\Controller;

use App\Core\Request;
use App\Model\AppRole;
use App\Model\AppUserRole;
use App\Model\AppUserRoleRepository;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;
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

    /**
     * Edit user information.
     *
     * @param Response $response Response helper object.
     * @param UserRepository $userRepository The user repository.
     *
     * @return string
     *
     * @throws Exception
     */
    public function edit(Response $response, UserRepository $userRepository)
    {
        /*
         * Request working.
         */
        $userFromRequest = $this->request->request()->all();

        if (!$this->check($userFromRequest)) { // Form validation.
            $response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage('Missing or incorrect form parameters.')
                ->send(400, true);
        }

        /*
         * Get user from request.
         */
        $currentUser = $userRepository->findOneById($userFromRequest['id']);
        if (!$currentUser) {
            $response
                ->setStatusMessage('User not found with this ID.')
                ->setStatusCode(StatusCode::USER_NOT_FOUND)
                ->send(404, true);
        }

        /*
         * Update user from request data.
         */
        $currentUser->identifier = $userFromRequest['beneficiary'];
        $currentUser->lastname = $userFromRequest['lastname'];
        $currentUser->firstname = $userFromRequest['firstname'];
        $currentUser->mail2 = $userFromRequest['email'];
        $currentUser->phone = $userFromRequest['phone'];
        $currentUser->center_id = $userFromRequest['center'];
        $currentUser->financial_id = $userFromRequest['financial'];
        $currentUser->address = $userFromRequest['address'];
        $currentUser->complementAddress = $userFromRequest['complementAddress'];
        $currentUser->zip = $userFromRequest['zip'];
        $currentUser->city = $userFromRequest['city'];
        $currentUser->country = $userFromRequest['country'];
        $currentUser->gender = $userFromRequest['gender'];

        // Clean all user roles before.
        $currentUser->roles()->sync([]);
        $user_roles = [];

        // Assign roles to this user.
        foreach($userFromRequest as $key => $value) {
            if(str_starts_with($key,'app_role')) {
                foreach($value as $role_id) {
                    $user_roles[] = [
                        'app_id' => explode('_', $key)[2],
                        'user_id' => $userFromRequest['id'], 'role_id' => $role_id
                    ];
                }
            }
        } 

        $currentUser->roles()->sync($user_roles);

        /*
         * Try to update user and return response.
         */
        if (!$currentUser->update()) {
            $response
                ->setStatusCode('400')
                ->setStatusMessage("Erreur: l'utilisateur " . $currentUser->lastname . " " . $currentUser->lastname . " n'a pas pu être mis à jour.")
                ->send(400, true);
        }

        $response
            ->setStatusMessage('User updated successfully.')
            ->setStatusCode(StatusCode::USER_EDIT_SUCCESS)
            ->send();
    }

    /**
     * Check user data from form fields.
     *
     * @param array $userForm array of user form data.
     *
     * @return bool
     */
    public function check(array $userForm): bool
    {
        if (!$userForm['beneficiary'] || strlen($userForm['beneficiary']) > 20) {
            return false;
        }

        if (!$userForm['lastname'] || strlen($userForm['lastname']) > 255) {
            return false;
        }

        if (!$userForm['firstname'] || strlen($userForm['firstname']) > 255) {
            return false;
        }

        return true;
    }
}
