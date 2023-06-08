<?php

namespace App\Domain\Command;

use App\Domain\Messages\CommandInterface;

class PerformScheduleCommand implements CommandInterface
{
    public function __construct(public readonly string $scheduleId)
    {
    }
}