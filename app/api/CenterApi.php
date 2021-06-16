<?php


namespace App\Api;


use App\Model\Center;
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

    public function __construct(Response $response)
    {
        $this->response = $response;
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
