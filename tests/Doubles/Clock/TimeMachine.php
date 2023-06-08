<?php

namespace App\Tests\Doubles\Clock;

class TimeMachine
{
    private \DateTimeImmutable $datetime;

    public function __construct()
    {
        $this->datetime = new \DateTimeImmutable();
    }

    public function goTo(\DateTimeImmutable $datetime): void
    {
        $this->datetime = $datetime;
    }

    public function now(): \DateTimeImmutable
    {
        return $this->datetime;
    }
}