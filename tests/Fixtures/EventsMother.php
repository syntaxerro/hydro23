<?php

namespace App\Tests\Fixtures;

use App\Domain\Event\PumpDisabledEvent;
use App\Domain\Event\PumpEnabledEvent;
use App\Domain\Event\ValveStateChangedEvent;

class EventsMother
{
    const PumpDisabled = PumpDisabledEvent::class;
    const PumpEnabled = PumpEnabledEvent::class;
    const ValveStateChanged = ValveStateChangedEvent::class;
}