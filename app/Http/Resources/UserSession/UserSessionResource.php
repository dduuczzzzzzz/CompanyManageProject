<?php

namespace App\Http\Resources\UserSession;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'month' => $this->month,
            'year' => $this->year,
            'late_count' => $this->late_count,
            'leave_soon_count' => $this->leave_soon_count,
            'user_name' => $this->user->name
        ];
    }
}
