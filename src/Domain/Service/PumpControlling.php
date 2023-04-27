<?php

namespace App\Domain\Service;

use App\Domain\PumpInterface;

class PumpControlling
{
    public function __construct(
        private readonly PumpInterface $pump,
        private readonly ValvesControlling $valvesControlling
    ) {
    }

    public function enablePump(): bool
    {
        if ($this->pump->checkPumpState() || $this->valvesControlling->allValvesAreClosed()) {
            return false;
        }

        $this->pump->enablePump();
        return true;
    }

    public function disablePump(): bool
    {
        if (!$this->pump->checkPumpState()) {
            return false;
        }

        $this->pump->disablePump();
        return true;
    }
}