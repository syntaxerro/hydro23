<?php

namespace App\Handlers\QueryFinder;

use App\Domain\Query\IrrigationLinesQuery;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class IrrigationLinesFinder
{
    public function __construct(private readonly IrrigationLineRepositoryInterface $irrigationLineRepository)
    {
    }

    public function __invoke(IrrigationLinesQuery $query): array
    {
        return $this->irrigationLineRepository->findAll();
    }
}