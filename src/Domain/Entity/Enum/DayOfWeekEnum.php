<?php

namespace App\Domain\Entity\Enum;

enum DayOfWeekEnum: int
{
    case everyday = -1;
    case monday = 0;
    case tuesday = 1;
    case wednesday = 2;
    case thursday = 3;
    case friday = 4;
    case saturday = 5;
    case sunday = 6;
}
