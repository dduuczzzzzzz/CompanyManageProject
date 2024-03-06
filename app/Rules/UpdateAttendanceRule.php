<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateAttendanceRule implements ValidationRule
{
    private $startDate, $endDate, $startTime, $endTime;

    public function __construct($startDate, $endDate, $startTime, $endTime)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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

        if($startDate == $endDate && $startTime > $endTime) {
            $fail('Chose end time again!');
        }
    }
}
