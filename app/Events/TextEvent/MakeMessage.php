<?php

namespace App\Events\TextEvent;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MakeMessage implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private $data;
    private $channelName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $channelName, array $data)
    {
        $this->channelName = $channelName;
        $this->data = $data;
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'MESSAGE';
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
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('textMeeting.' . $this->channelName);
    }
}
