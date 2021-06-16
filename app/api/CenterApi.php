<?php


namespace App\Api;


use App\Model\Center;
use App\Model\CenterRepository;
use App\Utility\Response;

/**
 * Class CenterApi
 * @package App\Api
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
    public function getAll()
    {
        $this->response
            ->setBodyContent(Center::all())
            ->send();
    }
}
