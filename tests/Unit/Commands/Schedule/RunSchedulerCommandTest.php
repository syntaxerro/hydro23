<?php

namespace App\Tests\Unit\Commands\Schedule;

use App\Domain\Command\Schedule\PerformScheduleCommand;
use App\Domain\Command\Schedule\RunSchedulerCommand;
use App\Tests\Common\UnitTestCase;
use App\Tests\Fixtures\Entity\ScheduleMother;

class RunSchedulerCommandTest extends UnitTestCase
{
    /** @test */
    public function dont_turn_on_valve_if_time_has_not_come(): void
    {
        // given
        $this->timeMachine->goTo(new \DateTimeImmutable('2023-06-25 06:45'));
        $this->giveIrrigationLines([1]);
        $givenSchedule = ScheduleMother::withIrrigationLineAndStartTime(1, '06:50');
        $this->giveSchedule($givenSchedule);

        // when
        $this->dispatchMessage(new RunSchedulerCommand());
        $this->transport('async')->process();

        // then
        $this->transport('async')->acknowledged()->assertNotContains(PerformScheduleCommand::class);
    }

    /** @test */
    public function dont_turn_on_valve_if_time_has_not_passed(): void
    {
        // given
        $this->timeMachine->goTo(new \DateTimeImmutable('2023-06-25 06:51'));
        $this->giveIrrigationLines([1]);
        $givenSchedule = ScheduleMother::withIrrigationLineAndStartTime(1, '06:50');
        $this->giveSchedule($givenSchedule);

        // when
        $this->dispatchMessage(new RunSchedulerCommand());
        $this->transport('async')->process();

        // then
        $this->transport('async')->acknowledged()->assertNotContains(PerformScheduleCommand::class);
    }

    /** @test */
    public function turn_on_valve_if_time_is_come(): void
    {
        // given
        $this->timeMachine->goTo(new \DateTimeImmutable('2023-06-25 06:50'));
        $this->giveIrrigationLines([1]);
        $givenSchedule = ScheduleMother::withIrrigationLineAndStartTime(1, '06:50');
        $this->giveSchedule($givenSchedule);

        // when
        $this->dispatchMessage(new RunSchedulerCommand());
        $this->transport('async')->process();

        // then
        $this->transport('async')->acknowledged()->assertContains(PerformScheduleCommand::class);
    }
}