<?php


namespace App\Api;

use App\Model\Formation;
use App\Model\FormationRepository;
use App\Utility\Response;

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
    public function getAll()
    {
        $this->response
            ->setBodyContent(Formation::all())
            ->send();
    }
}
