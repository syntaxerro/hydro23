<?php

namespace App\Infrastructure\Hardware;

use App\Domain\ClockInterface;
use DateTimeImmutable;

class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now');
    }
}