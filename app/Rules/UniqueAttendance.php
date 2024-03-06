<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueAttendance implements ValidationRule
{

    private $startDate, $endDate, $startTime, $endTime, $typeId;

    public function __construct($startDate, $endDate, $startTime, $endTime, $typeId)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->typeId = $typeId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $startTime = $this->startTime;
        $endTime = $this->endTime;
        $createdById = auth()->user()->id;
        $attendanceType = $this->typeId;

        if(
            DB::table('attendances')
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->where('created_by_id', $createdById)
            ->where('type_id', $attendanceType)
            ->exists()
        ) $fail('This attendance exist! Try again');

        if($startDate == $endDate && $startTime > $endTime) {
            $fail('Chose end time again!');
        }
    }
}
