<?php

namespace App\Http\Services;

use App\Http\Repositories\Message\MessageRepository;
use App\Http\Resources\MessageResource;
use App\Models\Interlocutor;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessageService
{
    private MessageRepository $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @param Room $room
     * @return array
     */
    public function getMessages(array $data, Room $room): array
    {
        $messages = $this->repository->index($data, $room);

        return [
            'data' => MessageResource::collection($messages)
        ];
    }

    public function create(array $data, Interlocutor $interlocutor): MessageResource
    {
        $message = $interlocutor->messages()->create([
           'content' => $data['content']
        ]);

        return new MessageResource($message);
    }

    public function destroy(Message $message): MessageResource
    {
        $this->repository->delete($message);

        return new MessageResource($message);
    }
}
