<?php

namespace App\Domain\Service\Scheduler;

use App\Domain\Entity\Schedule;

abstract class AbstractChainHandler
{
    protected ?ChainHandlerInterface $next = null;

    public function setNext(?ChainHandlerInterface $next): void
    {
        $this->next = $next;
    }

    public function next(Schedule $schedule): ?Schedule
    {
        if ($this->next === null) {
            return $schedule;
        }

        return $this->next->handle($schedule);
    }
}