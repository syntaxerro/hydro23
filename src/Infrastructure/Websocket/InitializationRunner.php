<?php

namespace App\Infrastructure\Websocket;

use App\Domain\Service\Initializer;
use App\UI\CommandOutput;
use React\EventLoop\LoopInterface;

class InitializationRunner
{
    const INIT_DELAY_IN_SECONDS = 2;

    public function __construct(
        private readonly LoopInterface $loop,
        private readonly Initializer $initializer
    ) {
    }

    public function registerInitializer(): void
    {
        $this->loop->addTimer(self::INIT_DELAY_IN_SECONDS, function() {
            $valveIdentifiers = $this->initializer->initValves();
            CommandOutput::writeln('Initialized valves on channels: '. $valveIdentifiers);

            $pumpIdentifier = $this->initializer->initPump();
            CommandOutput::writeln('Initialized pump on channel: ' . $pumpIdentifier);
        });
    }
}