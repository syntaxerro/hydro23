<?php

namespace App\Handlers\CommandHandler\IrrigationLine;

use App\Domain\Command\IrrigationLine\RemoveIrrigationLineCommand;
use App\Domain\Event\IrrigationLinesReconfiguredEvent;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class RemoveIrrigationLineHandler
{
    public function __construct(
        private readonly IrrigationLineRepositoryInterface $irrigationLineRepository,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(RemoveIrrigationLineCommand $command): void
    {
        $line = $this->irrigationLineRepository->get($command->identifier);
        $this->irrigationLineRepository->delete($line);

        $this->messageBus->dispatch(new IrrigationLinesReconfiguredEvent());
    }
}