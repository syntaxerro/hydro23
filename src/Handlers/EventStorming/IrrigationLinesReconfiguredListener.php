<?php

namespace App\Handlers\EventStorming;

use App\Domain\Event\IrrigationLinesReconfiguredEvent;
use App\Domain\Service\Initializer;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class IrrigationLinesReconfiguredListener
{
    public function __construct(
        private Initializer $initializer
    )
    {
    }

    public function __invoke(IrrigationLinesReconfiguredEvent $event): void
    {
        $this->initializer->initValves();
    }
}