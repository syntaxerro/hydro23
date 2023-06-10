<?php

namespace App\Tests\Unit\Commands\Schedule;

use App\Domain\Command\Schedule\PerformScheduleCommand;
use App\Domain\Event\PumpDisabledEvent;
use App\Domain\Event\PumpEnabledEvent;
use App\Domain\Event\ValveStateChangedEvent;
use App\Tests\Common\UnitTestCase;
use App\Tests\Fixtures\Entity\ScheduleMother;

class PerformScheduleCommandTest extends UnitTestCase
{
    /** @test */
    public function perform_schedule(): void
    {
        // given
        $givenIrrigationLineId = 1;
        $this->giveIrrigationLines([$givenIrrigationLineId]);
        $givenSchedule = ScheduleMother::withIrrigationLineId($givenIrrigationLineId);
        $this->giveSchedule($givenSchedule);

        // when
        $this->dispatchMessage(new PerformScheduleCommand($givenSchedule->getId()));

        // then
        $this->transport('sync')->acknowledged()->assertContains(PumpEnabledEvent::class);
        $this->transport('sync')->acknowledged()->assertContains(ValveStateChangedEvent::class);
    }
}