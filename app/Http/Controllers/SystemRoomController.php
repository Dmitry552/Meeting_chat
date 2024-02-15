<?php

namespace App\Http\Controllers;

use App\Http\Requests\System\Room\RoomsBetweenDatesRequest;
use App\Http\Services\RoomService;
use App\Models\Room;
use Illuminate\Http\JsonResponse;

class SystemRoomController extends Controller
{
    /**
     * PERMISSION_YYYY_DDDD_AAAA = 'pesmision yyyy dddd aaaa'
     *
     * YYYY(yyyy) - who is doing
     * DDDD(dddd) - where does it do
     * AAAA(aaaa) - what is he doing
     */
    public const PERMISSION_SYSTEM_ROOM_GET_BY_DATE = 'permission system room get by date';

    private RoomService $service;

    public function __construct(RoomService $service)
    {
        $this->service = $service;
    }

    public function getRoomsBetweenDates(RoomsBetweenDatesRequest $request): JsonResponse
    {
        $this->authorize('getRoomsBetweenDates', Room::class);

        return response()->json($this->service->getRoomsBetweenDates($request->all()));
    }
}
