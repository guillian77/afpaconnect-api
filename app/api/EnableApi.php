<?php

namespace App\Api;

use App\Core\JsonWebToken;
use App\Core\Request;
use App\Model\App;
use App\Model\Role;
use App\Model\UserRepository;
use App\Utility\Mailer;
use App\Utility\Response;
use App\Utility\StatusCode;
use App\Utility\Valid;
use Exception;

/**
 * @EnableApi
 * @package App\Api
 * @author Aufrère Guillian
 * @version 1.0
 */
class EnableApi
{
    private UserRepository $userRepository;
    private Request $request;
    private Response $response;
    private Valid $valid;
    private JsonWebToken $jwt;
    private Mailer $mailer;

    public function __construct(
        UserRepository $userRepository,
        Request $request,
        Response $response,
        Valid $valid,
        JsonWebToken $jwt,
        Mailer $mailer
    )
    {
        $this->userRepository = $userRepository;
        $this->request = $request;
        $this->response = $response;
        $this->valid = $valid;
        $this->jwt = $jwt;
        $this->mailer = $mailer;
    }

    /**
     * Enable an account form an activation code.
     *
     * - Verify parameters (username/activationCode).
     * - Check user exist with username and activation code.
     * - Update password.
     * - Update user/app/role.
     *
     * @throws Exception
     */
    public function enable ()
    {
        /*
         * Get and check request parameters.
         */
        $username = $this->request->get('username');
        $requestActivationCode = $this->request->get('activation_code');
        $roleIds = $this->request->get('role_id');

        $this->valid->has($username, "<username>");
        $this->valid->has($requestActivationCode, "<activation_code>");
        $this->valid->has($roleIds, "<role> (value: 1,2,3)");

        /*
         * User exist in local database ?
         */
        $user = $this->userRepository->findOneByUsernames($username);

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
         * Is user is in registering mode ?
         */
        $localActivationCode = $user->activation_code;
        if (!$localActivationCode) {
            $this->response
                ->setStatusCode(StatusCode::USER_ENABLE_CODE_NOT_FOUND)
                ->setStatusMessage("No activation_code exist for this user.")
                ->setBodyContent($user)
                ->send(200, true);
        }

        /*
         * Is activation code from request same with local ?
         */
        if ($localActivationCode !== $requestActivationCode) {
            $this->response
                ->setStatusCode(StatusCode::USER_ENABLE_CODE_INVALID)
                ->setStatusMessage("Specified activation_code is not valid.")
                ->setBodyContent($user)
                ->send(200, true);
        }

        /*
         * Update user password with temp password.
         */
        $tempPassword = $user->password_temp;
        if (!$tempPassword) {
            $this->response
                ->setStatusCode(StatusCode::USER_ENABLE_NO_TEMP_PASSWORD)
                ->setStatusMessage("No password_temp found locally for this user. Something has been wrong.")
                ->setBodyContent($user)
                ->send(200, true);
        }

        $user->password = $tempPassword;

        /*
         * Update user/app/role.
         */
        $app = App::where(
            'tag',
            '=',
            $this->jwt->getIssuer()
        )->first();

        $roles = Role::whereIn('id', explode(",", $roleIds))->get();

        $newRoles = [];
        foreach ($roles as $index => $role) {
            $newRoles[$index]['app_id'] = $app->id;
            $newRoles[$index]['user_id'] = $user->id;
            $newRoles[$index]['role_id'] = $role->id;
        }

        $user->roles()->attach($newRoles);

        /*
         * Reset registering mode.
         */
        $user->activation_code = null;
        $user->password_temp = null;

        /*
         * Send email for account activation and verification.
         */
        $emailSent = $this->mailer
            ->setTargetEmail($user->getUsername())
            ->setTargetLastName($user->lastname)
            ->setSubject("Bienvenue sur " . $app->name)
            ->setLayout('email/enable.html.twig', [
                'user' => $user,
                'apps' => App::where('tag', '!=', $app->tag)->get(),
                'registerApp' => $app->name
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
                ->setStatusCode(StatusCode::USER_ENABLE_FAILURE)
                ->setStatusMessage('Unable to enable user.')
                ->send(200, true);
        }

        $this->response
            ->setStatusCode(StatusCode::USER_ENABLE_SUCCESS)
            ->setStatusMessage('User has been enabled successfully.')
            ->setBodyContent($user)
            ->send(200);

    }
}