<?php

namespace App\Infrastructure\Websocket\Dto;

use JsonSerializable;

class WebsocketIncomingMessage implements JsonSerializable
{
    public function __construct(
        public string $command,
        public array $arguments = []
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'command' => $this->command,
            'arguments' => $this->arguments
        ];
    }
}