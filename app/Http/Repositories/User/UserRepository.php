<?php

namespace App\Http\Repositories\User;

use \App\Http\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param string $email
     * @return User | null
     */
    public function getUserForEmail(string $email): User | null
    {
        /** @var User $user */
        $user = $this->model->query()->where('email', $email)->first();

        return $user;
    }
}