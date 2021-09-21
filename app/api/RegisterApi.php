<?php


namespace App\Api;


use App\Core\JsonWebToken;
use App\Core\Request;
use App\Model\App;
use App\Model\Role;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Mailer;
use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;
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

    private Mailer $mailer;

    private JsonWebToken $jwt;

    public function __construct(
        UserRepository $repository,
        Request $request,
        Response $response,
        Mailer $mailer,
        JsonWebToken $jwt
    )
    {
        $this->userModel = $repository;
        $this->request = $request;
        $this->response = $response;
        $this->mailer = $mailer;
        $this->jwt = $jwt;
    }

    /**
     * Register a user.
     *
     * @throws Throwable
     */
    public function register()
    {
        /*
         * Get and check request parameters.
         */
        $username = $this->request->get('username');
        $password = $this->request->get('password');
        $roleIds = $this->request->get('role_id');

        $this->checkParameter($username, "<username>");
        $this->checkParameter($password, "<password>");
        $this->checkParameter($roleIds, "<role> (value: 1,2,3)");

        /*
         * Try to find user by usernames.
         */
        /** @var User $user */
        $user = $this->userModel->findOneByUsernames($username);

        /*
         * Check user states: already registered|not exist.
         */
        $app = App::where(
            'tag',
            '=',
            $this->jwt->getIssuer()
        )->first();

        $this->checkUserState($user, $app); // Execution can be break here.

        $user->password = $password;

        /*
         * Synchronize user with app and roles.
         */
        $roles = Role::whereIn('id', explode(",", $roleIds))->get();

        $newRoles = [];
        foreach ($roles as $index => $role) {
            $newRoles[$index]['app_id'] = $app->id;
            $newRoles[$index]['user_id'] = $user->id;
            $newRoles[$index]['role_id'] = $role->id;
        }

        $user->roles()->attach($newRoles);

        $userEmail = (empty($user->mail1)) ? $user->mail2 : $user->mail1;

        /*
         * Generate an activation code.
         */
        $activationCode = uniqid();

        $user->activation_code = $activationCode;

        /*
         * Send email for account activation and verification.
         */
        $emailSent = $this->mailer
            ->setTargetEmail($userEmail)
            ->setTargetLastName($user->lastname)
            ->setSubject("Confirmez votre inscription")
            ->setLayout('email/register.html.twig', [
                'activationCode' => $activationCode,
                'user' => $user,
                'apps' => App::where('tag', '!=', 'APP_AFPACONNECT')->get()
            ])
            ->send();

        if (!$emailSent) {
            $this->response
                ->setStatusCode(StatusCode::USER_REGISTER_FAILURE)
                ->setStatusMessage('Something went wrong. API is not able to send register email confirmation.')
                ->send(200, true);
        }

        try { // Try to save user.
            $user->update();
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
     * Check if user is already registered and if exist in local database.
     *
     * @param User|null $user L'utilisateur trouvé via le pseudonyme.
     */
    private function checkUserState(?User $user, ?App $app):void
    {
        /*
         * User exist in local database ?
         */
        if (!$user) {
            $message  = "User not found in our database.";
            $message .= "User presence should be verified before call this route.";
            $message .= "If user should exist. Contact administrator.";

            $this->response
                ->setStatusCode(StatusCode::USER_REGISTER_NOT_FOUND)
                ->setStatusMessage($message)
                ->setBodyContent($user)
                ->send(200, true);
        }

        /*
         * User is already on this app ?
         */
        if ($user->hasApp($app->id)) {
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