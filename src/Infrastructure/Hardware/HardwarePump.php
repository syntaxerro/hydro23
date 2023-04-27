<?php

namespace App\Infrastructure\Hardware;

use App\Domain\PumpInterface;

class HardwarePump implements PumpInterface
{
    private int $pumpIdentifier;

    public function __construct(
        private readonly GPIO $gpio
    ) {
    }
    
    public function enablePump(): void
    {
        $this->gpio->writeChannelValue($this->pumpIdentifier, true);
    }

    public function disablePump(): void
    {
        $this->gpio->writeChannelValue($this->pumpIdentifier, false);
    }

    public function checkPumpState(): bool
    {
        return $this->gpio->readChannelValue($this->pumpIdentifier);
    }

    public function initPump(int $pumpIdentifier): void
    {
        $this->pumpIdentifier = $pumpIdentifier;
        $this->gpio->enableGpioChannel($pumpIdentifier);
        $this->gpio->markChannelAsOut($pumpIdentifier);
        $this->gpio->writeChannelValue($pumpIdentifier, false);
    }
}