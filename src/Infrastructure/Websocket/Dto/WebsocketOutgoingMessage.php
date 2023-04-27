<?php

namespace App\Infrastructure\Websocket\Dto;

use App\Domain\Messages\WebsocketEventInterface;
use JsonSerializable;

class WebsocketOutgoingMessage implements JsonSerializable
{
    public function __construct(
        public WebsocketEventInterface $event
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'eventName' => get_class($this->event),
            'event' => $this->event
        ];
    }
}