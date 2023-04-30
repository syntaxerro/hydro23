<?php

namespace App\Domain\Service;

use App\Domain\PumpInterface;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use App\Domain\ValvesInterface;

class Initializer
{
    public function __construct(
        private readonly ValvesInterface $valves,
        private readonly IrrigationLineRepositoryInterface $irrigationLineRepository,
        private readonly PumpInterface $pump,
        private readonly string $pumpGpioChannel
    ) {
    }

    public function initValves(): string
    {
        $identifiers = [];
        $lines = $this->irrigationLineRepository->findAll();
        foreach ($lines as $line) {
            $identifiers[] = $line->getIdentifier();
        }
        $this->valves->initValves($identifiers);
        return implode(',', $identifiers);
    }

    public function initPump(): string
    {
        $this->pump->initPump((int)$this->pumpGpioChannel);
        return $this->pumpGpioChannel;
    }
}