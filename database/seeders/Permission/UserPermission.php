<?php

namespace Database\Seeders\Permission;

use App\Http\Controllers\User\UserController;
use App\Models\Role;

class UserPermission extends BasePermission
{
    public const USER_PERMISSIONS = [
        [
            'name' => UserController::PERMISSION_USER_USERS_DESTROY,
        ],
        [
            'name' => UserController::PERMISSION_USER_USERS_SHOW,
        ],
        [
            'name' => UserController::PERMISSION_USER_USERS_UPDATE,
        ]
    ];

    public const SYSTEM_PERMISSIONS = [
        [
            'name' => UserController::PERMISSION_SYSTEM_USER_DESTROY,
        ],
        [
            'name' => UserController::PERMISSION_SYSTEM_USER_SHOW,
        ],
        [
            'name' => UserController::PERMISSION_SYSTEM_USER_INDEX,
        ]
    ];
}
