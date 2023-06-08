<?php

namespace App\Domain\Service\Scheduler;

use App\Domain\Entity\Schedule;
use App\Domain\ValvesInterface;

class IrrigationLineHandler extends AbstractChainHandler implements ChainHandlerInterface
{
    public function __construct(private readonly ValvesInterface $valves)
    {
    }

    public function handle(Schedule $schedule): ?Schedule
    {
        $valvesState = $this->valves->readValveState($schedule->getIrrigationLineIdentifier());
        if ($valvesState) {
            return null;
        }

        return $this->next($schedule);
    }
}