<?php

namespace App\Http\Repositories\Message;

use App\Http\Repositories\BaseRepository;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class MessageRepository extends BaseRepository
{
    public function __construct(Message $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @param Model $model
     * @return LengthAwarePaginator
     */
    public function index(array $data, Model $model): LengthAwarePaginator
    {
        /** @var Room $model */
        return $model->messages()->paginate($data['limit']);
    }
}
