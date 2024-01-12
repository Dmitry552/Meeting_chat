<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\RoomCreateRequest;
use App\Http\Services\RoomService;
use App\Models\Interlocutor;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    private RoomService $service;

    public function __construct(RoomService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomCreateRequest $request
     * @param Interlocutor $interlocutor
     * @return Response
     */
    public function store(RoomCreateRequest $request, Interlocutor $interlocutor): Response
    {
        $this->service->create($request->all(), $interlocutor);

        return response()->noContent();
    }

    /**
     * @param string $name
     * @return Response
     */
    public function check(string $name): Response
    {
        return response($this->service->check($name));
    }

    /**
     * Display the specified resource.
     *
     * @param  Room  $room
     * @return JsonResponse
     */
    public function show(Room $room): JsonResponse
    {
        return response()->json($this->service->show($room));
    }

    /**
     * Join the room
     *
     * @param Room $room
     * @param Interlocutor $interlocutor
     * @return Response
     */
    public function joinRoom(Room $room, Interlocutor $interlocutor): Response
    {
        $this->service->joinRoom($room, $interlocutor);

        return response()->noContent();
    }
}
