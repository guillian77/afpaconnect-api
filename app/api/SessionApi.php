<?php


namespace App\Api;

use App\Core\Request;
use App\Model\Formation;
use App\Model\FormationRepository;
use App\Model\Session;
use App\Model\SessionRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

/**
 * Class FormationApi
 * @package App\Api
 * @author Lucas Campillo
 * @version 1.0
 */
class SessionApi
{
    private Response $response;
    private SessionRepository $sessionRepository;
    private Request $request;

    public function __construct(Response $response, Request $request, SessionRepository $sessionRepository)
    {
        $this->response = $response;
        $this->sessionRepository = $sessionRepository;
        $this->request = $request;
    }

    /**
     * Get all sessions from database.
     */
    public function index()
    {
        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent(Session::all())
            ->send();
    }

    public function getByFormation() {
        $formationId = $this->request->query()->get('formationId');

        if (!$formationId) {
            $this->response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage('A formation id should be specified.')
                ->send(200, true);
        }

        $sessions = $this->sessionRepository->findByFormation($formationId);

        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($sessions)
            ->send();
    }

    /**
     * @throws \Exception
     */
    public function getByFormationsAndDate() {
        $formationsIds = $this->request->query()->get('formationsIds');
        $dateBefore = $this->request->query()->get('dateBefore');
        $dateAfter = $this->request->query()->get('dateAfter');

        if (!$formationsIds) {
            $this->response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage('At least one formation id should be specified.')
                ->send(200, true);
        }

        if (!is_array($formationsIds)) {
            $this->response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage('formationsIds must be of type array')
                ->send(200, true);
        }

        $sessions = $this->sessionRepository->findByFormationsAndDate($formationsIds, $dateBefore, $dateAfter);

        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($sessions)
            ->send();
    }
}
