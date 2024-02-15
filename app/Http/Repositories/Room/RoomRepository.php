<?php

namespace App\Http\Repositories\Room;

use App\Http\Repositories\BaseRepository;
use App\Models\Interlocutor;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RoomRepository extends BaseRepository
{
    public function __construct(Room $room)
    {
        $this->model = $room;
    }

    public function checkRoom(string $name): bool
    {
        return $this->model->query()
            ->where('name', $name)
            ->exists();
    }

    public function join(Room $room, Interlocutor $interlocutor): Room
    {
        $interlocutor->room_id = $room->id;
        $interlocutor->save();

        return $room;
    }

    public function roomsBetweenDates(array $data): Collection
    {
        $query = $this->model->query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, COUNT(name) as countRoom");

        if (empty($data['startDate'])) {
            $query->where('created_at', '<=', $data['endDate']);
        } elseif (empty($data['endDate'])) {
            $query->where('created_at', '>=', $data['startDate']);
        } else {
            $data['endDate'] = Carbon::create($data['endDate'])->addDay();
            $query->whereBetween('created_at', [$data['startDate'], $data['endDate']]);
        }

        return $query->groupByRaw("DATE_FORMAT(created_at, '%Y-%m-%d')")->get();
    }
}