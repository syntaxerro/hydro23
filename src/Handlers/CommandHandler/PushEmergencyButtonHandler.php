<?php

namespace App\Handlers\CommandHandler;

use App\Domain\Command\Pump\DisablePumpCommand;
use App\Domain\Command\PushEmergencyButtonCommand;
use App\Domain\Command\TurnTheValveCommand;
use App\Domain\Service\ValvesControlling;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class PushEmergencyButtonHandler
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly ValvesControlling $valvesControlling
    ) {
    }

    public function __invoke(PushEmergencyButtonCommand $command): void
    {
        $this->messageBus->dispatch(new DisablePumpCommand());
        foreach ($this->valvesControlling->getAllValves() as $identifier => $state) {
            $this->messageBus->dispatch(new TurnTheValveCommand($identifier, false));
        }
    }
}