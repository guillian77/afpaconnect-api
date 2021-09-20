<?php


namespace App\Api;

use App\Model\Formation;
use App\Model\FormationRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

/**
 * Class FormationApi
 * @package App\Api
 * @author Lucas Campillo
 * @version 1.0
 */
class FormationApi
{
    private Response $response;
    private FormationRepository $formationRepository;

    public function __construct(Response $response, FormationRepository $formationRepository)
    {
        $this->response = $response;
        $this->formationRepository = $formationRepository;
    }

    /**
     * Get all formation from database.
     */
    public function index()
    {
        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent(Formation::all())
            ->send();
    }
}
