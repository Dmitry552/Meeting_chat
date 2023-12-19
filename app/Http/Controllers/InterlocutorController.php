<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\InterlocutorCreateRequest;
use App\Http\Services\InterlocutorService;
use Illuminate\Http\JsonResponse;

class InterlocutorController extends Controller
{
    private InterlocutorService $service;
    public function __construct(InterlocutorService $service)
    {
        $this->service = $service;
    }

    public function store(InterlocutorCreateRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->all()));
    }
}
