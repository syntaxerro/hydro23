<?php

namespace App\Tests\Fixtures\Entity;

use App\Domain\Entity\Enum\DayOfWeekEnum;
use App\Domain\Entity\Schedule;

class ScheduleMother
{
    public static function withIrrigationLineId(int $irrigationLineId): Schedule
    {
        return new Schedule($irrigationLineId, '11:00', DayOfWeekEnum::everyday->value, '5s');
    }

    public static function withIrrigationLineAndStartTime(int $irrigationLineId, string $startAt): Schedule
    {
        return new Schedule($irrigationLineId, $startAt, DayOfWeekEnum::everyday->value, '5s');
    }
}