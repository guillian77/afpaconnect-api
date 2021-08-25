<?php


namespace App\Controller;

use App\Core\App as CoreApp;
use App\Core\Database\EloquentDriver;
use App\Core\Request;
use App\Model\App;
use App\Model\Role;
use App\Utility\Response;
use Exception;

/**
 * Class RoleController
 * @package App\Controller
 * @author Moreau Eloïse
 */

class RoleController extends Controller
{

    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }


    public function index(): void {
        $this->render('role/manage.html.twig');
    }

    /**
     * Create Roles 
     *
     * @return null
     */
    public function create() :void {
        $newAppRoles = $this->request->request()->all();
        if(!empty($newAppRoles['new_role_name']) && !empty($newAppRoles['new_role_tag'])) {
            $newRole = new Role();
            $newRole->name = $newAppRoles['new_role_name'];
            $newRole->tag = $newAppRoles['new_role_tag'];     
            try {
                $newRole->saveOrFail();
            } catch (Exception $e) {
                $this->response
                    ->setStatusMessage("Erreur" . $e)
                    ->send(400);
            }

        } else {
            $this->response
                    ->setStatusMessage("No content" )
                    ->send(204);
        }
        $this->redirect('role.manage');

    }


    /**
     * Edit Roles 
     *
     * @return null
     */
    public function edit() :void {
        $newAppRoles = $this->request->request()->all();
        foreach($newAppRoles as $key => $value) {
            if(str_starts_with($key,'role_')) {
                $currentRole = Role::whereId( explode('_',$key)[1])->first()->update(['name' => $value[0], 'tag' => $value[1]]);      
            }
        } 
        $this->redirect('role.manage');
    }


    /**
     * Edit Roles by App 
     *
     * @return null
     */
    public function appsRolesEdit(): void {

        $newAppRoles = $this->request->request()->all();
       
        // Clean all app roles before.
        foreach(App::all() as $app) {
            $app->appRoles()->sync([]);
        }

        //Register Roles By Apps
        foreach($newAppRoles as $key => $value) {
            if(str_starts_with($key,'app_role')) {
                $currentApp = App::whereId( explode('_',$key)[2])->first();
                $user_roles = [];
                foreach($value as $role_id) {
                    array_push($user_roles ,['app_id' => explode('_',$key)[2] , 'role_id' => $role_id ]);
                }
                $currentApp->appRoles()->sync($user_roles);
            }
        }
        $this->redirect('role.manage');
    }


   

}
