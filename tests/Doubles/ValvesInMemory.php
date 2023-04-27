<?php

namespace App\Tests\Doubles;

use App\Domain\ValvesInterface;

class ValvesInMemory implements ValvesInterface
{
    private array $valves = [];

    public function readValveState(int $valveIdentifier): bool
    {
        if (!isset($this->valves[$valveIdentifier])) {
            throw new \LogicException('Cannot get value for uninitialized valve %s', $valveIdentifier);
        }

        return $this->valves[$valveIdentifier];
    }

    public function writeValveState(int $valveIdentifier, bool $state): void
    {
        if (!isset($this->valves[$valveIdentifier])) {
            throw new \LogicException('Cannot write uninitialized valve %s', $valveIdentifier);
        }

        $this->valves[$valveIdentifier] = $state;
    }

    public function initValves(array $identifiers): void
    {
        foreach ($identifiers as $identifier) {
            $this->valves[$identifier] = false;
        }
    }
}