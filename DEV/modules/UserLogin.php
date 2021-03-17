<?php
namespace App\Controller;

use App\Core\Controller;
use App\Middleware\Authenticate;
use App\Service\User;

class UserLogin extends Controller
{
    /** @var array $errors Errors */
    public $errors = [];

    public function __construct()
    {
        parent::__construct();

        // Disallow this page is user is already logged.
        if (Authenticate::isLogged()) { $this->redirect('UserManage'); }

        // Load User service
        $User = new User();

        // Check if form is submitted
        if ($this->request->request()->get('submitted') && $this->checkForm()) {
            $user = $User->getUser($this->request->request()->get('identifier'));

            if (!isset($user[0])) {
                array_push($this->errors, "Les identifiants semblent incorrects. Veuillez essayer avec d'autres identifiants.");
            } else {
                $checked = password_verify($this->request->request()->get('password'), $user[0]['user_password']);

                if ($checked)
                {
                    $this->connectUser($user);
                }
            }
        }

        $errors = $this->errors;
        $this->render("user_login", compact(['errors']));
    }

    /**
     * Check
     */
    public function checkForm()
    {
        if (!$this->request->request()->get('identifier') || empty($this->request->request()->get('identifier'))) {
            array_push($this->errors, "Numéro de matricule inexistant.");
        }

        if (!$this->request->request()->get('password') || empty($this->request->request()->get('password'))) {
            array_push($this->errors, "Mot de passe inexistant.");
        }

        return empty($this->errors);
    }

    public function connectUser($user)
    {
        $_SESSION['user']['uid'] = $user[0]['id_user'];
        $_SESSION['user']['center'] = $user[0]['id_center'];
        header('Location: UserManage');
    }
}
