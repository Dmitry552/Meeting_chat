<?php

namespace App\Events\VideoEvent;

class CurrentInterlocutorJoinedRoom extends BaseVideoEvent
{
    public function __construct(string $roomName, string $interlocutorCode, array $data)
    {
        $channel = $roomName . '.' . $interlocutorCode;

        parent::__construct($channel, $data);
    }

    /**
     * @return string
     */
    public function action(): string
    {
        return parent::ADD_PEER;
    }
}
