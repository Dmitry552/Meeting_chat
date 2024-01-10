<?php

namespace App\Events\VideoEvent;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class BaseVideoEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected const ADD_PEER = "ADD_PEER";
    protected const ADD_CURRENT_PEER = "ADD_CURRENT_PEER";
    protected const ICE_CANDIDATE = "ICE_CANDIDATE";
    protected const SESSION_DESCRIPTION = "SESSION_DESCRIPTION";
    protected const REMOVE_PEER = "REMOVE_PEER";
    protected const MUTED = "MUTED";

    protected string $channelName;
    protected array $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $channelName, array $data)
    {
        $this->channelName = $channelName;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return $this->action();
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return $this->data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('videoMeeting.' . $this->channelName);
    }
}
