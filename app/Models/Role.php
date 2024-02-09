<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    public const NAME_SUPER_ADMIN = 'super_admin';
    public const NAME_SYSTEM_USER = 'system-user';
    public const NAME_USER = 'user';
}
