<?php

namespace App\Handlers\CommandHandler\Pump;

use App\Domain\Command\Pump\EnablePumpCommand;
use App\Domain\Event\PumpEnabledEvent;
use App\Domain\Service\PumpControlling;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class EnablePumpHandler
{
    public function __construct(
        private readonly PumpControlling $pumpControlling,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(EnablePumpCommand $command): void
    {
        if ($this->pumpControlling->enablePump()) {
            $pumpEnabled = new PumpEnabledEvent();
            $this->messageBus->dispatch($pumpEnabled);
        }
    }
}