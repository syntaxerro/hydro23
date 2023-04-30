<?php

namespace App\Handlers\EventStorming;

use App\Domain\Command\Pump\DisablePumpCommand;
use App\Domain\Event\ValveStateChangedEvent;
use App\Domain\PumpInterface;
use App\Domain\Service\ValvesControlling;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class ValveStateChangedListener
{
    public function __construct(
        private readonly PumpInterface $pump,
        private readonly ValvesControlling $valvesControlling,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(ValveStateChangedEvent $event): void
    {
        if ($this->pump->checkPumpState() && $this->valvesControlling->allValvesAreClosed()) {
            $this->messageBus->dispatch(new DisablePumpCommand());
        }
    }
}