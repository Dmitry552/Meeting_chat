<?php

namespace App\Events\VideoEvent;

class MuteStream extends BaseVideoEvent
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
        return parent::MUTED;
    }
}
