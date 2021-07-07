<?php


namespace App\Api;

use App\Core\App;
use App\Core\Database\EloquentDriver;
use App\Model\Role;
use App\Utility\Response;

/**
 * Class RoleApi
 * @package App\Api
 * @author Moreau Eloïse
 * @version 1.0
 */
class RoleApi
{
    private Response $response;

    public function __construct(Response $response)
    {
       $this->response = $response;
    }

    /**
     * Get all apps from database.
     */
    public function index()
    {

        $this->response
            ->setBodyContent(Role::all())
            ->send();
    }
}
