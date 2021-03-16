<?php
namespace App\Controller;

use App\Core\Controller;
use App\Middleware\Authenticate;
use App\Service\User;
use function App\Core\dd;

class UserLogin extends Controller
{
    /**
     * @var array
     */
    public $VARS_HTML;

    /**
     * @var array
     */
    public $errors = [];

    public function __construct()
    {
        parent::__construct();

        // Disallow this page is user is already logged.
        if (Authenticate::isLogged()) { $this->redirect('UserManage'); }

        // Load User service
        $User = new User();
        $this->VARS_HTML = $User->VARS_HTML;

        // Check if form is submitted
        if (isset($this->VARS_HTML['submitted']) && $this->checkForm())
        {

            $user = $User->getUser($this->VARS_HTML['identifier']);

            if (!isset($user[0])) {
                array_push($this->errors, "Les identifiants semblent incorrects. Veuillez essayer avec d'autres identifiants.");
            } else {
                $checked = password_verify($this->VARS_HTML['password'], $user[0]['user_password']);

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
        if (!isset($this->VARS_HTML['identifier']) || empty($this->VARS_HTML['identifier'])) {
            array_push($this->errors, "Numéro de matricule inexistant.");
        }

        if (!isset($this->VARS_HTML['password']) || empty($this->VARS_HTML['password'])) {
            array_push($this->errors, "Mot de passe inexistant.");
        }

        return empty($this->errors);
    }

    public function connectUser($user)
    {
        $_SESSION['user']['uid'] = $user[0]['id_user'];
        header('Location: UserManage');
    }
}
