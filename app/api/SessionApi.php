<?php

namespace App\Api;

use App\Core\Request;
use App\Model\SessionRepository;
use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;

/**
 * API for session.
 * @SessionApi
 * @package API
 * @author Aufrère Guillian
 * @version 1.0.0
 */
class SessionApi
{
    private Response $response;
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository, Response $response)
    {
        $this->sessionRepository = $sessionRepository;
        $this->response = $response;
    }

    /**
     * Get one session by ID.
     *
     * @param Request $request
     *
     * @return void
     *
     * @throws Exception
     */
    public function session(Request $request)
    {
        $sessionId = $request->query()->get('session', null);

        if (!$sessionId) {
            $this->response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage('Missing session ID.')
                ->send();
        }

        $session = $this->sessionRepository->findOneById($sessionId);

        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($session)
            ->send();
    }

    /**
     * List all sessions.
     *
     * @return void
     */
    public function sessions()
    {
        $sessions = $this->sessionRepository->findAll();

        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($sessions)
            ->send();
    }
}
