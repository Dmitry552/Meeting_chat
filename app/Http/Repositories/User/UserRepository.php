<?php

namespace App\Http\Repositories\User;

use \App\Http\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * @param array $data
     * @param Model|null $model
     * @return LengthAwarePaginator
     */
    public function index(array $data, Model $model = null): LengthAwarePaginator
    {
        return $this->model::with('roles')->paginate($data['limit']);
    }
}
