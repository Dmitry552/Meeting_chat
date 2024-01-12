<?php

namespace Room;

use Tests\Feature\Traits\UserAuthorizedTrait;
use Tests\TestCase;

abstract class BaseRoomTest extends TestCase
{
    use UserAuthorizedTrait;

    /**
     * Interlocutor
     */
    protected const ROUTE_INTERLOCUTOR_CREATE = 'api/interlocutor';
    protected const ROUTE_INTERLOCUTOR_DESTROY = 'api/interlocutor/';
    protected const ROUTE_INTERLOCUTOR_SHOW = 'api/interlocutor/';
    protected const ROUTE_GET_INTERLOCUTORS_ROOM = 'api/room/interlocutors/';

    /**
     * Room
     */
    protected const ROUTE_ROOM_CREATE = 'api/room/';
    protected const ROUTE_ADD_TO_ROOM = 'api/room/join/';
    protected const ROUTE_CHECK_ROOM = 'api/room/check/';
    protected const ROUTE_ROOM_SHOW = 'api/room/';

    /**
     * Video chat
     */
    protected const ROUTE_VIDEO_CHAT_JOINED = 'api/videoChat/join/';
    protected const ROUTE_VIDEO_CHAT_LEAVE = 'api/videoChat/leave/';
    protected const ROUTE_VIDEO_CHAT_RELAY_ICE = 'api/videoChat/relayIce/';
    protected const ROUTE_VIDEO_CHAT_RELAY_SDP = 'api/videoChat/relaySdp/';
    protected const ROUTE_VIDEO_CHAT_MUTE = 'api/videoChat/mute/';


    /**
     * Structures
     */
    protected function getInterlocutorStructure(): array
    {
        return [
            'id',
            'interlocutorName',
            'code',
            'user',
            'created_at',
            'updated_at'
        ];
    }

    protected function getInterlocutorsStructure(): array
    {
        return [
            '*' => [
                '*' => [
                    $this->getInterlocutorStructure()
                ]
            ]
        ];
    }

    protected function getRoomStructure(): array
    {
        return [
            'id',
            'name',
            'creator',
            'created_at',
            'updated_at'
        ];
    }
}
