<?php

namespace App\Events\VideoEvent;

class RelaySdp extends BaseVideoEvent
{
    public function __construct(string $roomName, string $interlocutorCode, array $data)
    {
        $channel = $roomName . '.' . $interlocutorCode;

        parent::__construct($channel, $data);
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * @return string
     */
    public function action(): string
    {
        return parent::SESSION_DESCRIPTION;
    }
}
