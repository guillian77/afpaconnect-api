<?php


namespace App\Controller;


use App\Core\Request;
use App\Model\User;
use Exception;

class RegisterController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Enable an account.
     *
     * This method buy link coming from activation email.
     *
     * /register/enable - GET ?activation_code=55481e66
     *
     * @throws Exception
     */
    public function enable()
    {
        $activationCode = $this->request->query()->get('activation_code');

        if (!$activationCode) {
            $this->renderError("Le code d'activation n'a pas pu être identifié.", true);
        }

        /** @var User $user */
        $user = User::
            where('activation_code', '=', $activationCode)
            ->get()
            ->first();

        if (is_null($user)) {
            $this->renderError("Aucun utilisateur ne correspond à votre code d'activation.", true);
        }

        $user->activation_code = null;

        $user->update();

        $this->render('external/register.enable.html.twig', [
            'user' => $user
        ]);
    }
}
