<?php

namespace App\Events\VideoEvent;

class LeaveRoom extends BaseVideoEvent
{
    public function __construct(string $roomName, array $data)
    {
        parent::__construct($roomName, $data);
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * @return string
     */
    public function action(): string
    {
        return parent::REMOVE_PEER;
    }
}
