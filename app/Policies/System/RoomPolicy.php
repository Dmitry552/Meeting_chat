<?php

namespace App\Policies\System;

use App\Http\Controllers\SystemRoomController;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    public function getRoomsBetweenDates(User $user): bool
    {
        if ($user->checkPermissionTo(SystemRoomController::PERMISSION_SYSTEM_ROOM_GET_BY_DATE)) {
            return true;
        }

        return false;
    }
}
