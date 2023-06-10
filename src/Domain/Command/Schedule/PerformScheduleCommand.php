<?php

namespace App\Domain\Command\Schedule;

use App\Domain\Messages\CommandInterface;

class PerformScheduleCommand implements CommandInterface
{
    public function __construct(public readonly string $scheduleId)
    {
    }
}