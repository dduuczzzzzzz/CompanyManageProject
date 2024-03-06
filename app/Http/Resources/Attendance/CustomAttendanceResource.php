<?php

namespace App\Http\Resources\Attendance;

use App\Common\CommonConst;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Http\Resources\User\CustomUserResource;

class CustomAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type_name = $this->type->name;
        $managers = CustomUserResource::collection($this->manager);
        $manage_type = $this->manager_type->role_type ?? null;
        if($this->status == CommonConst::ATTENDANCE_ACCEPT) {
            $colors = CommonConst::ATTENDANCE_ACCEPT_COLOR;
        }
        else if ($this->status == CommonConst::ATTENDANCE_REJECT) {
            $colors = CommonConst::ATTENDANCE_REJECT_COLOR;
        }
        else {
            $colors = "";
        }
        if ($this->status == CommonConst::NOT_REVIEWED) {
            $statusString = "NOT REVIEWED";
        }else if ($this->status == CommonConst::ATTENDANCE_REJECT) {
            $statusString = " ATTENDANCE REJECT";
        }else $statusString = " ATTENDANCE ACCEPT";
        if ($this->approver_id) $approverName = $this->approver->name;
        else $approverName = '';
            return [
            'id' => $this->id,
            'color' => $colors,
            'title' => $this->user->name . ": " . $type_name,
            'start' => $this->start_date . "T" . $this->start_time,
            'end' => $this->end_date."T".$this->end_time,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
