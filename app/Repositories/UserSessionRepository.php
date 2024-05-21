<?php

namespace App\Repositories;

use App\Models\UserSession;
use Carbon\Carbon;

class UserSessionRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return UserSession::class;
    }

    public function search($query, $column, $data)
    {
        return match ($column) {
            'month', 'year', 'user_id' => $query->where($column, $data),
            // search field will search by name or email
            'user', => $query->where('user_id', $data),
            default => $query,
        };
    }

    public function upsertUserSession($data, $userSessionDetail)
    {
        $currentDateTime = Carbon::now();
        $currentMonth = $currentDateTime->month;
        $currentYear = $currentDateTime->year;

        $userSession = $this->findByCondition([
            'user_id' => $data['user_id'],
            'month' => $currentMonth,
            'year' => $currentYear
        ])->first();

        $lateCount = $userSessionDetail->late ? 1 : 0;
        $leaveSoonCount = $userSessionDetail->leave_soon ? 1 : 0;

        $dataUpsert = [
            'user_id' => $data['user_id'],
            'month' => $currentMonth,
            'year' => $currentYear
        ];

        if(!$userSession) {
            // create
            $dataUpsert = array_merge($dataUpsert, [
                'late_count' => $lateCount,
                'leave_soon_count' => $leaveSoonCount
            ]);
            return $this->create($dataUpsert);
        }

        $lateCount = $lateCount + $userSession->late_count;
        $leaveSoonCount = $leaveSoonCount + $userSession->leave_soon_count;
        $dataUpsert = array_merge($dataUpsert, [
            'late_count' => $lateCount,
            'leave_soon_count' => $leaveSoonCount
        ]);
        return $this->update($userSession->id, $dataUpsert);
    }
}
