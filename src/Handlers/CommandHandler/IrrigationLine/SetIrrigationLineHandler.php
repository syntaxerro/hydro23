<?php

namespace App\Handlers\CommandHandler\IrrigationLine;

use App\Domain\Command\IrrigationLine\SetIrrigationLineCommand;
use App\Domain\Entity\IrrigationLine;
use App\Domain\Event\IrrigationLinesReconfiguredEvent;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class SetIrrigationLineHandler
{
    public function __construct(
        private readonly IrrigationLineRepositoryInterface $irrigationLineRepository,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(SetIrrigationLineCommand $command): void
    {
        $this->irrigationLineRepository->save(
            new IrrigationLine($command->identifier, $command->name)
        );

        $this->messageBus->dispatch(new IrrigationLinesReconfiguredEvent());
    }
}