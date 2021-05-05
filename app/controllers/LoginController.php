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
use App\Model\UserModel;

class LoginController extends Controller
{
    private Session $session;
    private Request $request;
    private UserModel $userModel;
   
    private $identifier;
    private $password;



    public function __construct(Session $session, Request $request, UserModel $userModel)
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
        if ($this->isValid()) 
        {
            $this->redirect('user.manage');
        } else {
            $this->redirect('home');
        }
    }


    private function isValid()
    {
        if( !$this->formIsValid()) 
        {
            return false;
        } 

        $userQueried = $this->userModel->findOneByUsername($this->identifier);
        
        if(!$userQueried) 
        {
            $errors['identifier'] = 'Numéro de matricule inexistant';
            $this->session->set('error.login', $errors);
            return false;
        }
        
        $passwordQueried = $userQueried["user_password"];

        if($this->passwordIsValid($passwordQueried))
        {
            $this->session->set('uid', $userQueried["id_user"]);
            return true; 
        }

        return false;
        
    }

    private function formIsValid(): bool
    {
 

        if (!isset($this->identifier) || empty($this->identifier))
        {
            $errors['identifier'] = 'Identifiant de connexion manquant.';
        }

        if (!isset($this->password) || empty($this->password))
        {
            $errors['password'] = 'Mot de passe manquant.';
        }

        if (isset($errors)) 
        {
            $this->session->set('error.login', $errors);
            return false;
        }

        return true;
    }


    private function passwordIsValid($passwordQueried) : bool 
    {
        if(password_verify($this->password, $passwordQueried)) 
        {
            return true; 
        } 

        $errors['password'] = 'Mot de passe erroné';       
        $this->session->set('error.login', $errors);
        return false;

    }

    /**
     * Reset errors stored in session.
     */
    private function resetErrors()
    {
        $this->session->remove('error.login');
    }
}
