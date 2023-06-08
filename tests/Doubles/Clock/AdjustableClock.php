<?php

namespace App\Tests\Doubles\Clock;

use App\Domain\ClockInterface;
use DateTimeImmutable;

class AdjustableClock implements ClockInterface
{
    public function __construct(private readonly TimeMachine $timeMachine)
    {
    }

    public function now(): DateTimeImmutable
    {
        return $this->timeMachine->now();
    }
}