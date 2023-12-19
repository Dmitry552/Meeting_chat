<?php

namespace App\Http\Repositories\Interlocutor;

use App\Http\Repositories\BaseRepository;
use App\Models\Interlocutor;

class InterlocutorRepository extends BaseRepository
{
    public function __construct(Interlocutor $model)
    {
        $this->model = $model;
    }
}
