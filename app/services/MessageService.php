<?php

namespace App\Service;

use App\Core\Session;

class MessageService
{
    private Session $session;

    const TYPE_SUCCESS = 'type-success';
    const TYPE_INFO = 'type-info';
    const TYPE_WARNING = 'type-warning';
    const TYPE_ERROR = 'type-error';

    public function __construct(Session $session)
    {
        $this->session = $session;

        if (!$this->session->has('messages')) {
            $this->session->set('messages', []);
        }
    }

    /**
     * Add a new message to message storage (session).
     *
     * @param string $title Title of the message.
     * @param string $body Body of the message.
     * @param string $type TYPE_SUCCESS|TYPE_INFO|TYPE_WARNING|TYPE_ERROR
     */
    public function add(string $title, string $body, string $type = self::TYPE_INFO)
    {
        // Get previous messages.
        $messages = $this->all();

        // Add a new one to previous messages.
        $messages[] = [
            'title' => $title,
            'body' => $body,
            'type' => $type
        ];

        // Update messages in session.
        $this->session->set('messages', $messages);
    }

    /**
     * Get all messages and clean ridden.
     *
     * @return Session|bool|mixed
     */
    public function read()
    {
        $messages = $this->all();

        $this->session->set('messages', []);

        return $messages;
    }

    /**
     * Juste get all messages in stored in session.
     *
     * @return Session|bool|mixed
     */
    private function all()
    {
        return $this->session->get('messages');
    }
}
