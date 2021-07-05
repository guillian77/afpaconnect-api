<?php


namespace App\Api;

use App\Model\App;
use App\Model\AppRepository;
use App\Model\Center;
use App\Model\CenterRepository;
use App\Utility\Response;

/**
 * Class AppApi
 * @package App\Api
 * @author Aufrère Guillian
 * @version 1.0
 */
class AppApi
{
    private Response $response;
    private AppRepository $appRepository;

    public function __construct(Response $response, AppRepository $appRepository)
    {
        $this->response = $response;
        $this->repository = $appRepository;
    }

    /**
     * Get all apps from database.
     */
    public function getAll()
    {
        $this->response
            ->setBodyContent(App::all())
            ->send();
    }

    /**
     * Get all apps from database.
     */
    public function getRoles()
    {
        $this->response
            ->setBodyContent(App::with('appRoles')->get())
            ->send();
    }
}
