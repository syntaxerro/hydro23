<?php

namespace App\Domain;

interface ValvesInterface
{
    public function readValveState(int $valveIdentifier): bool;

    public function writeValveState(int $valveIdentifier, bool $state): void;

    public function initValves(array $identifiers): void;
}