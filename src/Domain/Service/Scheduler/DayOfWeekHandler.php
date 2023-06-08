<?php

namespace App\Domain\Service\Scheduler;

use App\Domain\ClockInterface;
use App\Domain\Entity\Enum\DayOfWeekEnum;
use App\Domain\Entity\Schedule;

class DayOfWeekHandler extends AbstractChainHandler implements ChainHandlerInterface
{
    public function __construct(private readonly ClockInterface $clock)
    {
    }

    public function handle(Schedule $schedule): ?Schedule
    {
        if ($schedule->getDayOfWeek() == DayOfWeekEnum::everyday) {
            return $this->next($schedule);
        }

        $nowDayOfWeek = DayOfWeekEnum::tryFrom($this->clock->now()->format('N')-1);
        if ($schedule->getDayOfWeek() == $nowDayOfWeek) {
            return $this->next($schedule);
        }

        return null;
    }
}