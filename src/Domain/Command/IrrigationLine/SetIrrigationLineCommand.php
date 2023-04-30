<?php

namespace App\Domain\Command\IrrigationLine;

use App\Domain\Messages\CommandInterface;

class SetIrrigationLineCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public int $identifier
    ) {
    }
}