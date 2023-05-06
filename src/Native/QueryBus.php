<?php

namespace App\Native;

use App\Domain\Messages\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function runQuery(QueryInterface $query): mixed
    {
        $envelope = $this->messageBus->dispatch($query);
        $handledStamp = $envelope->last(HandledStamp::class);
        return $handledStamp->getResult();
    }
}