<?php

namespace App\Http\Controllers;

use App\Events\TextEvent\MakeMessage;
use App\Http\Requests\Message\MessageCreateRequest;
use App\Http\Requests\Message\MessageGetRequest;
use App\Http\Services\MessageService;
use App\Models\Interlocutor;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\JsonResponse;

class TextChatController extends Controller
{
    private MessageService $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param MessageGetRequest $request
     * @param Room $room
     * @return JsonResponse
     */
    public function index(MessageGetRequest $request, Room $room): JsonResponse
    {
        return response()->json($this->service->getMessages($request->all(), $room));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param MessageCreateRequest $request
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return JsonResponse
     */
    public function create(MessageCreateRequest $request, Room $room, Interlocutor $interlocutor): JsonResponse
    {
        $message = $this->service->create($request->all(), $interlocutor);

        event(new MakeMessage(
            $room->name,
            [
                'message' => $message
            ]
        ));

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function destroy(Message $message): JsonResponse
    {
        return response()->json($this->service->destroy($message));
    }
}
