<?php

namespace App\Domain\Service;

use App\Domain\Configuration\DriverConfig;
use App\Domain\ValvesInterface;

class ValvesControlling
{
    public function __construct(
        private readonly ValvesInterface $valves,
        private readonly DriverConfig $config
    ) {
    }

    public function getAllValves(): array
    {
        $result = [];
        foreach ($this->config->getValveIdentifiers() as $identifier) {
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