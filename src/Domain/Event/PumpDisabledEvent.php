<?php

namespace App\Domain\Event;

use App\Domain\Messages\EventInterface;
use App\Domain\Messages\WebsocketEventInterface;

class PumpDisabledEvent implements EventInterface, WebsocketEventInterface
{

}