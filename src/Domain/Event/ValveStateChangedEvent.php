<?php

namespace App\Domain\Event;

use App\Domain\Messages\EventInterface;
use App\Domain\Messages\WebsocketEventInterface;

class ValveStateChangedEvent implements EventInterface, WebsocketEventInterface
{
    public function __construct(
        public int $identifier,
        public bool $state
    ) {
    }
}