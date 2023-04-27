<?php

namespace App\Domain;

interface PumpInterface
{
    public function enablePump(): void;

    public function disablePump(): void;

    public function checkPumpState(): bool;

    public function initPump(int $pumpIdentifier): void;
}