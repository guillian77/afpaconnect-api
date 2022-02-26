<?php

namespace Tests;

use App\Core\Session;
use App\Service\MessageService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class MessageServiceTest extends TestCase
{
    private MessageService $messageService;

    /**
     * @var Session|MockObject
     */
    private $session;

    public function setUp(): void
    {
        $this->session = new Session();
        $this->messageService = new MessageService($this->session);
    }

    public function testAdd()
    {
        $message = $this->messageDataProvider();
        $this->messageService->add($message['title'], $message['body']);

        $sessionMessage = $this->session->get('messages');
        $this->assertEquals(
            $this->messageDataProvider(),
            $sessionMessage[0]
        );
    }

    private function messageDataProvider(): array
    {
        return [
            'title' => 'Test title',
            'body' => 'Test content',
            'type' => MessageService::TYPE_INFO
        ];
    }
}
