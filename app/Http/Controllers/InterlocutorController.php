<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\InterlocutorCreateRequest;
use App\Http\Services\InterlocutorService;
use App\Models\Room;
use Illuminate\Http\JsonResponse;

class InterlocutorController extends Controller
{
    private InterlocutorService $service;

    public function __construct(InterlocutorService $service)
    {
        $this->service = $service;
    }

    /**
     * Returns the interlocutors of the room
     *
     * @param Room $room
     * @return JsonResponse
     */
    public function interlocutorsRoom(Room $room): JsonResponse
    {
        return response()->json($this->service->interlocutorsRoom($room));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InterlocutorCreateRequest $request
     * @return JsonResponse
     */
    public function store(InterlocutorCreateRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->all()));
    }
}
