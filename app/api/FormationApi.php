<?php


namespace App\Api;

use App\Core\Request;
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
    private Request $request;

    public function __construct(Response $response, FormationRepository $formationRepository, Request $request)
    {
        $this->response = $response;
        $this->formationRepository = $formationRepository;
        $this->request = $request;
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

    /**
     * Get all formation from database.
     * @throws \Exception
     */
    public function getByUser()
    {
        $userId = $this->request->query()->get('userId');

        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($this->formationRepository->getFormationsByUser($userId))
            ->send();
    }
}
