<?php
namespace App\Service;

use App\Core\Service;
use App\Utility\Response;
use PDOStatement;

class Application extends Service
{
    /**
     * @var array $VARS_HTML Secured POST, GET, SESSION.
     */
    public $VARS_HTML;

    public  function __construct()
    {
        parent::__construct();
    }


    /**
     * Get all Applications
     */

    public function getApplications() {
    
        
        return $this->oBdd->getSelectDatas("SELECT * FROM `apps`");
    } 

    /**
     * Get App and Role by User id.
     *
     * @param string $id
     * @return array
     */
    public function getRolesByUser($id) {
        $param = [
            'id' => $id
        ];
        
        return $this->oBdd->getSelectDatas("SELECT * FROM `apps__users__roles` WHERE id_user = '@id';", $param);
    } 
    

    /**
     * Get All roles by application
     * 
     * @return array
     */
    public function getRolesByApp()  {

        return $this->oBdd->getSelectDatas("SELECT DISTINCT r.id_role, r.role_name, a.id_application, a.app_name FROM roles as r, apps as a, apps__users__roles as aur WHERE a.id_application = aur.id_application AND r.id_role = aur.id_role");
 
    }

}