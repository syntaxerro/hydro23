<?php

namespace App\Domain\Command\IrrigationLine;

use App\Domain\Messages\CommandInterface;

class RemoveIrrigationLineCommand implements CommandInterface
{
    public function __construct(
        public int $identifier
    ) {
    }
}