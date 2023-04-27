<?php

namespace App\Domain\Service;

use App\Domain\Configuration\DriverConfig;
use App\Domain\PumpInterface;
use App\Domain\ValvesInterface;

class Initializer
{
    public function __construct(
        private readonly ValvesInterface $valves,
        private readonly PumpInterface $pump,
        private readonly DriverConfig $config
    ) {
    }

    public function initValves(): string
    {
        $identifiers = $this->config->getValveIdentifiers();
        $this->valves->initValves($identifiers);
        return $this->config->valveIdentifiers;
    }

    public function initPump(): string
    {
        $this->pump->initPump((int)$this->config->pumpIdentifier);
        return $this->config->pumpIdentifier;
    }
}