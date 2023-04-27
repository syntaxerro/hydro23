<?php

namespace App\Infrastructure\Hardware;

use App\Domain\ValvesInterface;

class HardwareValves implements ValvesInterface
{
    public function __construct(
        private readonly GPIO $gpio
    ) {
    }

    public function readValveState(int $valveIdentifier): bool
    {
        return $this->gpio->readChannelValue($valveIdentifier);
    }

    public function writeValveState(int $valveIdentifier, bool $state): void
    {
        $this->gpio->writeChannelValue($valveIdentifier, $state);
    }

    public function initValves($identifiers): void
    {
        foreach ($identifiers as $identifier) {
            $this->gpio->enableGpioChannel($identifier);
            $this->gpio->markChannelAsOut($identifier);
            $this->gpio->writeChannelValue($identifier, false);
        }
    }
}