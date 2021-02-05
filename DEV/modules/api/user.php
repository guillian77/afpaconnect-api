<?php

namespace App\Api;

use App\Service\User as UserService;
use App\Utility\Upload;
use App\Core\Controller;
use App\Utility\Response;
use function App\Core\dd;

class User extends Controller
{
    /**
     * @var \App\Service\User $UserService
     */
    private $UserService;

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
        // Load User service
        $this->UserService = new UserService();
        $this->VARS_HTML = $this->UserService->VARS_HTML;

    }

    /**
     * Get all users.
     */
    public function get()
    {
        $users = $this->UserService->getUsers();

        if (!$users)
        {
            http_response_code(404);
            Response::json("Impossible de récupérer la liste des utilisateurs.");
            return;
        }

        Response::json($users);
    }

    public function upload(){
        if(isset($_FILES["fileToUpload"]['type'])){

            $isXLS = ($_FILES["fileToUpload"]['type'] === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" ||
            $_FILES["upload_user"]['type'] === "application/vnd.ms-excel"  ? true : false);

            if(isset($this->VARS_HTML['center']) && $this->VARS_HTML['center'] != null && $isXLS){
                $tmp_name = $_FILES["fileToUpload"]["tmp_name"];
                $content = Upload::parse($tmp_name);
                echo json_encode($content,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE);
            }
            
        }
    }

    public function add() {
        $users = json_decode(htmlspecialchars_decode($this->VARS_HTML['uploaded_user']));
        
        foreach($users as $user){
            $this->UserService->insert($user);
        }

        Response::resp('200');
    }

    /**
     * Allow user login from external app.
     */
    public function login()
    {
        if (!isset($this->request->get['user']['identifier'])) {
            Response::resp("Unknow user identifier", 403);
            return;
        } else if (!isset($this->request->get['user']['password'])) {
            Response::resp("Unknow user password", 403);
            return;
        } else if (!isset($this->request->get['app']['name'])) {
            Response::resp("Unknow app name", 403);
            return;
        } else if (!isset($this->request->get['app']['token'])) {
            Response::resp("Unknow app token", 403);
            return;
        } else if($this->request->get['app']['token'] != "123456789") {
            Response::resp("Token is not granted or already used", 403);
            return;
        }

        $userService = new UserService();
        $user = $userService->getUser($this->request->get['user']['identifier']);

        if ( !isset($user[0]) ) {
            Response::resp("No user found", 403);
            return;
        }

        Response::json($user[0]);
    }

    public function register()
    {
        dd($this->request);
    }
}
