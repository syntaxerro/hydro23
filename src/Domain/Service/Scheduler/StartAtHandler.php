<?php

namespace App\Domain\Service\Scheduler;

use App\Domain\ClockInterface;
use App\Domain\Entity\Schedule;

class StartAtHandler extends AbstractChainHandler implements ChainHandlerInterface
{
    public function __construct(private readonly ClockInterface $clock)
    {
    }

    public function handle(Schedule $schedule): ?Schedule
    {
        if ($this->clock->now()->format('H:i') == $schedule->getStartAt()) {
            return $this->next($schedule);
        }

        return null;
    }
}