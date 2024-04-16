<?php

namespace App\Repositories;

use App\Models\UserSessionDetail;
use Carbon\Carbon;

class UserSessionDetailRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return UserSessionDetail::class;
    }

    public function search($query, $column, $data)
    {
        return match ($column) {
            'date', 'user_id' => $query->where($column, $data),
            // search field will search by name or email
            'user', => $query->where('user_id', $data),
            default => $query,
        };
    }

    public function upsertUserSessionDetail($data, $userSessionDetail)
    {
        $now = Carbon::now();
        $startWorkTime = Carbon::now()->setHour(8)->setMinute(30)->setSecond(0);
        $endWorkTime = Carbon::now()->setHour(17)->setMinute(30)->setSecond(0);
        $late = false;
        $leaveSoon = false;

        if($now->gt($startWorkTime) && isset($data['get_check_in']) && $data['get_check_in'] == true) {
            $late = true;
        }

        if($now->lt($endWorkTime) && isset($data['get_check_out']) && $data['get_check_out'] == true) {
            $leaveSoon = false;
        }

        $data = array_merge($data, [
            'late' => $late,
            'leave_soon' => $leaveSoon
        ]);

        if($userSessionDetail) {
            return $this->update($userSessionDetail->id, $data);
        }

        return $this->create($data);
    }
}
