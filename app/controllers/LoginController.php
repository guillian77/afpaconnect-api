<?php


namespace App\Controller;


use App\Core\Request;
use App\Core\Session;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use App\Model\UserRepository;

class LoginController extends Controller
{
    private Session $session;
    private Request $request;
    private UserRepository $userModel;
   
    private $identifier;
    private $password;



    public function __construct(Session $session, Request $request, UserRepository $userModel)
    {
        $this->session = $session;
        $this->request = $request;
        $this->userModel = $userModel;
        $this->identifier = $this->request->request()->get("identifier");
        $this->password = $this->request->request()->get("password");
    }

    /**
     * Display login page.
     *
     * method: GET, path: /login
     *
     * @throws DependencyException
     * @throws NotFoundException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index():void
    {
        $this->render('user/login.html.twig', [
            'errors' => $this->session->get('error.login')
        ]);

        $this->resetErrors();
    }

    /**
     * Try to login a user.
     *
     * method: POST, path: /login
     *
     * @throws Exception
     */
    public function login()
    {
        if ($this->isValidUser())
        {
            $this->redirect('user.manage');
        } else {
            $this->redirect('home');
        }
    }


    private function isValidUser()
    {
        if( !$this->formIsValid()) {
            return false;
        } 

        $user = $this->userModel->findOneByUsernames($this->identifier);
        
        if(!$user) {
            $this->session->set('error.login', ['Numéro de matricule inexistant']);
            return false;
        }

        if(!$this->isValidPassword($user->password)) {
            return false;
        }

        $this->updateSession($user);

        return true;
    }

    private function formIsValid(): bool
    {
        if (!isset($this->identifier) || empty($this->identifier)) {
            $errors['identifier'] = 'Identifiant de connexion manquant.';
        }

        if (!isset($this->password) || empty($this->password)) {
            $errors['password'] = 'Mot de passe manquant.';
        }

        if (isset($errors)) {
            $this->session->set('error.login', $errors);
            return false;
        }

        return true;
    }


    /**
     * @param $password
     * @return bool
     */
    private function isValidPassword($password) : bool
    {
        if(password_verify($this->password, $password)) {
            return true; 
        } 

        $this->session->set('error.login', ['Mot de passe erroné']);

        return false;
    }

    /**
     * Reset errors stored in session.
     */
    private function resetErrors()
    {
        $this->session->remove('error.login');
    }

    private function updateSession($user)
    {
        $session = [];

        foreach ($user as $k => $u) {
            if (!strstr($k, 'passw')) {
                $session[$k] = $u;
            }
        }

        $this->session->set('user', $session);
    }
}
