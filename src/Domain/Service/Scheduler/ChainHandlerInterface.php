<?php

namespace App\Domain\Service\Scheduler;

use App\Domain\Entity\Schedule;

interface ChainHandlerInterface
{
    public function setNext(ChainHandlerInterface $next): void;

    public function handle(Schedule $schedule): ?Schedule;
}