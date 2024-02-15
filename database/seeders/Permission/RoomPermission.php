<?php

namespace Database\Seeders\Permission;

use App\Http\Controllers\SystemRoomController;

class RoomPermission extends BasePermission
{
    public const SYSTEM_PERMISSIONS = [
        [
            'name' => SystemRoomController::PERMISSION_SYSTEM_ROOM_GET_BY_DATE,
        ],
    ];
}