<?php

namespace App\Domain\Event;

use App\Domain\Messages\EventInterface;
use App\Domain\Messages\WebsocketEventInterface;

class PumpEnabledEvent implements EventInterface, WebsocketEventInterface
{
}