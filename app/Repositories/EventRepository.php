<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository extends BaseRepository
{

    protected function getModel()
    {
        return Event::class;
    }

    public function search($query, $column, $data)
    {
        return match ($column) {
            'name', 'location' => $query->where($column, 'like', "%${data}%"),
            'type_id' => $query->where($column, $data),
            'date' => $query->whereDate('start_time', '<=', $data)->whereDate('end_time', '>=', $data),
            default => $query,
        };
    }
}
