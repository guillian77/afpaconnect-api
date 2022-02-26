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
use App\Utility\Valid;
use Exception;
use Throwable;

/**
 * API to register a user from an external app.
 * @RegisterApi
 * @package API\User
 * @author Aufrère Guillian
 * @version 1.0.0
 */
class RegisterApi
{
    private UserRepository $userModel;
    private Request $request;
    private Response $response;
    private Mailer $mailer;
    private JsonWebToken $jwt;
    private Valid $valid;

    public function __construct(
        UserRepository $repository,
        Request $request,
        Response $response,
        Mailer $mailer,
        JsonWebToken $jwt,
        Valid $valid
    )
    {
        $this->userModel = $repository;
        $this->request = $request;
        $this->response = $response;
        $this->mailer = $mailer;
        $this->jwt = $jwt;
        $this->valid = $valid;
    }

    /**
     * Register a user.
     *
     * - Check request parameters.
     * - Check if user is find.
     *
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

        $this->valid->has($username, "<username>");
        $this->valid->has($password, "<password>");

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

        // User not exist ?
        $this->checkUserState($user); // Execution can be break here.

//        if ($user && !empty($user->password)) {
//            $this->response
//                ->setStatusCode(StatusCode::USER_REGISTER_ALREADY)
//                ->setStatusMessage('User already registered.')
//                ->setBodyContent($user)
//                ->send(200);
//        }

        $user->password_temp = $password;


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
                'apps' => App::where('tag', '!=', $app->tag)->get(),
                'registerApp' => $app->name
            ])
            ->setToErrorLog("Activation code is: $activationCode")
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
    private function checkUserState(?User $user):void
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
    }
}