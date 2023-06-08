<?php

namespace App\Domain;

use DateTimeImmutable;

interface ClockInterface
{
    public function now(): DateTimeImmutable;
}