<?php

namespace App\Tests\Fixtures\Entity;

use App\Domain\Entity\Schedule;

class ScheduleMother
{
    public static function withIrrigationLineId(int $irrigationLineId): Schedule
    {
        return new Schedule($irrigationLineId, '11:00', -1, '5s');
    }
}