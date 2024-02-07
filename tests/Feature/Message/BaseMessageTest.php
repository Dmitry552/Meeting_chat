<?php

namespace Message;

use Tests\Feature\Traits\UserAuthorizedTrait;
use \Tests\TestCase;

abstract class BaseMessageTest extends TestCase
{
    use UserAuthorizedTrait;

    /**
     * Messages
     */
    protected const ROUTE_MESSAGE_CREATE = 'api/textChat/message/';
    protected const ROUTE_MESSAGE_INDEX = 'api/textChat/';
    protected const ROUTE_MESSAGE_DESTROY = 'api/textChat/';

    protected function getMessagesContent(): array
    {
        return [
            'content' => 'Test message'
        ];
    }

    protected function getMessageStructure(): array
    {
        return [
            'id',
            'content',
            'interlocutor',
            'created_at',
            'updated_at'
        ];
    }

    protected function getMessagesStructure(): array
    {
        return [
            'data' => [
                '*' => $this->getMessageStructure()
            ]
        ];
    }
}