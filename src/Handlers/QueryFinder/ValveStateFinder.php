<?php

namespace App\Handlers\QueryFinder;

use App\Domain\Query\ValveStateQuery;
use App\Domain\ValvesInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ValveStateFinder
{
    public function __construct(private readonly ValvesInterface $valves)
    {
    }

    public function __invoke(ValveStateQuery $query): bool
    {
        return $this->valves->readValveState($query->valveIdentifier);
    }
}