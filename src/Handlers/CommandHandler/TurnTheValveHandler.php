<?php

namespace App\Handlers\CommandHandler;

use App\Domain\Command\TurnTheValveCommand;
use App\Domain\Event\ValveStateChangedEvent;
use App\Domain\Service\ValvesControlling;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler()]
class TurnTheValveHandler
{
    public function __construct(
        private readonly ValvesControlling $valvesControlling,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(TurnTheValveCommand $command): void
    {
        if ($this->valvesControlling->turnTheValve($command->identifier, $command->state)) {
            $event = new ValveStateChangedEvent($command->identifier, $command->state);
            $this->messageBus->dispatch($event);
        }
    }
}