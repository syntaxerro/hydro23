<?php

namespace App\Handlers\QueryFinder;

use App\Domain\PumpInterface;
use App\Domain\Query\PumpStateQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PumpStateFinder
{
    public function __construct(private readonly PumpInterface $pump)
    {
    }

    public function __invoke(PumpStateQuery $query): bool
    {
        return $this->pump->checkPumpState();
    }
}