<?php


namespace App\Api;


use App\Model\Center;
use App\Model\CenterRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

/**
 * Class CenterApi
 * @package API
 * @author Aufrère Guillian
 * @version 1.0
 */
class CenterApi
{
    private Response $response;
    private CenterRepository $centerRepository;

    public function __construct(Response $response, CenterRepository $centerRepository)
    {
        $this->response = $response;
        $this->centerRepository = $centerRepository;
    }

    /**
     * Get all centers from database.
     */
    public function index()
    {
        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent(Center::all())
            ->send();
    }
}
