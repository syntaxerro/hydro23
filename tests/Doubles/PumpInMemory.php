<?php

namespace App\Tests\Doubles;

use App\Domain\PumpInterface;

class PumpInMemory implements PumpInterface
{
    private ?int $pumpIdentifier = null;
    private bool $pumpState = false;

    public function enablePump(): void
    {
        if ($this->pumpIdentifier === null) {
            throw new \Exception('Pump isn\'t initialized');
        }
        $this->pumpState = true;
    }

    public function disablePump(): void
    {
        if ($this->pumpIdentifier === null) {
            throw new \Exception('Pump isn\'t initialized');
        }
        $this->pumpState = false;
    }

    public function checkPumpState(): bool
    {
        if ($this->pumpIdentifier === null) {
            throw new \Exception('Pump isn\'t initialized');
        }
        return $this->pumpState;
    }

    public function initPump(int $pumpIdentifier): void
    {
        $this->pumpIdentifier = $pumpIdentifier;
    }
}