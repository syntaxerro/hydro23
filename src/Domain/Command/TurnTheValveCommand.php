<?php

namespace App\Domain\Command;

use App\Domain\Messages\CommandInterface;

class TurnTheValveCommand implements CommandInterface
{
    public function __construct(
      public int $identifier,
      public bool $state
    ) {
    }
}