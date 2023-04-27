<?php

namespace App\Domain\Configuration;

class DriverConfig
{
    const VALVES_SEPARATOR = ',';
    public function __construct(
        public readonly string $pumpIdentifier,
        public readonly string $valveIdentifiers
    ) {
    }

    public function getValveIdentifiers(): array
    {
        return explode(self::VALVES_SEPARATOR, $this->valveIdentifiers);
    }
}