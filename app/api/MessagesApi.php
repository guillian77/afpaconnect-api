<?php

namespace App\Api;

use App\Core\Request;
use App\Core\Session;
use App\Service\MessageService;
use App\Utility\Response;
use Exception;

/**
 * API to create or read messages.
 *
 * @MessagesApi
 * @package API
 * @author Aufrère Guillian
 * @version 1.0.0
 */
class MessagesApi
{
    private Request $request;

    private Response $response;

    private MessageService $messageService;

    public function __construct(
        Request $request,
        Response $response,
        MessageService $messageService
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->messageService = $messageService;
    }

    /**
     * Get all messages to read.
     */
    public function read()
    {
        $this->response
            ->setBodyContent($this->messageService->read())
            ->send(200);
    }

    /**
     * Create a new message.
     *
     * @throws Exception
     */
    public function create()
    {
        /*
         * Get message parameters from request.
         */
        $title = $this->request->request()->get('title');
        $body = $this->request->request()->get('body');
        $type = $this->request->request()->get('type');

        ($type === false) && $type = MessageService::TYPE_INFO;

        /*
         * Check parameters.
         */
        if (!$title || !$body) {
            $this->response
                ->setBodyContent('Missing message title or body.')
                ->send(200, true);
        }

        /*
         * Add a new message.
         */
        $this->messageService->add($title, $body, $type);

        $this->response
            ->setBodyContent('Message successfully added.')
            ->send(200);
    }
}