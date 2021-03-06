<?php

declare(strict_types=1);

namespace App\FinalSol;

use Assert\Assertion;

class WorkHours
{
    /**
     * @var WorkHoursPerDay[]
     */
    private $days;

    public function __construct(array $work_hours_array)
    {
        Assertion::count($work_hours_array, 7, '應該要有一週的工時資料');
        Assertion::allInteger($work_hours_array, '工時資料應該為數字');
        Assertion::allRange($work_hours_array, 0, 16, '工時資料應該為 0 - 16 的數字');

        foreach ($work_hours_array as $index => $hours) {
            $this->days[] = WorkHoursPerDay::create($index, $hours);
        }
    }

    /**
     * @return WorkHoursPerDay[]
     */
    public function days()
    {
        return $this->days;
    }

    public function regularHours(): int
    {
        $total_regular_hours = 0;
        foreach ($this->days as $work_hours_per_day) {
            if (! $work_hours_per_day->isWorkday()) {
                continue;
            }
            $total_regular_hours += min($work_hours_per_day->hours(), 8);
        }

        return $total_regular_hours;
    }

    public function changeDayHours(DayName $day_name, \Closure $closure): WorkHours
    {
        $new_work_hours = clone $this;
        foreach ($new_work_hours->days as $index => $day) {
            if ($day->dayName()->equals($day_name)) {
                $new_work_hours->days[$index] = new WorkHoursPerDay($day_name, $closure($day->hours()), $day->isWorkday());
            }
        }

        return $new_work_hours;
    }
}