<?php

namespace App\Handlers\CommandHandler\IrrigationLine;

use App\Domain\Command\IrrigationLine\RemoveIrrigationLineCommand;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RemoveIrrigationLineHandler
{
    public function __construct(private readonly IrrigationLineRepositoryInterface $irrigationLineRepository)
    {
    }

    public function __invoke(RemoveIrrigationLineCommand $command): void
    {
        $line = $this->irrigationLineRepository->get($command->identifier);
        $this->irrigationLineRepository->delete($line);
    }
}