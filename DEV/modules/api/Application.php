<?php

namespace App\Api;

use App\Service\Application as ApplicationService;
use App\Utility\Upload;
use App\Core\Controller;
use App\Utility\Response;
use App\Core\Request;
use Exception;

class Application extends Controller
{
    /**
     * @var \App\Service\Application $ApplicationService
     */
    private $ApplicationService;

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
        // Load Application service
        $this->ApplicationService = new ApplicationService();
        $this->VARS_HTML = $this->ApplicationService->VARS_HTML;
    }

    /**
     * Gets applications list, all roles for each application 
     * if user_id is set in params : gets all roles by application for specific user
     * 
     */
    public function getRolesAppsUser() {
        
        
        if (!null == $this->request->query()->get('id')) {
            $id = $this->request->query()->get('id');
            $response['user_roles'] = $this->ApplicationService->getRolesByUser($id);
        }
            
        $response['apps'] = $this->ApplicationService->getApplications();
        $response['roles'] = $this->ApplicationService->getRolesByApp();

        if (!$response)
        {
            http_response_code(404);
            Response::json("Impossible de récupérer la liste des utilisateurs.");
            return;
        } 
            Response::json($response);
    }

    /**
     * Get applications
     * 
     * unuse
     */
    public function getApplications() {

     
        $apps = $this->ApplicationService->getApplications();
     
        if (!$apps)
        {
            http_response_code(404);
            Response::json("Impossible de récupérer la liste des utilisateurs.");
            return;
        } 
            Response::json($apps);
    }



    /**
     * Get applications
     * 
     * unuse
     */
    public function getRolesByApp() {

     
        $roles = $this->ApplicationService->getRolesByApp();
     
        if (!$roles)
        {
            http_response_code(404);
            Response::json("Impossible de récupérer la liste des utilisateurs.");
            return;
        } 
            Response::json($roles);
    }

}