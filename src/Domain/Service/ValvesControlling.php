<?php

namespace App\Domain\Service;

use App\Domain\Repository\IrrigationLineRepositoryInterface;
use App\Domain\ValvesInterface;

class ValvesControlling
{
    public function __construct(
        private readonly ValvesInterface $valves,
        private readonly IrrigationLineRepositoryInterface $irrigationLineRepository
    ) {
    }

    public function getAllValves(): array
    {
        $result = [];
        foreach ($this->irrigationLineRepository->findAll() as $irrigationLine) {
            $identifier = $irrigationLine->getIdentifier();
            $result[$identifier] = $this->valves->readValveState($identifier);
        }
        return $result;
    }

    public function turnTheValve(int $identifier, bool $openValve): bool
    {
        if ($this->valves->readValveState($identifier) == $openValve) {
            return false;
        }

        $this->valves->writeValveState($identifier, $openValve);
        return true;
    }

    public function allValvesAreClosed(): bool
    {
        $allValvesAreClosed = true;
        foreach ($this->getAllValves() as $state) {
            if ($state) {
                $allValvesAreClosed = false;
            }
        }
        return $allValvesAreClosed;
    }
}