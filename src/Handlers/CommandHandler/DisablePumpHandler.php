<?php

namespace App\Handlers\CommandHandler;

use App\Domain\Command\DisablePumpCommand;
use App\Domain\Event\PumpDisabledEvent;
use App\Domain\Service\PumpControlling;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class DisablePumpHandler
{
    public function __construct(
        private readonly PumpControlling $pumpControlling,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(DisablePumpCommand $command): void
    {
        if ($this->pumpControlling->disablePump()) {
            $pumpEnabled = new PumpDisabledEvent();
            $this->messageBus->dispatch($pumpEnabled);
        }
    }
}