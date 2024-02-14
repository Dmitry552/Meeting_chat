<?php

namespace App\Policies;

use App\Http\Controllers\User\UserController;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return bool
     */
    public function systemIndex(User $user): bool
    {
        return $user->checkPermissionTo(UserController::PERMISSION_SYSTEM_USER_INDEX);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return bool
     */
    public function show(User $user, User $model): bool
    {
        if ($user->checkPermissionTo(UserController::PERMISSION_SYSTEM_USER_SHOW)) {
            return true;
        } elseif (
            $user->checkPermissionTo(UserController::PERMISSION_USER_USERS_SHOW)
            && $user->id === $model->id
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        if ($user->checkPermissionTo(UserController::PERMISSION_USER_USERS_UPDATE)
            && $user->id === $model->id
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->checkPermissionTo(UserController::PERMISSION_SYSTEM_USER_DESTROY)) {
            return true;
        } elseif ($user->checkPermissionTo(UserController::PERMISSION_USER_USERS_DESTROY)
            && $user->id === $model->id) {
            return true;
        }

        return false;
    }
}
